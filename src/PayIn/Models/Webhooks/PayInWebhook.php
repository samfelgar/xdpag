<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn\Models\Webhooks;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use Psr\Http\Message\RequestInterface;
use Samfelgar\XdPag\PayIn\Models\Status;

class PayInWebhook
{
    public function __construct(
        public readonly string $id,
        public readonly string $externalId,
        public readonly BigDecimal $amount,
        public readonly string $document,
        public readonly BigDecimal $originalAmount,
        public readonly Status $status,
        public readonly ?string $endToEndId,
        public readonly ?string $receipt,
        public readonly BigDecimal $fee,
    ) {}

    /**
     * @throws DivisionByZeroException
     * @throws NumberFormatException
     */
    public static function fromArray(array $data): PayInWebhook
    {
        return new PayInWebhook(
            $data['id'],
            $data['externalId'],
            BigDecimal::of($data['amount']),
            $data['document'],
            BigDecimal::of($data['original_amount']),
            Status::from($data['status']),
            $data['endToEndId'],
            $data['receipt'],
            BigDecimal::of($data['fee']),
        );
    }

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromRequest(RequestInterface $request): PayInWebhook
    {
        $body = \json_decode((string)$request->getBody(), true);
        if (!isset($body['data'], $body['type']) || $body['type'] !== 'PAYIN') {
            throw new \InvalidArgumentException('invalid request format');
        }
        return self::fromArray($body['data']);
    }
}
