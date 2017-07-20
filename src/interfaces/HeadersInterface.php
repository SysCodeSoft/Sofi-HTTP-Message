<?php

namespace Sofi\HTTP\interfaces;

/**
 * Headers Interface
 *
 * @package Sofi
 * @since   1.0.0
 */
interface HeadersInterface extends \Sofi\Base\interfaces\CollectionInterface
{
    public function add($key, $value);
    public function normalizeKey($key);
}