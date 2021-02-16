<?php

namespace BookApi\Request\Users;

use BookApi\Request\BaseRequest;

/**
 * Class UserUpdateRequest
 * @package BookApi\Request\Users
 */
class UserDeleteRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'email' => 'string|email|required',
        ];
    }
}
