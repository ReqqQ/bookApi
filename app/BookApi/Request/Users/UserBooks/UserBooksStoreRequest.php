<?php

namespace BookApi\Request\Users\UserBooks;

use BookApi\Request\BaseRequest;

/**
 * Class UserBooksStoreRequest
 * @package BookApi\Request\Users\UserBooks
 */
class UserBooksStoreRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'book_ids' => 'array|required'
        ];
    }
}
