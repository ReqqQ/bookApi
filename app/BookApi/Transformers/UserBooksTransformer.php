<?php

namespace BookApi\Transformers;

use Illuminate\Http\Response;

/**
 * Class UserBooksTransformer
 * @package BookApi\Transformers
 */
class UserBooksTransformer extends Transformer
{
    public const STORE_RESPONSE = 'users.books.store';
    public const INDEX_RESPONSE = 'users.books.index';

    protected const API_STATUSES = [
        self::INDEX_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => ''
        ],
        self::STORE_RESPONSE => [
            'code' => Response::HTTP_CREATED,
            'message' => 'Books successfully added to user.'
        ]
    ];
}
