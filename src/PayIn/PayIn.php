<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn;

use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Samfelgar\XdPag\Auth\TokenAware;
use Samfelgar\XdPag\PayIn\Models\CreatePayInRequest;
use Samfelgar\XdPag\PayIn\Models\CreatePayInResponse;
use Samfelgar\XdPag\PayIn\Models\GetPayInResponse;

class PayIn
{
    use TokenAware;

    public function __construct(private readonly Client $client) {}

    /**
     * @throws GuzzleException
     */
    public function createPayIn(CreatePayInRequest $request): CreatePayInResponse
    {
        $response = $this->client->post('/api/order/pay-in', [
            'json' => $request,
            'headers' => $this->authorizationHeader(),
        ]);
        return CreatePayInResponse::fromResponse($response);
    }

    /**
     * @param string $identifier Can be the externalId, order id or end-to-end
     * @throws GuzzleException
     */
    public function refundPayIn(string $identifier): void
    {
        $this->client->patch("/api/order/pay-in/$identifier/refund", [
            'headers' => $this->authorizationHeader(),
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws DivisionByZeroException
     * @throws NumberFormatException
     */
    public function getPayIn(string $identifier): GetPayInResponse
    {
        $response = $this->client->get("/api/order/pay-in/$identifier", [
            'headers' => $this->authorizationHeader(),
        ]);
        return GetPayInResponse::fromResponse($response);
    }
}
