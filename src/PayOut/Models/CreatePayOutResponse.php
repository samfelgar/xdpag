<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models;

use Psr\Http\Message\ResponseInterface;

class CreatePayOutResponse
{
    public function __construct(
        public readonly string $id,
        public readonly Status $status,
        public readonly string $externalId,
    ) {}

    public static function fromArray(array $data): CreatePayOutResponse
    {
        return new CreatePayOutResponse(
            $data['id'],
            Status::from($data['status']),
            $data['externalId'],
        );
    }

    public static function fromResponse(ResponseInterface $response): CreatePayOutResponse
    {
        $body = \json_decode((string)$response->getBody(), true);
        return self::fromArray($body['data']);
    }
}
