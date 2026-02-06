<?php
declare(strict_types=1);

namespace Controller;

use Core\ViewRenderer;
use Core\Request;
use Core\Response;
use Core\Session;

class UserSettingController
{
    public function __construct(
        private Request $request,
        private Response $response,
        private Session $session
    ) {
    }

    public function showInitProfileSettng(ViewRenderer $viewRenderer)
    {
        $viewRenderer->render(
            'InitProfileSettings'
        );
    }
}