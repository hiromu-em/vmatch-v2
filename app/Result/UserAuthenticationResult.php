<?php
declare(strict_types=1);

namespace Result;

use Vmatch\Result;

class UserAuthenticationResult extends Result
{
    public function __construct(bool $success, array $messages = [])
    {
        $this->success = $success;
        $this->errors = $messages;
    }

    public static function success(): UserAuthenticationResult
    {
        return new self(true);
    }

    public static function failure(array $errorMessages): UserAuthenticationResult
    {
        return new self(false, $errorMessages);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}