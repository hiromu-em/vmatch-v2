<?php
declare(strict_types=1);

namespace Vmatch\Oauth;

use Google\Client;
use Vmatch\ConfigInterface;

require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * Google認可クラス
 */
class GoogleAuthorization implements GoogleAuthorizationInterface
{
    /** @var string $state stateパラメーター */
    private string $state = '';

    /**
     * @param ConfigInterface $config 設定インターフェース
     * @param Client $client Google Clientオブジェクト
     */
    public function __construct(private ConfigInterface $config, private Client $client)
    {
    }

    /**
     * Google Clientの設定
     * @param array $accessToken アクセストークン
     * @return Client Google Clientオブジェクト
     */
    public function setClient(): Client
    {
        $this->client->setAuthConfig($this->config->getGoogleClientEnvVars());
        $this->client->setScopes('email');

        $this->client->setAccessType('offline');
        $this->client->setIncludeGrantedScopes(true);
        $this->client->setPrompt('select_account');

        $redirectUri = $this->config->urlScheme() . $this->config->getHost() . self::GOOGLE_CALLBACK;
        $this->client->setRedirectUri($redirectUri);

        return $this->client;
    }

    /**
     * アクセストークンの設定
     * @param array $accessToken アクセストークン
     * @return void
     */
    public function setAccessToken(array $accessToken): void
    {
        $this->client->setAccessToken($accessToken);
    }

    /**
     * 認可サーバーのURLを生成
     * @param string $state stateパラメーター
     * @return string 認可サーバーのURL
     */
    public function createAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * stateパラメーターの生成
     * @return string 生成されたstateパラメーター
     */
    public function createState(): string
    {
        return bin2hex(random_bytes(128 / 8));
    }

    /**
     * Clientにstateパラメーターを設定
     * @param string $state stateパラメーター
     * @return void
     */
    public function setClientState(string $state): void
    {
        $this->client->setState($state);
    }

    /**
     * stateパラメーターの取得
     * @return string stateパラメーター
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * stateパラメーターの取得
     * @return string stateパラメーター
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * コード検証者の取得
     * @return string コード検証者
     */
    public function generateCodeVerifier(): string
    {
        return $this->client->getOAuth2Service()->generateCodeVerifier();
    }

    /**
     * stateパラメーターの検証
     * @param string $state stateパラメーター
     * @return bool 検証結果
     */
    public function verifyState(string $state): void
    {
        if ($state !== $this->getState()) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * 認可コードをアクセストークンと交換
     * @param string $code 認可コード
     * @param string $codeVerifier コード検証者
     * @return void
     */
    public function fetchAccessToken(string $code, string $codeVerifier): void
    {
        $this->client->fetchAccessTokenWithAuthCode($code, $codeVerifier);
    }

    /**
     * アクセストークンの取得
     * @return array アクセストークン情報
     */
    public function getAccessToken(): array
    {
        return $this->client->getAccessToken();
    }

    /**
     * IDトークンの取得
     * @return array|false IDトークン情報
     */
    public function getIdToken(): array|false
    {
        return $this->client->verifyIdToken();
    }
}

