<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Queries\TaskQuery;
use App\GraphQL\Queries\UsersQuery;
use App\GraphQL\Types\UserType;
use App\GraphQL\Types\TaskType;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class DefaultSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'types' => [
                UserType::class,
                TaskType::class
            ],
            'query' => [
                UsersQuery::class,
                TaskQuery::class,
            ],
            'mutation' => [
                // ExampleMutation::class,
            ],
            'method' => ['GET', 'POST'],
        ];
    }
}
