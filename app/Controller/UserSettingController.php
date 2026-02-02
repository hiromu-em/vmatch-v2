<?php
declare(strict_types=1);

namespace Controller;

use Core\ViewRenderer;

class UserSettingController
{
    public function showInitProfileSettng(ViewRenderer $viewRenderer)
    {
        $viewRenderer->render(
            'InitProfileSettings'
        );
    }
}