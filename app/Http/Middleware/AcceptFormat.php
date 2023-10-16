<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AcceptFormat
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Accept') != 'application/vnd.api+json') {
            return response()->json('', Response::HTTP_BAD_REQUEST);
        }

        if (!str_contains($request->url(), 'auth/login') && !str_contains($request->url(), 'auth/validate-uuid')) {
            if (!$request->header('FCM-Token')) {
                return response()->json('', Response::HTTP_BAD_REQUEST);
            } else {
                $userModel = new User();
                $userModel->setConnection($request->header('DB-Connection'));

                $user = $userModel->newQuery()
                    ->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))
                    ->first();

                if (is_null($user)) return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
