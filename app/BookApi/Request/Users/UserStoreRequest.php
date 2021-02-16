<?php

namespace BookApi\Request\Users;

use BookApi\Request\BaseRequest;

/**
 * Class UserStoreRequest
 * @package BookApi\Request\Users
 */
class UserStoreRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'string|required|email|unique:users',
            'password' => 'string|required',
            'telephone' => 'int|required|regex:/[0-9]{9}/',
            'slug' => 'string'
        ];
    }
}
