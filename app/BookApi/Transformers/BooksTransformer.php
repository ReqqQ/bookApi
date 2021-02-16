<?php

namespace BookApi\Transformers;

use Illuminate\Http\Response;

/**
 * Class BooksTransformer
 * @package BookApi\Transformers
 */
class BooksTransformer extends Transformer
{
    public const INDEX_RESPONSE = 'books.index';
    public const STORE_RESPONSE = 'books.store';
    public const UPDATE_RESPONSE = 'books.update';
    public const DELETE_RESPONSE = 'books.delete';

    protected const API_STATUSES = [
        self::INDEX_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => ''
        ],
        self::STORE_RESPONSE => [
            'code' => Response::HTTP_CREATED,
            'message' => 'Book successfully created.'
        ],
        self::UPDATE_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => 'Book successfully updated.'
        ],
        self::DELETE_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => 'Book successfully deleted.'
        ]
    ];
}
