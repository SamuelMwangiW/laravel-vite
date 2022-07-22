<?php

declare(strict_types=1);

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

    public function withAddedHeader($name, $value): DummyRequest|static
    {
        return $this;
    }

    public function withoutHeader($name): DummyRequest|static
    {
        return $this;
    }

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): DummyRequest|static
    {
        $this->body = $body;

        return $this;
    }

    public function getRequestTarget(): string
    {
        return '-';
    }

    public function withRequestTarget($requestTarget): DummyRequest|static
    {
        return $this;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function withMethod($method): DummyRequest|static
    {
        return $this;
    }

    public function getUri(): UriInterface
    {
        return Uri::fromParts([]);
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return $this;
    }
}
