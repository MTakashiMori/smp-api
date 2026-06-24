<?php

namespace App\Http\Middleware;

use App\Constants\ResponseMessages;
use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function __construct(private TenantContext $tenantContext)
    {
    }

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $partyId = $this->tenantContext->partyId();

        if (!$user) {
            return response()->json([
                'message' => ResponseMessages::NOT_AUTHORIZED,
            ], 401);
        }

        if (!$user->hasRole($roles, $partyId)) {
            return response()->json([
                'message' => ResponseMessages::NOT_AUTHORIZED,
            ], 403);
        }

        return $next($request);
    }
}
