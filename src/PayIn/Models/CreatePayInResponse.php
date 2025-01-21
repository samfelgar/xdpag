<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn\Models;

use Psr\Http\Message\ResponseInterface;

class CreatePayInResponse
{
    public function __construct(
        public readonly string $id,
        public readonly Status $status,
        public readonly string $externalId,
        public readonly string $brCode,
        public readonly string $qrCode,
    ) {}

    public static function fromArray(array $data): CreatePayInResponse
    {
        return new CreatePayInResponse(
            $data['id'],
            Status::from($data['status']),
            $data['externalId'],
            $data['brcode'],
            $data['qrcode'],
        );
    }

    public static function fromResponse(ResponseInterface $response): CreatePayInResponse
    {
        $parsed = \json_decode((string)$response->getBody(), true);
        return self::fromArray($parsed['data']);
    }
}
