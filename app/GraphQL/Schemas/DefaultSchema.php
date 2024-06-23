<?php

namespace App\GraphQL\Schemas;

use App\GraphQL\Mutations\CreateTaskMutation;
use App\GraphQL\Mutations\DeleteTaskMutation;
use App\GraphQL\Mutations\LogoutMutation;
use App\GraphQL\Mutations\UpdateTaskMutation;
use App\GraphQL\Queries\TaskQuery;
use App\GraphQL\Queries\UsersQuery;
use App\GraphQL\Types\LogoutType;
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
                LogoutType::class,
            ],
            'query' => [
                UsersQuery::class,
                TaskQuery::class,
            ],
            'mutation' => [
                UpdateTaskMutation::class,
                CreateTaskMutation::class,
                DeleteTaskMutation::class,
                LogoutMutation::class,
            ],
            'method' => ['GET', 'POST'],
            'middleware' => ['auth:sanctum'],
        ];
    }
}