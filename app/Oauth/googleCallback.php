<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Vmatch\Oauth\GoogleOAuthClient;
use Vmatch\Config;

session_start(['use_strict_mode' => 1]);

if (isset($_GET['error'])) {
    header('Location: ' . filter_var('/', FILTER_SANITIZE_URL));
    exit;
}

$config = new Config();
$config->setHost($_SERVER['HTTP_HOST'] ?? 'localhost');

// 環境変数の読み込み
$config->loadDotenvIfLocal();

$googleAuthorization = new GoogleOAuthClient($config, new \Google\Client());
$state = $_SESSION['google_oauth_state'] ?? '';

if ($_GET['state'] !== $state) {
    unset($_SESSION['google_oauth_state'], $_SESSION['google_code_verifier']);

    http_response_code(400);
    header('Location: ' . filter_var('../error/oauthError.php', FILTER_SANITIZE_URL));
    exit;
}

$googleAuthorization->setClient();

if (isset($_GET['code']) && !empty($_GET['code'])) {

    try {
        // 認可コードをアクセストークンと交換
        $googleAuthorization->fetchAccessToken(
            $_GET['code'],
            $_SESSION['google_code_verifier'] ?? ''
        );
    } catch (\InvalidArgumentException $e) {

        unset($_SESSION['google_oauth_state'], $_SESSION['google_code_verifier']);

        http_response_code(400);
        header('Location: ' . filter_var('../error/oauthError.php', FILTER_SANITIZE_URL));
        exit;
    }

    $_SESSION['google_access_token'] = $googleAuthorization->getAccessToken();

    unset($_SESSION['google_oauth_state'], $_SESSION['google_code_verifier']);

    header('Location: ' . filter_var('googleOauth.php', FILTER_SANITIZE_URL));
    exit;
}