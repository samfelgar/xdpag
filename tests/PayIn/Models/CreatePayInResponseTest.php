<?php

namespace Samfelgar\XdPag\Tests\PayIn\Models;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Samfelgar\XdPag\PayIn\Models\CreatePayInResponse;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\PayIn\Models\Status;

#[CoversClass(CreatePayInResponse::class)]
class CreatePayInResponseTest extends TestCase
{
    #[Test]
    public function itCanParseAResponse(): void
    {
        $json = '{
    "data": {
        "id": "e8ff2fa9-41aa-44af-99ef-9cc76ed17baa",
        "status": "CREATED",
        "externalId": "yout-id-here",
        "brcode": "00020126860014br.gov.bcb.pix2564pix.ecomovi.com.br/qr/v3/at/6fac227d-9e1f-498f-b801-f596c40657ec5204000053039865802BR5925DGDS_FERNANDES_COMERCIO_L6009SAO_PAULO62070503***6304FD98",
        "qrcode": "data:image/png;base64, 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"
    }
}';

        $response = new Response(body: $json);
        $payInResponse = CreatePayInResponse::fromResponse($response);
        $this->assertInstanceOf(CreatePayInResponse::class, $payInResponse);
        $this->assertEquals(Status::Created, $payInResponse->status);
        $this->assertEquals('e8ff2fa9-41aa-44af-99ef-9cc76ed17baa', $payInResponse->id);
    }
}
