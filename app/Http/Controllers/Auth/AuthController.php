<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\InputValidationException;
use App\Http\Controllers\Controller;
use App\Http\Models\GeneralSetting;
use App\Http\Models\LevelSetting;
use App\Http\Models\Observe;
use App\Http\Models\User;
use App\Http\Models\UserSector;
use App\Http\Responses\UserResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var string
     */
    private string $passwordPrefix = 'yi#b%KzwzHxePwtIuQW&ptI#pQgr*IPB';

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws InputValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'matricula' => 'required|string',
            'senha' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InputValidationException($validator->errors()->getMessages());
        }

        //        bCrypt login
        //        $input = $request->only(['email', 'password']);
        //        if (!Auth::attempt($input)) {
        //            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        //        }

        //        md5 login
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()
            ->where('matricula', $request->get('matricula'))
            ->where('senha', md5($this->passwordPrefix . $request->get('senha')))
            ->first();

        if (!$user) return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        if ($user->situacao != "Ativo") return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);

        $user->update([
            'app_token_notificacao' => $request->header('FCM-Token'),
        ]);

        $tokenResult = $user->createToken($user->matricula);

        return response()->json([
            'data' => [
                'type' => 'token',
                'id' => $user->id,
                'attributes' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ]
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws InputValidationException
     */
    public function validateUUID(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InputValidationException($validator->errors()->getMessages());
        }

        $uuidArray = explode('&conexao=', $request->get('uuid'));

        $userModel = new User();
        $userModel->setConnection($uuidArray[1]);
        $user = $userModel->newQuery()->where('uuid', $uuidArray[0])->first();

        if (is_null($user)) return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        if ($user->situacao != "Ativo") return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);

        $user->update([
            'app_token_notificacao' => $request->header('FCM-Token'),
        ]);

        $tokenResult = $user->createToken($user->matricula);

        return response()->json([
            'data' => [
                'type' => 'token',
                'id' => $user->id,
                'attributes' => [
                    'database' => $uuidArray[1],
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
                ]
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     *
     * @return UserResponse
     */
    public function user(Request $request): UserResponse
    {
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $levelSettingModel = new LevelSetting();
        $levelSettingModel->setConnection($request->header('DB-Connection'));

        $levelSetting = $levelSettingModel->newQuery()->findOrFail($user->nivel_id);

        $user->nivel = $levelSetting->nome;
        $user->formato_meta = $levelSetting->meta;
        $user->quantidade_meta_observacoes = $levelSetting->quantidade;

        $currentDate = Carbon::now();

        $initialDate = Carbon::parse($currentDate)->startOfMonth();
        $lastDate = Carbon::parse($currentDate);

        $numberOfDaysInMonth = Carbon::parse($initialDate)->daysInMonth;

        $lastDate->day($numberOfDaysInMonth);

        if ($levelSetting->meta == 'Quinzenal') {
            $currentDay = $currentDate->day;

            if ($currentDay > 15) {
                $initialDate->day(16);
            } else {
                $lastDate->day(15);
            }
        }

        $observesModel = new Observe();
        $observesModel->setConnection($request->header('DB-Connection'));

        $observesCount = $observesModel->newQuery()
            ->where('usuario_id', $user->id)
            ->whereBetween('log_cadastro_data', [$initialDate->format('Y-m-d H:m:s'), $lastDate->format('Y-m-d H:m:s')])
            ->count();

        $user->quantidade_observacoes_realizadas = $observesCount;

        $user->ciclo_inicial = $initialDate->format('Y-m-d');
        $user->ciclo_final = $lastDate->format('Y-m-d');

        $userSectorModel = new UserSector();
        $userSectorModel->setConnection($request->header('DB-Connection'));

        $isApprover = $userSectorModel->newQuery()
            ->where('usuario_id', $user->id)
            ->count();

        $isApprover > 0 ? $user->aprova_ausencia = true : $user->aprova_ausencia = false;

        $generalSettingModel = new GeneralSetting();
        $generalSettingModel->setConnection($request->header('DB-Connection'));

        $generalSetting = $generalSettingModel->newQuery()->first();
        $user->generalSetting = $generalSetting;

        return new UserResponse($user);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Você foi deslogado!']);
    }

    /**
     * @return JsonResponse
     */
    public function redirectLogin(): JsonResponse
    {
        return response()->json([
            'errors' => [
                'code' => 401,
                'title' => 'Token não encontrado.',
                'detail' => 'Você não está conectado! Seu token expirou e/ou é inválido, por favor realize o login novamente para se autenticar.'
            ]], Response::HTTP_UNAUTHORIZED);
    }
}
