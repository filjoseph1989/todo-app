<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\SelectFields;

class TaskQuery extends Query
{
    protected $attributes = [
        'name' => 'task',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Task'))));
    }

    /**
     * Get the arguments for the query.
     *
     * @return array
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The id of the task',
            ],
            'task' => [
                'type' => Type::string(),
                'description' => 'The task',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of the task',
            ],
            'user_id' => [
                'type' => Type::id(),
                'description' => 'The id of the user',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $query = Task::query();

        if (isset($args['id'])) {
            return $query->where('id', $args['id'])->get();
        }

        if (isset($args['task'])) {
            return $query->where('task', 'like', '%' . $args['task'] . '%')->get();
        }

        if (isset($args['status'])) {
            return $query->where('status', $args['status'])->get();
        }

        if (isset($args['user_id'])) {
            return $query->where('user_id', $args['user_id'])->get();
        }

        return Task::all();
    }
}
