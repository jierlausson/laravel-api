<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckRouteExists
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get route collection
        $routes = Route::getRoutes();

        $uri = $request->create($request->path(), $request->method());

        try {
            $routes->match($uri);
            return $next($request);
        } catch (NotFoundHttpException $e) {
            $errors = ['code' => 404];

            if (preg_match('/\/en\//', $uri)) {
                $errors['title'] = 'URL not found.';
                $errors['description'] = 'The provided URI is not valid(not found).';
            } else {
                $errors['title'] = 'URL não encontrada.';
                $errors['description'] = 'A URL informada não é valida(não foi encontrada).';
            }

            return response()->json(['errors' => $errors], Response::HTTP_NOT_FOUND);
        }
    }
}
