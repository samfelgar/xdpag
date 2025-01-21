<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models;

use Brick\Math\BigDecimal;
use Samfelgar\PixValidator\PixInterface;
use Webmozart\Assert\Assert;

class CreatePayOutRequest implements \JsonSerializable
{
    public function __construct(
        public readonly BigDecimal $amount,
        public readonly string $webhook,
        public readonly string $document,
        public readonly PixInterface $pixKey,
        public readonly string $externalId,
        public readonly bool $validateDocument = false,
    ) {
        if ($this->amount->isNegativeOrZero()) {
            throw new \InvalidArgumentException('invalid amount');
        }

        if (\filter_var($this->webhook, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('invalid webhook');
        }

        Assert::notEmpty(\trim($this->externalId));
    }

    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount->toFloat(),
            'webhook' => $this->webhook,
            'document' => $this->document,
            'pixKey' => $this->pixKey->value(),
            'externalId' => $this->externalId,
            'validate_document' => $this->validateDocument,
        ];
    }
}
