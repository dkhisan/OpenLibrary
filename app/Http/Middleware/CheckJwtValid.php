<?php

namespace OpenLibrary\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckJwtValid extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch(TokenExpiredException $e) {
            return response()->json([
                'message' => 'O token informado expirou.'
            ], 401);
        } catch(TokenInvalidException $e) {
            return response()->json([
                'message' => 'O token informado não é válido.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Não foi possível decodificar o token, talvez não tenha sido fornecido.'
            ], 401);
        }

        return $next($request);
    }
}
