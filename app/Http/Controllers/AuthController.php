<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 *
 */
class AuthController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {

    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {

    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        
    }

}
