<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Mutations\CreateTaskMutation;
use App\GraphQL\Mutations\DeleteTaskMutation;
use App\GraphQL\Mutations\LoginMutation;
use App\GraphQL\Mutations\UpdateTaskMutation;
use App\GraphQL\Queries\TaskQuery;
use App\GraphQL\Queries\UsersQuery;
use App\GraphQL\Types\LoginType;
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
                TaskType::class,
                LoginType::class,
            ],
            'query' => [
                UsersQuery::class,
                TaskQuery::class,
            ],
            'mutation' => [
                UpdateTaskMutation::class,
                CreateTaskMutation::class,
                DeleteTaskMutation::class,
                LoginMutation::class,
            ],
            'method' => ['GET', 'POST'],
        ];
    }
}
