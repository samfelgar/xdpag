<?php

namespace Samfelgar\XdPag\Tests\PayOut\Models;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\PayOut\Models\GetPayOutResponse;

#[CoversClass(GetPayOutResponse::class)]
class GetPayOutResponseTest extends TestCase
{
    #[Test]
    public function itCanParseAResponse(): void
    {
        $response = new Response(
            body: '{
    "data": {
        "id": "a7dc3891-7525-44d8-ada6-90e7989f1fb1",
        "status": "CANCELLED",
        "amount": "1",
        "fee": "0.04",
        "webhook": "https://webhook.site/8969464c-c378-4922-bea8-a2255d683484",
        "externalId": "teste-sam",
        "endToEndId": null,
        "transactionReceiptUrl": "https://api.xdpag.com/receipt/a7dc3891-7525-44d8-ada6-90e7989f1fb1/payout",
        "metadata": []
    }
}',
        );
        $payOutResponse = GetPayOutResponse::fromResponse($response);
        $this->assertInstanceOf(GetPayOutResponse::class, $payOutResponse);
    }
}
