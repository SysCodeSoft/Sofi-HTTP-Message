<?php

namespace Sofi\HTTP\Message;

class ServerRequest extends Request implements Psr\Http\Message\ServerRequestInterface
{
    
    public function getAttribute($name, $default = null)
    {
        
    }

    public function getAttributes()
    {
        
    }

    public function getBody()
    {
        
    }

    public function getCookieParams()
    {
        
    }

    public function getHeader($name)
    {
        
    }

    public function getHeaderLine($name)
    {
        
    }

    public function getHeaders()
    {
        
    }

    public function getMethod()
    {
        
    }

    public function getParsedBody()
    {
        
    }

    public function getProtocolVersion()
    {
        
    }

    public function getQueryParams()
    {
        
    }

    public function getRequestTarget()
    {
        
    }

    public function getServerParams()
    {
        
    }

    public function getUploadedFiles()
    {
        
    }

    public function getUri()
    {
        
    }

    public function hasHeader($name)
    {
        
    }

    public function withAddedHeader($name, $value)
    {
        
    }

    public function withAttribute($name, $value)
    {
        
    }

    public function withBody(\Psr\Http\Message\StreamInterface $body)
    {
        
    }

    public function withCookieParams(array $cookies)
    {
        
    }

    public function withHeader($name, $value)
    {
        
    }

    public function withMethod($method)
    {
        
    }

    public function withParsedBody($data)
    {
        
    }

    public function withProtocolVersion($version)
    {
        
    }

    public function withQueryParams(array $query)
    {
        
    }

    public function withRequestTarget($requestTarget)
    {
        
    }

    public function withUploadedFiles($uploadedFiles)
    {
        
    }

    public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false)
    {
        
    }

    public function withoutAttribute($name)
    {
        
    }

    public function withoutHeader($name)
    {
        
    }

}
