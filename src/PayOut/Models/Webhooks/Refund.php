<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models\Webhooks;

use Brick\Math\BigDecimal;

class Refund
{
    public function __construct(
        public readonly string $id,
        public readonly BigDecimal $amount,
        public readonly string $orderId,
        public readonly ?string $description,
        public readonly string $endToEndId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt,
    ) {}

    public static function fromArray(array $data): Refund
    {
        $createdAt = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $data['created_at']);
        $updatedAt = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $data['updated_at']);

        if ($createdAt === false) {
            throw new \InvalidArgumentException('invalid created_at date');
        }

        if ($updatedAt === false) {
            throw new \InvalidArgumentException('invalid updated_at date');
        }

        return new Refund(
            $data['id'],
            BigDecimal::of($data['amount']),
            $data['order_id'],
            $data['description'] ?? null,
            $data['endToEnd'],
            $createdAt,
            $updatedAt,
        );
    }
}
