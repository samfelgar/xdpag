<?php

namespace Samfelgar\XdPag\Tests\PayOut\Models\Webhooks;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\PayOut\Models\Webhooks\PayOutWebhook;

#[CoversClass(PayOutWebhook::class)]
class PayOutWebhookTest extends TestCase
{
    #[Test]
    #[DataProvider('itCanParseARequestProvider')]
    public function itCanParseARequest(string $body): void
    {
        $request = new Request('post', '/', body: $body);
        $payOutWebhook = PayOutWebhook::fromRequest($request);
        $this->assertInstanceOf(PayOutWebhook::class, $payOutWebhook);
    }

    public static function itCanParseARequestProvider(): array
    {
        return [
            [
                '{
    "type": "PAYOUT",
    "data": {
        "id": "577b7e1c-248c-4b1e-a6d8-e79e24c4ec8e",
        "externalId": "b909a9b0-91f3-4488-b3d4-e314aeb0b75b",
        "amount": "1",
        "document": "77148745039",
        "original_amount": "1",
        "status": "FINISHED",
        "endToEndId": "E5440356320241128165123v3Na7HbBl",
        "receipt": "https://api.xdpag.com/receipt/E5440356320241128165123v3Na7HbBl/payout",
        "fee": "0.00",
        "metadata": {
            "authCode": "577b7e1c-248c-4b1e-a6d8-e79e24c4ec8e",
            "amount": "1",
            "paymentDateTime": "2024-11-28T13:53:56.000Z",
            "pixKey": "01756390274",
            "receiveName": "Lucas Araujo",
            "receiverName": "Lucas Araujo",
            "receiverBankName": "18236120",
            "receiverDocument": "77148745039",
            "receiveAgency": "1",
            "receiveAccount": "72423990",
            "payerName": "VITALCRED MEIOS DE PAGAMENTOS SA",
            "payerAgency": "001",
            "payerAccount": "38805-7",
            "payerDocument": "08022117000188",
            "payerBankName": "BCO ARBI S.A.",
            "createdAt": "2024-11-28T16:53:50.000000Z",
            "endToEnd": "E5440356320241128165123v3Na7HbBl"
        },
        "reason_cancelled": ""
    }
}',
            ],

            [
                '{
    "type": "PAYOUT",
    "data": {
        "id": "987bb107-46f7-4b04-bb72-d0d37320d8f4",
        "externalId": "987bb107-46f7-4b04-bb72-d0d37320d8f4",
        "amount": "10",
        "document": "16078569996",
        "original_amount": "10",
        "status": "CANCELLED",
        "endToEndId": null,
        "receipt": "https://api.xdpag.com/receipt/987bb107-46f7-4b04-bb72-d0d37320d8f4\/payout",
        "fee": "0.00",
        "metadata": [],
        "refunds": [],
        "reason_cancelled": "INVALID_PIX_KEY"
    }
}',
            ],
            [
                '{
    "type": "PAYOUT",
    "data": {
        "id": "952b8982-0d14-4c46-a494-7b4028739d56",
        "externalId": "b909a9b0-91f3-4488-b3d4-e314aeb0b75b",
        "amount": 1,
        "document": "77148745039",
        "original_amount": 1,
        "status": "REVERSED",
        "endToEndId": "E3305353220241202194904482e134f1",
        "receipt": "https://api.xdpag.com/receipt/E3305353220241202194904482e134f1/payout",
        "fee": "0.03",
        "metadata": [],
        "refunds": [
            {
                "id": "5fdd5c3a-5067-4d82-937a-4de11c879492",
                "amount": 1,
                "order_id": "952b8982-0d14-4c46-a494-7b4028739d56",
                "description": "",
                "endToEnd": "D3581087120241208193539241350211",
                "created_at": "2024-12-11T04:52:04.000000Z",
                "updated_at": "2024-12-11T04:52:04.000000Z"
            }
        ]
    }
}',
            ],
            [
                '{
    "type": "PAYOUT",
    "data": {
        "id": "952b8982-0d14-4c46-a494-7b4028739d56",
        "externalId": "b909a9b0-91f3-4488-b3d4-e314aeb0b75b",
        "amount": 1,
        "document": "77148745039",
        "original_amount": 1,
        "status": "PARTIALLY_REVERSED",
        "endToEndId": "E3305353220241202194904482e134f1",
        "receipt": "https://api.xdpag.com/receipt/E3305353220241202194904482e134f1/payout",
        "fee": "0.03",
        "metadata": [],
        "refunds": [
            {
                "id": "5fdd5c3a-5067-4d82-937a-4de11c879492",
                "amount": 0.5,
                "order_id": "952b8982-0d14-4c46-a494-7b4028739d56",
                "description": "",
                "endToEnd": "D3581087120241208193539241350211",
                "created_at": "2024-12-11T04:52:04.000000Z",
                "updated_at": "2024-12-11T04:52:04.000000Z"
            }
        ]
    }
}',
            ],

            [
                '{
  "type": "PAYOUT",
  "data": {
    "id": "a7dc3891-7525-44d8-ada6-90e7989f1fb1",
    "externalId": "teste-sam",
    "amount": "1",
    "document": "99999999",
    "original_amount": "1",
    "status": "CANCELLED",
    "endToEndId": null,
    "receipt": "https://api.xdpag.com/receipt/a7dc3891-7525-44d8-ada6-90e7989f1fb1/payout",
    "fee": "0.04",
    "metadata": null,
    "refunds": [],
    "reason_cancelled": "INSUFFICIENT_BALANCE"
  }
}',
            ],
        ];
    }
}
