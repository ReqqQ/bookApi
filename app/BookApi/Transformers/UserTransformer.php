<?php

namespace BookApi\Transformers;

use Illuminate\Http\Response;

/**
 * Class UserTransformer
 * @package BookApi\Transformers
 */
class UserTransformer extends Transformer
{
    public const STORE_RESPONSE = 'users.store';
    public const UPDATE_RESPONSE = 'users.update';
    public const DELETE_RESPONSE = 'users.delete';

    protected const API_STATUSES = [
        self::STORE_RESPONSE => [
            'code' => Response::HTTP_CREATED,
            'message' => 'User successfully created.'
        ],
        self::UPDATE_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => 'User successfully updated.'
        ],
        self::DELETE_RESPONSE => [
            'code' => Response::HTTP_OK,
            'message' => 'User successfully deleted.'
        ]
    ];
}
