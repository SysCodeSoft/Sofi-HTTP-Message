<?php

namespace Sofi\HTTP\message;

class ServerRequest extends Request implements \Psr\Http\Message\ServerRequestInterface
{

    public static function createFromGlobals(array $globals = [])
    {
        if ($globals == []) {
            $globals = $_SERVER;
        }

        $env = new \Sofi\Base\Collection($globals);
        $method = $env->get('REQUEST_METHOD');
        $uri = \Sofi\HTTP\message\Uri::createFromGlobals($globals);
        $headers = \Sofi\HTTP\Headers::createFromGlobals($globals);
        $cookies = \Sofi\HTTP\Cookies::parseHeader($headers->get('Cookie', []));
        $serverParams = $globals;
        $body = new \Sofi\HTTP\RequestBody();
        $uploadedFiles = \Sofi\HTTP\UploadedFile::createFromGlobals($globals);
        $request = new static($method, $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        if ($method === 'POST' &&
                in_array($request->getMediaType(), ['application/x-www-form-urlencoded', 'multipart/form-data'])
        ) {
            // parsed body must be $_POST
            $request = $request->withParsedBody($_POST);
        }
        return $request;
    }

    public static function createFromApache(array $globals, $uri = '')
    {
        $env = new \Sofi\Base\Collection($globals);
        $method = $env->get('REQUEST_METHOD');
        $uri = new \Sofi\HTTP\message\Uri($_SERVER['HTTP_HOST'] . '/' . $_GET['request_string']);
        $headers = \Sofi\HTTP\Headers::createFromGlobals($globals);
        $cookies = \Sofi\HTTP\Cookies::parseHeader($headers->get('Cookie', []));
        $serverParams = $globals;
        $body = new \Sofi\HTTP\RequestBody();
        $uploadedFiles = \Sofi\HTTP\UploadedFile::createFromGlobals($globals);
        $request = new static($method, $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        if ($method === 'POST' &&
                in_array($request->getMediaType(), ['application/x-www-form-urlencoded', 'multipart/form-data'])
        ) {
            // parsed body must be $_POST
            $request = $request->withParsedBody($_POST);
        }
        return $request;
    }
    
    public function requestAcceptPriority()
    {
        $Accept = explode(',', $this->getHeader('Accept')[0]);
        $runtimeData['AcceptPriority'] = [];
        foreach ($Accept as $value) {
            $q = explode(';', $value);
            if (isset($q[1])) {
                $runtimeData['AcceptPriority'][10 * floatval(mb_substr($q[1], 2))][] = $q[0];
            } else {
                $runtimeData['AcceptPriority'][10][] = $q[0];
            }
        }

        return $runtimeData['AcceptPriority'];
    }

//    public function getAttribute($name, $default = null)
//    {
//        
//    }
//
//    public function getHeader($name)
//    {
//        
//    }
//
//    public function getHeaderLine($name)
//    {
//        
//    }
//
//    public function hasHeader($name)
//    {
//        
//    }
//
//    public function withAddedHeader($name, $value)
//    {
//        
//    }
//
//    public function withAttribute($name, $value)
//    {
//        
//    }
//
//    public function withBody(\Psr\Http\Message\StreamInterface $body)
//    {
//        
//    }
//
//    public function withCookieParams(array $cookies)
//    {
//        
//    }
//
//    public function withHeader($name, $value)
//    {
//        
//    }
//
//    public function withMethod($method)
//    {
//        
//    }
//
//    public function withParsedBody($data)
//    {
//        
//    }
//
//    public function withProtocolVersion($version)
//    {
//        
//    }
//
//    public function withQueryParams(array $query)
//    {
//        
//    }
//
//    public function withRequestTarget($requestTarget)
//    {
//        
//    }
//
//    public function withUploadedFiles(array $uploadedFiles)
//    {
//        
//    }
//
//    public function withUri(\Psr\Http\Message\UriInterface $uri, $preserveHost = false)
//    {
//        
//    }
//
//    public function withoutAttribute($name)
//    {
//        
//    }
//
//    public function withoutHeader($name)
//    {
//        
//    }

}
