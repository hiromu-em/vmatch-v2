<?php
declare(strict_types=1);

namespace Service;

use Repository\UserAuthRepository;
use Entity\User;

class GoogleUserService
{

    public function __construct(private UserAuthRepository $authRepository)
    {
    }

    /**
     * プロパイダ―IDを基にしてDBからユーザーアカウントを取得する
     */
    public function fetchUserAccount(string $providerId): User
    {

        $userRecord = $this->authRepository->findUserRecordByProviderId($providerId);

        return new User(
            userId: $userRecord['id'],
            email: $userRecord['email'],
            isNewUser: false,
            providerId: $providerId,
            providerName: 'Google'
        );
    }

    /**
     * usersテーブルに新規ユーザーとして登録する。
     * ユーザーID, email, isNewUserをUserクラスにセットする
     */
    public function registerNewUser(string $email): User
    {
        $userRecord = $this->authRepository->fetchNewUserRecord($email);

        return new User(
            $userRecord['id'],
            $userRecord['email'],
            isNewUser: true
        );
    }

    /**
     * 登録済みのプロパイダ―がDBのレコードに存在するか確認する
     */
    public function providerRecordExists(string $providerId): bool
    {
        return $this->authRepository->providerIdExists($providerId);
    }
}