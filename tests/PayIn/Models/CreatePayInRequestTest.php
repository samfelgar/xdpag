<?php

namespace Samfelgar\XdPag\Tests\PayIn\Models;

use Brick\Math\BigDecimal;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Samfelgar\XdPag\PayIn\Models\CreatePayInRequest;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreatePayInRequest::class)]
class CreatePayInRequestTest extends TestCase
{
    #[Test]
    public function itValidatesTheAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than');
        new CreatePayInRequest(BigDecimal::of(-1), 'https://example.com', 'asdf');
    }

    #[Test]
    public function itValidatesTheWebhookAddress(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid webhook address');
        new CreatePayInRequest(BigDecimal::of(10), 'asdf', 'asdf');
    }

    #[Test]
    public function itValidatesTheExternalId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value');
        new CreatePayInRequest(BigDecimal::of(10), 'https://example.com', '');
    }

    #[Test]
    public function itSerializesToJson(): void
    {
        $request = new CreatePayInRequest(BigDecimal::of(10), 'https://example.com', 'asdf');
        $expected = \json_encode([
            'amount' => 10,
            'webhook' => 'https://example.com',
            'externalId' => 'asdf',
        ]);
        $this->assertJsonStringEqualsJsonString($expected, \json_encode($request));
    }
}
