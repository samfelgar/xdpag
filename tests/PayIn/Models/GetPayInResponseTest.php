<?php

namespace Samfelgar\XdPag\Tests\PayIn\Models;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Samfelgar\XdPag\PayIn\Models\GetPayInResponse;
use PHPUnit\Framework\TestCase;

#[CoversClass(GetPayInResponse::class)]
class GetPayInResponseTest extends TestCase
{
    #[Test]
    public function itParsesAResponse(): void
    {
        $json = '{
    "data": {
        "id": "e8ff2fa9-41aa-44af-99ef-9cc76ed17baa",
        "status": "CREATED",
        "amount": "10",
        "fee": "0.04",
        "webhook": "https://google.com",
        "externalId": "yout-id-here",
        "endToEndId": null,
        "transactionReceiptUrl": false,
        "metadata": []
    }
}';

        $response = new Response(body: $json);
        $payIn = GetPayInResponse::fromResponse($response);

        $this->assertInstanceOf(GetPayInResponse::class, $payIn);
    }
}
