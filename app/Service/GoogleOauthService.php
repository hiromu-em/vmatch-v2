<?php
declare(strict_types=1);

namespace Service;

use Google\Client;

class GoogleOauthService
{
    public function setClientConfig(Client $client): Client
    {
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);

        $client->setPrompt('select_account');
        $client->setRedirectUri('/google-oauth-callback');

        return $client;
    }
}