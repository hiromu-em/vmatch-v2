<?php
declare(strict_types=1);

namespace Controller;

use Core\ViewRenderer;
use Core\Request;
use Core\Session;
use Core\Response;
use Service\DashboardService;

class DashboardController
{

    public function __construct(
        private Request $request,
        private Response $response,
        private Session $session
    ) {
    }

    public function showDashboard(ViewRenderer $viewRenderer, DashboardService $dashboardService)
    {
        $vtuberChannelList['vtuberChannels'] = $dashboardService->getAllVtuberData();

        $viewRenderer->render('dashboard', $vtuberChannelList);
    }

    /**
    * 選択したChannelIDがユーザーの紐付けているchannelIDと重複しているか比較する<br>
     * 重複していない場合、ユーザーIDと選択したChannelIDを紐付ける
     */
    public function assignChannelIdToUser()
    {
        $selectChannelIds = $this->request->fetchInputValue('selected_members');
        $userId = $this->session->getStr('user_id');
    }
}