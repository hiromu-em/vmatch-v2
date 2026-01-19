<?php
declare(strict_types=1);

namespace Service;

use Repository\UserAuthRepository;
use Vmatch\FormValidation;

class UserAuthentication
{
    public function __construct(private UserAuthRepository $userAuthRepository, private FormValidation $formValidation)
    {
    }

    public function register(string $email)
    {
    }

    /**
     * ユーザーのメールアドレスを検証する。</br>
     * メール形式の検証とメールアドレスがDBに存在するか検証する。
     * @return array 検証結果
     */
    public function validateUserEmail(string $email, string $authType): array
    {
        $this->formValidation->validateEmail($email);

        if ($this->formValidation->hasErrorMessages()) {
            return [
                'isValid' => false,
                'errorMessage' => $this->formValidation->getErrorMessage()
            ];
        }

        $isExistsByEmail = $this->userAuthRepository->existsByEmail($email, $authType);

        if ($isExistsByEmail) {
            return [
                'isValid' => false,
                'errorMessage' => $this->userAuthRepository->getErrorMessage()
            ];
        }

        return ['isValid' => true];
    }
}