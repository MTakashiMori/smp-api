<?php

namespace App\Http\Middleware;

use App\Constants\ResponseMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        $partyId = $this->resolvePartyId($request);

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

    private function resolvePartyId(Request $request): ?string
    {
        $routeParty = $request->route('party');

        if (is_object($routeParty) && isset($routeParty->id)) {
            return $routeParty->id;
        }

        return $request->header('X-Party-Id')
            ?: $request->input('party_id')
            ?: (is_string($routeParty) ? $routeParty : null);
    }
}
