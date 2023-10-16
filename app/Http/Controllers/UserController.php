<?php

namespace App\Http\Controllers;

use App\Helpers\RemoveDirectory;
use App\Http\Models\User;
use App\Http\Responses\UserCollectionResponse;
use App\Http\Responses\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return UserCollectionResponse|JsonResponse
     */
    public function index(Request $request)
    {
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $query = $userModel->newQuery();

        if ($request->has("search_key") != null && $request->has("search_value") != null) {
            if (str_contains($request->query("search_value"), ',')) {
                $array = explode(',', $request->query("search_value"));

                $query->orWhereIn($request->query("search_key"), $array);

            } else {
                $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
            }
        }

        $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

        /** @var LengthAwarePaginator $paginator */
        if ($request->has('limit')) {
            $paginator = $query->paginate($request->input('limit'))->appends($request->query());
        } else {
            $total = $query->count();
            $paginator = $query->paginate($total);
        }

        $users = $paginator->getCollection();

        return new UserCollectionResponse($users, $paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return UserResponse|JsonResponse
     */
    public function show(User $user)
    {
        return new UserResponse($user);
    }

    public function profilePhoto(Request $request)
    {
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $userModel = new User();
                $userModel->setConnection($request->header('DB-Connection'));

                $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

                $interaction = [];

                $interaction['log_alterado_data'] = date('Y/m/d H:m:s', time());
                $interaction['log_alterado_usuario_id'] = $user->id;

                $fileName = md5(uniqid(rand(), true));
                $extension = $request->file('image')->extension();

                $file = $request->file('image');
                $destinationPath = public_path() . '/usuario/' . $user->id;

                (new RemoveDirectory)->path($destinationPath);

                mkdir($destinationPath, 0777, true);

                $image = Image::make($file->path());

                $image->fit(640, 640, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName . '.' . $extension, 80);

                $data = array_merge(['foto' => $fileName . '.' . $extension], $interaction);

                $userModel = new User();
                $userModel->setConnection($request->header('DB-Connection'));

                $user = $userModel->newQuery()->findOrFail($user->id);
                $user->update($data);

                return new UserResponse($user);
            }
        }
    }
}
