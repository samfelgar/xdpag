<?php

namespace Samfelgar\XdPag\Tests\Auth;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Samfelgar\XdPag\Auth\AuthResponse;

#[CoversClass(AuthResponse::class)]
class AuthResponseTest extends TestCase
{
    #[Test]
    public function itCanParseAResponse(): void
    {
        $json = '{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2FwaS54ZHBhZy5jb20vYXBpL2FjY291bnQvbG9naW4iLCJpYXQiOjE3Mzc0MjYxMzcsImV4cCI6MTczNzQyOTczNywibmJmIjoxNzM3NDI2MTM3LCJqdGkiOiJwYXpxY0R1ejNYWUdRQnlvIiwic3ViIjoiNTg4YTFkMDMtZWQ2Yy00MjA2LWEzZTctYzUyZjYxMTk2MDM4IiwicHJ2IjoiYzhlZTFmYzg5ZTc3NWVjNGM3Mzg2NjdlNWJlMTdhNTkwYjZkNDBmYyJ9.G9nudiZRn1TcX8XPyqI9q4rNensIi2ZiCHue2Sq0VMA",
    "token_type": "bearer",
    "expires_in": 3600
}';

        $response = new Response(body: $json);
        $auth = AuthResponse::fromResponse($response);
        $this->assertInstanceOf(AuthResponse::class, $auth);
        $this->assertEquals(3600, $auth->expiresIn);
    }
}
