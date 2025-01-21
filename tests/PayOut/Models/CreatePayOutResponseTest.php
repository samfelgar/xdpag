<?php

namespace Samfelgar\XdPag\Tests\PayOut\Models;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\PayOut\Models\CreatePayOutResponse;
use Samfelgar\XdPag\PayOut\Models\Status;

#[CoversClass(CreatePayOutResponse::class)]
class CreatePayOutResponseTest extends TestCase
{
    #[Test]
    public function itCanParseAResponse(): void
    {
        $json = '{
    "data": {
        "id": "a7dc3891-7525-44d8-ada6-90e7989f1fb1",
        "status": "CREATED",
        "externalId": "teste-sam",
        "events": null
    }
}';

        $payOutResponse = CreatePayOutResponse::fromResponse(new Response(body: $json));
        $this->assertInstanceOf(CreatePayOutResponse::class, $payOutResponse);
        $this->assertEquals('a7dc3891-7525-44d8-ada6-90e7989f1fb1', $payOutResponse->id);
        $this->assertEquals(Status::Created, $payOutResponse->status);
    }
}
