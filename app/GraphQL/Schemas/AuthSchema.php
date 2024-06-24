<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Mutations\LoginMutation;
use App\GraphQL\Mutations\RegisterMutation;
use App\GraphQL\Types\LoginType;
use App\GraphQL\Types\RegisterType;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class AuthSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'types' => [
                LoginType::class,
                RegisterType::class,
            ],
            'query' => [
            ],
            'mutation' => [
                LoginMutation::class,
                RegisterMutation::class,
            ],
            'method' => ['POST'],
        ];
    }
}
