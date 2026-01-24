<?php
declare(strict_types=1);

namespace Service;

use Repository\UserAuthRepository;
use Vmatch\Result;

class RegisterService
{
    public function __construct(private UserAuthRepository $authRepository)
    {
    }

    /**
     * メールアドレスとして登録が可能か確認をする
     */
    public function canRegisterByEmail($email): Result
    {
        if ($this->authRepository->existsByEmail($email)) {
            Result::failure("登録済みユーザーです。\nログインしてください");
        }

        return Result::success();
    }
}