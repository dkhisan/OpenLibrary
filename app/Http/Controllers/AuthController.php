<?php

namespace OpenLibrary\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use JWTAuth;
use OpenLibrary\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255'
            ]);

            $credentials = $request->only(['email', 'password']);
            $token = auth()->attempt($credentials);

            if ($token) {
                $type = 'bearer';
                $expires = auth()->factory()->getTTL();
    
                return response()->json([
                    'user' => auth()->user(),
                    'access_token' => $token,
                    'token_type' => $type,
                    'expires_in' => $expires
                ]);
            }

            return response()->json([
                'message' => 'O usuário ou senha não estão corretos.'
            ], 401);
        } catch(JWTException $e) {
            return response()->json([
                'message' => 'Não foi possível criar um token.'
            ], 500);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Desconectado com êxito.']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $refresh = auth()->refresh();

        return response()->json($refresh);
    }

    public function verify()
    {
        $user = auth()->user();

        return response()->json($user);
    }
}
