<?php
declare(strict_types=1);

namespace Service;

use Repository\DashboardRepository;

class DashboardService
{
    public function __construct(private DashboardRepository $dashboardRepository)
    {
    }

    public function getAllVtuberData()
    {
        return $this->dashboardRepository->fetchVtuberRecords();
    }

    /**
     * ユーザーが選択したchannelIdとユーザーが登録しているchannelIdを比較する
     * @return array 未登録のChannelId
     */
    public function compareRegisteredChannelIds(array $selectedChannelIds, string $userId): array
    {
        $registeredChannelIds = $this->dashboardRepository->fetchRegisteredChannelIds($userId);

        return array_diff($selectedChannelIds, $registeredChannelIds);
    }
}