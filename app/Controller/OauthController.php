<?php
declare(strict_types=1);

namespace Controller;

use Google\Client;

use Service\GoogleOauthService;

class OauthController
{
    public function handleGoogleOAuth(Client $client, GoogleOauthService $googleOauthService)
    {
    }
}