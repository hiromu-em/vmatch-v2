<?php
declare(strict_types=1);

namespace Controller;

use Requests\Requests;

class AuthController
{
    public function __construct(private Requests $request)
    {
    }

    public function showLoginForm(): void
    {
        include __DIR__ . '/../../public/resources/views/login.php';
    }

    public function showRegisterForm(): void
    {
        include __DIR__ . '/../../public/resources/views/register.php';
    }
}