<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn\Models;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use Psr\Http\Message\ResponseInterface;

class GetPayInResponse
{
    public function __construct(
        public readonly string $id,
        public readonly Status $status,
        public readonly BigDecimal $amount,
        public readonly BigDecimal $fee,
        public readonly string $webhook,
        public readonly string $externalId,
        public readonly ?string $endToEndId,
        public readonly ?string $transactionReceiptUrl,
    ) {}

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromArray(array $data): GetPayInResponse
    {
        $transactionReceiptUrl = !isset($data['transactionReceiptUrl']) || !\is_string($data['transactionReceiptUrl'])
            ? null
            : $data['transactionReceiptUrl'];

        return new GetPayInResponse(
            $data['id'],
            Status::from($data['status']),
            BigDecimal::of($data['amount']),
            BigDecimal::of($data['fee']),
            $data['webhook'],
            $data['externalId'],
            $data['endToEndId'] ?? null,
            $transactionReceiptUrl,
        );
    }

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromResponse(ResponseInterface $response): GetPayInResponse
    {
        $body = \json_decode((string)$response->getBody(), true);
        return self::fromArray($body['data']);
    }
}
