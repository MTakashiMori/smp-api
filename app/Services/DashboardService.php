<?php

namespace App\Services;

class DashboardService extends MainService
{
    private PartyService $partyService;

    public function __construct(PartyService $partyService)
    {
        $this->partyService = $partyService;
    }

    public function getSuperAdminDashboard()
    {
        return [
            'parties_count' => $this->partyService->indexCount(['status' => ['active', 'scheduled', 'imported', 'fulfilled']]),
            'parties_fulfilled' => $this->partyService->indexCount(['status' => 'fulfilled']),
            'parties_future' => $this->partyService->indexCount(['status' => 'scheduled']),
        ];
    }

    public function getAdminDashboard()
    {

    }
    public function getSalesDashboard()
    {

    }

}
