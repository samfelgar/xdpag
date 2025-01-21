<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models\Webhooks;

class Person
{
    public function __construct(
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $branch,
        public readonly string $account,
        public readonly string $document,
    ) {}
}
