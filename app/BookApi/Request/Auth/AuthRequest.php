<?php

namespace BookApi\Request\Auth;

use BookApi\Request\BaseRequest;

/**
 * Class AuthRequest
 * @package BookApi\Request\Auth
 */
class AuthRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
