<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Authentication
{
    public function __construct(private readonly Client $client) {}

    /**
     * @throws GuzzleException
     */
    public function authenticate(string $username, string $password): AuthResponse
    {
        $response = $this->client->post('/api/account/login', [
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);
        return AuthResponse::fromResponse($response);
    }
}
