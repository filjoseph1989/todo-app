<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Mutations\LoginMutation;
use App\GraphQL\Types\LoginType;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class AuthSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'types' => [
                LoginType::class,
            ],
            'query' => [
            ],
            'mutation' => [
                LoginMutation::class,
            ],
            'method' => ['GET', 'POST'],
        ];
    }
}
