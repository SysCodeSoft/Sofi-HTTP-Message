<?php

namespace Sofi\HTTP\message;

class Uri implements \Psr\Http\Message\UriInterface {

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
    private $path = [];

    /** @var string Uri query string. */
    private $query = [];

    /** @var string Uri fragment. */
    private $fragment = [];

    function __construct($uri) {
        $uri = rawurldecode($uri);
        $parts = [];
        
        if (mb_strpos($uri, 'https://') !== false) {
            $parts['scheme'] = 'https';
            $uri = mb_substr($uri, 8);
        } else {
            $parts['scheme'] = 'http';
            $uri = mb_substr($uri, 7);
        }

        $temp = explode('?', $uri);
        $uri = $temp[0];

        $t = mb_strpos($uri, '/');
        if ($t !== false) {
            $parts['host'] = mb_substr($uri, 0, $t);
            $parts['path'] = mb_substr($uri, $t);
        } else {
            $parts['path'] = '/';
        }

        if (!empty($temp[1])) {
            $parts['query'] = $temp[1];
        } else {
            $parts['query'] = '';
        }

        $this->scheme = isset($parts['scheme']) ? strtolower($parts['scheme']) : '';
        $this->userInfo = isset($parts['user']) ? $parts['user'] : '';
        $this->host = isset($parts['host']) ? $parts['host'] : '';
        $this->port = !empty($parts['port']) ? (int) $parts['port'] : null;
        if (isset($parts['path'])) {
            $this->path = $parts['path'];
        } else {
            $this->path = '/';
        }
        
        if (isset($parts['query'])) {
            $this->query = $parts['query'];
        }
        if (isset($parts['fragment'])) {
            $this->fragment = $parts['fragment'];
        }

        if (isset($parts['pass'])) {
            $this->userInfo .= ':' . $parts['pass'];
        }
    }

    static function createFromGlobals() {
        $uri = (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS']) ? 'https://' : 'http://';

        $uri .= $_SERVER['HTTP_HOST'];
        $uri .= $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';
        $uri .= !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $uri .= !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

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
    static function createUriString($scheme, $authority, $path, $query, $fragment) {
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

    public function __toString() {
        return self::createUriString(
                        $this->scheme, $this->getAuthority(), $this->getPath(), $this->getQuery(), $this->getFragment()
        );
    }

    public function getScheme() {
        return $this->scheme;
    }

    public function getAuthority() {
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

    public function getUserInfo() {
        return $this->userInfo;
    }

    public function getHost() {
        return $this->host;
    }

    public function getPort() {
        return $this->port;
    }

    public function getPath() {
        return $this->path;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getFragment() {
        return $this->fragment;
    }

    public function withFragment($fragment) {
        
    }

    public function withHost($host) {
        
    }

    public function withPath($path) {
        
    }

    public function withPort($port) {
        
    }

    public function withQuery($query) {
        
    }

    public function withScheme($scheme) {
        
    }

    public function withUserInfo($user, $password = null) {
        
    }

}
