<?php
declare(strict_types=1);

namespace Service;

use Repository\UserAuthRepository;

class UserAuthentication
{
    public function __construct(private UserAuthRepository $userAuthRepository)
    {
    }

    public function register(string $email)
    {
    }
}