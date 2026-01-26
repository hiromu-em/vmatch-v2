<?php
declare(strict_types=1);

use Core\Router;
use Core\Request;
use Core\Response;
use Core\ViewRenderer;
use Core\Session;
use Vmatch\FormValidation;
use Service\RegisterService;
use Repository\UserAuthRepository;

$router = new Router(
    new Request(),
    new Response(),
    new Session()
);

$router->add(
    'GET',
    '/',
    [Controller\TopController::class, 'showTop'],
    ['obj' => new ViewRenderer('views/')]
);

$router->add(
    'GET',
    '/login',
    [Controller\AuthController::class, 'showLoginForm'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);

$router->add(
    'GET',
    '/register',
    [Controller\AuthController::class, 'showRegisterForm'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);

$router->add(
    'POST',
    '/validation/email',
    [Controller\AuthController::class, 'validateNewRegisterEmail'],
    [
        'obj' => [
            new RegisterService(new UserAuthRepository(generatePdo())),
            new FormValidation()
        ]
    ]
);

$router->add(
    'GET',
    '/newPasswordSetting',
    [Controller\AuthController::class, 'showNewPasswordSetting'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);