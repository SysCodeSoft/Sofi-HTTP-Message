<?php

namespace Sofi\HTTP\Message;

class Uri implements \Psr\Http\Message\UriInterface
{

    private static $schemes = [
        'http' => 80,
        'https' => 443,
    ];

    /** @var string Uri scheme. */
    private $scheme = '';

    /** @var string Uri user info. */
    private $userInfo = '';

    /** @var string Uri host. */
    private $host = '';

    /** @var int|null Uri port. */
    private $port;

    /** @var string Uri path. */
    private $path = [''];

    /** @var string Uri query string. */
    private $query = [];

    /** @var string Uri fragment. */
    private $fragment = [];

    function __construct($uri)
    {
        $uri = rawurldecode($uri);
        $parts = parse_url($uri);

        $this->scheme = isset($parts['scheme']) ? strtolower($parts['scheme']) : '';
        $this->userInfo = isset($parts['user']) ? $parts['user'] : '';
        $this->host = isset($parts['host']) ? $parts['host'] : '';
        $this->port = !empty($parts['port']) ? (int) $parts['port'] : null;

        if (isset($parts['path'])) {
            $this->path = explode('/', mb_strtolower($parts['path']));
        }        
        if (isset($parts['query'])) {
            $this->query = explode('?', $parts['query']);
        }
        if (isset($parts['fragment'])) {
            $this->fragment = explode('#', $parts['fragment']);
        }
        
        if (isset($parts['pass'])) {
            $this->userInfo .= ':' . $parts['pass'];
        }
    }

    static function createFromGlobals()
    {
        $uri = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS']) ? 'https://' : 'http://';

        $uri .= $_SERVER['SERVER_NAME'];
        $uri .= $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';
        $uri .= $_SERVER['PATH_INFO'];
        $uri .=!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

        return new self($uri);
    }

    /**
     * Create a URI string from its various parts
     *
     * @param string $scheme
     * @param string $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @return string
     */
    static function createUriString($scheme, $authority, $path, $query, $fragment)
    {
        $uri = '';
        if (!empty($scheme)) {
            $uri .= $scheme . ':';
        }
        $hierPart = '';
        if (!empty($authority)) {
            if (!empty($scheme)) {
                $hierPart .= '//';
            }
            $hierPart .= $authority;
        }
        if ($path != null) {
            // Add a leading slash if necessary.
            if ($hierPart && substr($path, 0, 1) !== '/') {
                $hierPart .= '/';
            }
            $hierPart .= $path;
        }
        $uri .= $hierPart;
        if ($query != null) {
            $uri .= '?' . $query;
        }
        if ($fragment != null) {
            $uri .= '#' . $fragment;
        }
        return $uri;
    }

    public function __toString()
    {
        return self::createUriString(
                $this->scheme, 
                $this->getAuthority(), 
                $this->getPath(), 
                $this->getQuery(), 
                $this->getFragment()
        );
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        if (empty($this->host)) {
            return '';
        }
        $authority = $this->host;
        if (!empty($this->userInfo)) {
            $authority = $this->userInfo . '@' . $authority;
        }
        if ((!$this->scheme && $this->port) ||
                (!empty($this->scheme) && $this->port !== static::$schemes[$this->scheme])) {
            $authority .= ':' . $this->port;
        }
        return $authority;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path == [] ? '' : implode('/', $this->path);
    }

    public function getQuery()
    {
        return $this->query == [] ? '' : implode('&', $this->query);
    }

    public function getFragment()
    {
        return $this->fragment == [] ? '' : implode('#', $this->fragment);
    }

    public function withFragment($fragment)
    {
        
    }

    public function withHost($host)
    {
        
    }

    public function withPath($path)
    {
        
    }

    public function withPort($port)
    {
        
    }

    public function withQuery($query)
    {
        
    }

    public function withScheme($scheme)
    {
        
    }

    public function withUserInfo($user, $password = null)
    {
        
    }

}
