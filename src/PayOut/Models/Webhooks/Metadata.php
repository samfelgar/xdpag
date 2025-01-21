<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models\Webhooks;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;

class Metadata
{
    public function __construct(
        public readonly string $authCode,
        public readonly BigDecimal $amount,
        public readonly \DateTimeImmutable $paidAt,
        public readonly string $pixKey,
        public readonly Person $receiver,
        public readonly Person $payer,
        public readonly \DateTimeImmutable $createdAt,
        public readonly string $endToEnd,
    ) {}

    /**
     * @throws NumberFormatException
     * @throws DivisionByZeroException
     */
    public static function fromArray(array $data): Metadata
    {
        $paidAt = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $data['paymentDateTime']);

        if ($paidAt === false) {
            throw new \InvalidArgumentException('invalid payment date time format');
        }

        $createdAt = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.uP', $data['createdAt']);
        if ($createdAt === false) {
            throw new \InvalidArgumentException('invalid created at format');
        }

        return new Metadata(
            $data['authCode'],
            BigDecimal::of($data['amount']),
            $paidAt,
            $data['pixKey'],
            new Person(
                $data['receiverName'],
                $data['receiverBankName'],
                $data['receiveAgency'],
                $data['receiveAccount'],
                $data['receiverDocument'],
            ),
            new Person(
                $data['payerName'],
                $data['payerBankName'],
                $data['payerAgency'],
                $data['payerAccount'],
                $data['payerDocument'],
            ),
            $createdAt,
            $data['endToEnd'],
        );
    }
}
