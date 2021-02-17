<?php

namespace BookApi\Interfaces\Request;

/**
 * Interface RequestInterface
 * @package BookApi\Interfaces\Request
 */
interface RequestInterface
{
    /**
     * @param null $userId
     * @return array
     */
    public function validateRequest($userId = null): array;

    /**
     * @param int $userId
     */
    public function validateCurrentUser(int $userId): void;
}
