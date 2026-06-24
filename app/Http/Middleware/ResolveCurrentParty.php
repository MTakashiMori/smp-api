<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveCurrentParty
{
    public function __construct(private TenantContext $tenantContext)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->tenantContext->initialize($request);

        if ($this->tenantContext->partyId()) {
            $request->attributes->set('current_party_id', $this->tenantContext->partyId());
            $request->attributes->set('current_party', $this->tenantContext->party());
        }

        return $next($request);
    }
}
