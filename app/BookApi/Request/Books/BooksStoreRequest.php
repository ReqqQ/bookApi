<?php

namespace BookApi\Request\Books;

use BookApi\Request\BaseRequest;

/**
 * Class BooksStoreRequest
 * @package BookApi\Request\Books
 */
class BooksStoreRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'title' => 'string|required',
            'description' => 'string|required',
            'short_description' => 'string|required',
        ];
    }
}
