<?php
declare(strict_types=1);

namespace Entity;

final class User
{
    public function __construct(
        private string $userId,
        private string $email,
        private bool $isNewUser,
        private ?string $providerId = null,
        private ?string $providerName = null,
        private ?string $refreshToken = null
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}