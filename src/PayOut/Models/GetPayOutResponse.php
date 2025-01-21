<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use Psr\Http\Message\ResponseInterface;

class GetPayOutResponse
{
    public function __construct(
        public readonly string $id,
        public readonly Status $status,
        public readonly BigDecimal $amount,
        public readonly BigDecimal $fee,
        public readonly string $webhook,
        public readonly string $externalId,
        public readonly ?string $endToEndId,
        public readonly ?string $receipt,
    ) {}

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromArray(array $data): GetPayOutResponse
    {
        return new GetPayOutResponse(
            $data['id'],
            Status::from($data['status']),
            BigDecimal::of($data['amount']),
            BigDecimal::of($data['fee']),
            $data['webhook'],
            $data['externalId'],
            $data['endToEndId'],
            $data['transactionReceiptUrl'],
        );
    }

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromResponse(ResponseInterface $response): GetPayOutResponse
    {
        $body = \json_decode((string)$response->getBody(), true);
        if (!isset($body['data'])) {
            throw new \InvalidArgumentException('invalid response format');
        }
        return self::fromArray($body['data']);
    }
}
