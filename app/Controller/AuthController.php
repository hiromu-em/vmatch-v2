<?php
declare(strict_types=1);

namespace Controller;

use Core\Request;
use Core\Response;
use Core\ViewRenderer;
use Core\Session;
use Service\RegisterService;
use Vmatch\FormValidation;

class AuthController
{
    public function __construct(
        private Request $request,
        private Response $response,
        private Session $session
    ) {
    }

    public function showLoginForm(ViewRenderer $viewRenderer): void
    {
        $viewRenderer->render('login');
    }

    public function showRegisterForm(ViewRenderer $viewRenderer): void
    {
        $viewRenderer->render(
            'register',
            ['error' => $this->session->getOnce('errorMessage')]
        );
    }

    public function showNewPasswordSetting(ViewRenderer $viewRenderer): void
    {
        $viewRenderer->render(
            'signUp',
            ['email' => $this->session->get('email')]
        );
    }

    /**
     * トークンを検証して成否を処理する</br>
     * 成功→パスワード設定にリダイレクト</br>
     * 失敗→エラーメッセージを表示
     */
    public function handleTokenVerification(RegisterService $registerService): never
    {
        $verificationToken = $this->request->fetchInputStr('token');
        $token = $this->session->get('token');

        $verificationResult = $registerService->verifyToen($verificationToken, $token);
        if (!$verificationResult->isSuccess()) {

            $this->session->set('errorMessage', $verificationResult->error());
            $this->response->redirect('/register', 301);
        }

        $this->session->remove('token');

        $this->response->redirect('/new-password-setting', 301);
    }

    /**
     * 新規登録用のメールアドレス検証を行う
     */
    public function validateNewRegisterEmail(
        RegisterService $registerService,
        FormValidation $formValidation
    ): never {

        $email = $this->request->fetchInputStr('email');

        $emailFormatResult = $formValidation->validateEmailFormat($email);
        if (!$emailFormatResult->isSuccess()) {

            $this->session->set('errorMessage', $emailFormatResult->error());
            $this->response->redirect('/register');
        }

        $canRegisterResult = $registerService->canRegisterByEmail($email);
        if (!$canRegisterResult->isSuccess()) {

            $this->session->set('errorMessage', $canRegisterResult->error());
            $this->response->redirect('/register');
        }

        $this->session->set('email', $email);

        $token = $registerService->generateCertificationToken();

        // リダイレクト先でトークンの検証を行う
        $this->session->set('token', $token);
        $this->response->redirect("/token-verification?token=$token");
    }
}