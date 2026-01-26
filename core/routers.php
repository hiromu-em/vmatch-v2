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
    ['class' => Controller\TopController::class, 'method' => 'showTop'],
    ['obj' => new ViewRenderer('views/')]
);

$router->add(
    'GET',
    '/login',
    ['class' => Controller\AuthController::class, 'method' => 'showLoginForm'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);

$router->add(
    'GET',
    '/register',
    ['class' => Controller\AuthController::class, 'method' => 'showRegisterForm'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);

$router->add(
    'POST',
    '/validation/email',
    ['class' => Controller\AuthController::class, 'method' => 'validateNewRegisterEmail'],
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
    ['class' => Controller\AuthController::class, 'method' => 'showNewPasswordSetting'],
    ['obj' => new ViewRenderer('views/UserAuthentication/')]
);