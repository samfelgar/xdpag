<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut;

use Brick\Math\Exception\DivisionByZeroException;
use Brick\Math\Exception\NumberFormatException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Samfelgar\XdPag\Auth\TokenAware;
use Samfelgar\XdPag\PayOut\Models\CreatePayOutRequest;
use Samfelgar\XdPag\PayOut\Models\CreatePayOutResponse;
use Samfelgar\XdPag\PayOut\Models\GetPayOutResponse;

class PayOut
{
    use TokenAware;

    public function __construct(private readonly Client $client) {}

    /**
     * @throws GuzzleException
     */
    public function createPayOut(CreatePayOutRequest $request): CreatePayOutResponse
    {
        $response = $this->client->post('/api/order/pay-out', [
            'json' => $request,
            'headers' => $this->authorizationHeader(),
        ]);
        return CreatePayOutResponse::fromResponse($response);
    }

    /**
     * @throws GuzzleException
     * @throws DivisionByZeroException
     * @throws NumberFormatException
     */
    public function getPayOut(string $identifier): GetPayOutResponse
    {
        $response = $this->client->get("/api/order/pay-out/$identifier", [
            'headers' => $this->authorizationHeader(),
        ]);
        return GetPayOutResponse::fromResponse($response);
    }
}
