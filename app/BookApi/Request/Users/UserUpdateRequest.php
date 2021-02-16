<?php

namespace BookApi\Request\Users;

use BookApi\Request\BaseRequest;

/**
 * Class UserUpdateRequest
 * @package BookApi\Request\Users
 */
class UserUpdateRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'string|email',
            'password' => 'string',
            'telephone' => 'int|regex:/[0-9]{9}/',
            'slug' => 'string'
        ];
    }
}
