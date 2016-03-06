<?php

namespace Sofi\HTTP;

/**
 * Provides a PSR-7 implementation of a reusable raw request body
 */
class RequestBody extends Stream
{
    /**
     * Create a new RequestBody.
     */
    public function __construct()
    {
        $stream = fopen('php://temp', 'w+');
        stream_copy_to_stream(fopen('php://input', 'r'), $stream);
        rewind($stream);
        parent::__construct($stream);
    }
}