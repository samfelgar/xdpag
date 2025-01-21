<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models\Webhooks;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use Psr\Http\Message\RequestInterface;
use Samfelgar\XdPag\PayOut\Models\Status;
use Webmozart\Assert\Assert;

class PayOutWebhook
{
    /**
     * @param Refund[] $refunds
     */
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
        public readonly ?Metadata $metadata,
        public readonly ?string $reasonCancelled,
        public readonly array $refunds = [],
    ) {
        Assert::allIsInstanceOf($this->refunds, Refund::class);
    }

    /**
     * @throws DivisionByZeroException
     * @throws NumberFormatException
     */
    public static function fromArray(array $data): PayOutWebhook
    {
        $refunds = \array_map(Refund::fromArray(...), $data['refunds'] ?? []);
        $metadata = empty($data['metadata']) ? null : Metadata::fromArray($data['metadata']);

        return new PayOutWebhook(
            $data['id'],
            $data['externalId'],
            BigDecimal::of($data['amount']),
            $data['document'],
            BigDecimal::of($data['original_amount']),
            Status::from($data['status']),
            $data['endToEndId'],
            $data['receipt'],
            BigDecimal::of($data['fee']),
            $metadata,
            $data['reason_cancelled'] ?? null,
            $refunds,
        );
    }

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromRequest(RequestInterface $request): PayOutWebhook
    {
        $body = \json_decode((string)$request->getBody(), true);

        if (!isset($body['data'], $body['type']) || $body['type'] !== 'PAYOUT') {
            throw new \InvalidArgumentException('invalid request format');
        }

        return self::fromArray($body['data']);
    }
}
