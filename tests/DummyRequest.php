<?php

namespace SamuelMwangiW\Vite\Tests;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class DummyRequest implements RequestInterface
{
    private string $version;
    private StreamInterface $body;

    public function getProtocolVersion(): string
    {
        return $this->version;
    }

    public function withProtocolVersion($version): DummyRequest|static
    {
        $this->version = $version;

        return $this;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function hasHeader($name): bool
    {
        return true;
    }

    public function getHeader($name): array
    {
        return ['dummy'];
    }

    public function getHeaderLine($name): string
    {
        return '-';
    }

    public function withHeader($name, $value): DummyRequest|static
    {
        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        return $this;
    }

    public function withoutHeader($name)
    {
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    public function getRequestTarget()
    {
        return '-';
    }

    public function withRequestTarget($requestTarget)
    {
        return $this;
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function withMethod($method)
    {
        return $this;
    }

    public function getUri()
    {
        return Uri::fromParts([]);
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return $this;
    }
}
