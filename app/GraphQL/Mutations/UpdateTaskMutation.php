<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Task;
use Closure;
use App\GraphQL\Traits\TaskEnumTrait;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Laragraph\Utils\BadRequestGraphQLException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdateTaskMutation extends Mutation
{
    use TaskEnumTrait;

    protected $attributes = [
        'name' => 'updateTask',
        'description' => 'A mutation for updating a task',
    ];

    /**
     * Define the type of the mutation's result
     *
     * @return Type
     */
    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Task'));
    }

    /**
     * Define the arguments that can be passed to the mutation
     *
     * @return array
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the task',
            ],
            'task' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The task to be updated',
            ],
            'status' => [
                'type' => Type::nonNull($this->taskStatusType()),
                'description' => 'The status of the task',
            ]
        ];
    }

    /**
     * Resolves the mutation and returns the updated task.
     *
     * @param mixed $root the root value
     * @param array $args the arguments passed to the mutation
     * @param mixed $context the context value
     * @param ResolveInfo $resolveInfo information about the query
     * @param Closure $getSelectFields function to get the selected fields
     * @return mixed the updated task
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): mixed
    {
        $task = Task::find($args['id']);

        if (!$task) {
            throw new BadRequestGraphQLException('Task not found');
        }

        unset($args['id']);

        $task->fill($args);
        $task->save();

        return $task;
    }
}
