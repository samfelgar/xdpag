<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\Auth;

trait TokenAware
{
    private ?string $token = null;

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    protected function getToken(): string
    {
        if ($this->token === null) {
            throw new \RuntimeException('there is no token set');
        }
        return $this->token;
    }

    protected function authorizationHeader(): array
    {
        return [
            'authorization' => \sprintf('Bearer %s', $this->getToken()),
        ];
    }
}
