<?php

namespace App\Tests\Mock;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClient
{
    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        $body = '[{
            "genus": "Malus",
            "name": "Apple",
            "id": 6,
            "family": "Rosaceae",
            "order": "Rosales",
            "nutritions": {
                "carbohydrates": 11.4,
                "protein": 0.3,
                "fat": 0.4,
                "calories": 52,
                "sugar": 10.3
            }
        }, {
            "genus": "Prunus",
            "name": "Apricot",
            "id": 35,
            "family": "Rosaceae",
            "order": "Rosales",
            "nutritions": {
                "carbohydrates": 3.9,
                "protein": 0.5,
                "fat": 0.1,
                "calories": 15,
                "sugar": 3.2
            }
        }]';

        return new MockResponse($body, [
            'http_code' => 200,
            'response_headers' => [
                'content-type' => 'application/json',
            ],
        ]);
    }
}
