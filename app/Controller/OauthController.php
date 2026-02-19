<?php
declare(strict_types=1);

namespace Controller;

use Core\Request;
use Core\Response;
use Core\Session;
use Vmatch\GoogleOauth;

class OauthController
{
    public function __construct(
        private Request $request,
        private Response $response,
        private Session $session
    ) {

    }

    public function handleGoogleOauth(GoogleOauth $googleOauth, array $clientConfig)
    {
        $client = $googleOauth->changeClientSetting($clientConfig);

            $state = bin2hex(random_bytes(128 / 8));
            $client->setState($state);

            $this->session->setStr('google_oauth_state', $state);
            $this->session->setStr('google_code_verifier', $client->getOAuth2Service()->generateCodeVerifier());
    }
}