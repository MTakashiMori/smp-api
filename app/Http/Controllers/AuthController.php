<?php

namespace App\Http\Controllers;

use App\Constants\MessagesConstants;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Support\TenantContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *
 */
class AuthController extends Controller
{
    public function __construct(private TenantContext $tenantContext)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     *
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
    public function register(RegisterRequest $request)
    {
        try {
            $input = $request->validated();

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'telephone' => $input['telephone'],
                'cpf' => $input['cpf'] ?? null,
                'password' => Hash::make($input['password']),
            ]);
    
            $token = JWTAuth::fromUser($user);
    
            return response()->json([
                'data' => $this->authenticatedUserPayload($user),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => MessagesConstants::ERROR,
            ], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {

    }

    public function getUser(Request $request)
    {
        $this->tenantContext->initialize($request);

        return response()->json([
            'data' => $this->authenticatedUserPayload(auth()->userOrFail()),
            'access_token' =>  request()->bearerToken(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function authenticatedUserPayload(User $user): array
    {
        if ($this->tenantContext->partyId() && $user->current_party_id !== $this->tenantContext->partyId()) {
            $user->forceFill(['current_party_id' => $this->tenantContext->partyId()])->save();
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'telephone' => $user->telephone,
            'current_party_id' => $user->current_party_id,
            'userRoles' => $user->roleNames(),
            'roles' => $user->roleNames(),
            'permissions' => $user->permissionNames(),
            'partyAcl' => $user->aclByParty(),
        ];
    }

}
