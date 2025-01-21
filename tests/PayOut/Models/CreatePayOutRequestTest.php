<?php

namespace Samfelgar\XdPag\Tests\PayOut\Models;

use Brick\Math\BigDecimal;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\PixValidator\PhoneKey;
use Samfelgar\XdPag\PayOut\Models\CreatePayOutRequest;

#[CoversClass(CreatePayOutRequest::class)]
class CreatePayOutRequestTest extends TestCase
{
    #[Test]
    public function itValidatesTheAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid amount');
        new CreatePayOutRequest(
            BigDecimal::of(-1),
            'https://example.com',
            'asdf',
            new PhoneKey('+5561999999999'),
            'asdf',
        );
    }

    #[Test]
    public function itValidatesTheWebhook(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid webhook');
        new CreatePayOutRequest(
            BigDecimal::of(10),
            'asdf',
            'asdf',
            new PhoneKey('+5561999999999'),
            'asdf',
        );
    }

    #[Test]
    public function itValidatesTheExternalId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value');
        new CreatePayOutRequest(
            BigDecimal::of(10),
            'https://example.com',
            'asdf',
            new PhoneKey('+5561999999999'),
            '',
        );
    }

    public function itSerializesToJson(): void
    {
        $payOutRequest = new CreatePayOutRequest(
            BigDecimal::of(10),
            'https://example.com',
            'asdf',
            new PhoneKey('+5561999999999'),
            'asdf',
        );

        $expected = \json_encode([
            'amount' => 10,
            'webhook' => 'https://example.com',
            'document' => 'asdf',
            'pixKey' => '+5561999999999',
            'externalId' => 'asdf',
            'validate_document' => false,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, \json_encode($payOutRequest));
    }
}
