<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Queries\UsersQuery;
use App\GraphQL\Types\UserType;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class DefaultSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'types' => [
                UserType::class
            ],
            'query' => [
                UsersQuery::class,
            ],
            'mutation' => [
                // ExampleMutation::class,
            ],
            'method' => ['GET', 'POST'],
        ];
    }
}
