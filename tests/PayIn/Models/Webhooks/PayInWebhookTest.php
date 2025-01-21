<?php

namespace Samfelgar\XdPag\Tests\PayIn\Models\Webhooks;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\PayIn\Models\Webhooks\PayInWebhook;

#[CoversClass(PayInWebhook::class)]
class PayInWebhookTest extends TestCase
{
    #[Test]
    #[DataProvider('itCanParseARequestProvider')]
    public function itCanParseARequest(string $body): void
    {
        $payInWebhook = PayInWebhook::fromRequest(new Request('post', '/', body: $body));
        $this->assertInstanceOf(PayInWebhook::class, $payInWebhook);
    }

    public static function itCanParseARequestProvider(): array
    {
        return [
            [
                '{
    "type": "PAYIN",
    "data": {
        "id": "f466fef7-bad2-4ff3-a50f-bd95cf2bbbf6",
        "externalId": "f466fef7-bad2-4ff3-a50f-bd95cf2bbbf6",
        "amount": "20",
        "document": "",
        "original_amount": "20",
        "status": "FINISHED",
        "endToEndId": "E18236120202412271326s1360618214",
        "receipt": "",
        "fee": "0.06",
        "metadata": [],
        "refunds": []
    }
}',
            ],
        ];
    }
}
