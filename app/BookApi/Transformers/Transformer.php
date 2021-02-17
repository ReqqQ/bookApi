<?php

namespace BookApi\Transformers;

use Illuminate\Support\Collection;

/**
 * Class Transformer
 * @package BookApi\Transformers
 */
abstract class Transformer
{
    protected const API_STATUSES = [];

    /**
     * @param string $responseName
     * @param array $parameters
     * @param Collection $controllerData
     * @return array
     */
    public function response(string $responseName, array $parameters, Collection $controllerData): array
    {
        return [
            'ver' => env('API_VER'),
            'timestamp' => time(),
            'status' => static::API_STATUSES[$responseName],
            'method' => [
                'parameters' => $parameters,
                'name' => $responseName,
                'total_items' => $controllerData->count(),
                'previous_page' => '',
                'next_page' => ''
            ],
            'data' => $controllerData->toArray()
        ];
    }
}
