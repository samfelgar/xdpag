<?php

declare(strict_types=1);

namespace Samfelgar\XdPag;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use Samfelgar\XdPag\Auth\Authentication;
use Samfelgar\XdPag\PayIn\PayIn;
use Samfelgar\XdPag\PayOut\PayOut;

class XdPag
{
    public function __construct(
        private readonly Client $client,
    ) {}

    public static function factory(?LoggerInterface $logger = null): XdPag
    {
        $handler = HandlerStack::create();
        if ($logger !== null) {
            $handler->push(Middleware::log($logger, new MessageFormatter(MessageFormatter::DEBUG)));
        }
        $client = new Client(['handler' => $handler, 'timeout' => 10, 'base_uri' => 'https://api.xdpag.com']);

        return new XdPag($client);
    }

    public function authentication(): Authentication
    {
        return new Authentication($this->client);
    }

    public function payIn(): PayIn
    {
        return new PayIn($this->client);
    }

    public function payOut(): PayOut
    {
        return new PayOut($this->client);
    }
}
