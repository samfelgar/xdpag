<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\Auth;

use Psr\Http\Message\ResponseInterface;

class AuthResponse
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $tokenType,
        public readonly int $expiresIn,
    ) {}

    public static function fromArray(array $data): AuthResponse
    {
        return new AuthResponse(
            $data['access_token'],
            $data['token_type'],
            $data['expires_in'],
        );
    }

    public static function fromResponse(ResponseInterface $response): AuthResponse
    {
        $parsed = \json_decode((string)$response->getBody(), true);
        return self::fromArray($parsed);
    }
}
