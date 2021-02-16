<?php
namespace BookApi\Request\Books;

use BookApi\Request\BaseRequest;

/**
 * Class BooksRequest
 * @package BookApi\Request\Books
 */
class BooksRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'short_description' => 'string',
        ];
    }
}
