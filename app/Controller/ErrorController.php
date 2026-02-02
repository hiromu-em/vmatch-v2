<?php
declare(strict_types=1);

namespace Controller;

use Core\ViewRenderer;

class ErrorController
{
    public function showSystemError(ViewRenderer $viewRenderer)
    {
        $viewRenderer->render(
            'systemError'
        );
    }
}