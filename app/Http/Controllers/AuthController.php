<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'data' => $this->authenticatedUserPayload($user),
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

    public function getUser()
    {
        return response()->json([
            'data' => $this->authenticatedUserPayload(auth()->userOrFail()),
            'access_token' =>  request()->bearerToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function authenticatedUserPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'telephone' => $user->telephone,
            'userRoles' => $user->roleNames(),
            'roles' => $user->roleNames(),
            'permissions' => $user->permissionNames(),
            'partyAcl' => $user->aclByParty(),
        ];
    }

}
