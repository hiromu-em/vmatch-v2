<?php
declare(strict_types=1);

namespace Service;

use Repository\UserAuthRepository;

class GoogleUserSyncService
{

    public function __construct(private UserAuthRepository $authRepository)
    {
    }

    public function synchronizeUserData(string $providerId, string $email)
    {
        if ($this->authRepository->providerIdExists($providerId)) {
        }

    }

}