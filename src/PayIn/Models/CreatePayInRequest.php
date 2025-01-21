<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn\Models;

use Brick\Math\BigDecimal;
use Webmozart\Assert\Assert;

class CreatePayInRequest implements \JsonSerializable
{
    public function __construct(
        public readonly BigDecimal $amount,
        public readonly string $webhook,
        public readonly string $externalId,
    ) {
        Assert::greaterThan($this->amount->toFloat(), 0);
        Assert::notEmpty(\trim($this->externalId));

        if (\filter_var($this->webhook, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('invalid webhook address');
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount->toFloat(),
            'webhook' => $this->webhook,
            'externalId' => $this->externalId,
        ];
    }
}
