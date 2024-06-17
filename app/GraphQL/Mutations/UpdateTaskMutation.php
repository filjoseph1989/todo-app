<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Task;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laragraph\Utils\BadRequestGraphQLException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateTaskMutation extends Mutation
{
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
                'type' => Type::nonNull(Type::string()),
                'description' => 'The status of the task',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::Id()),
                'description' => 'The user id of the task',
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required'],
            'task' => ['required'],
            'status' => ['required'],
            'user_id' => ['required'],
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
        $validator = Validator::make($args, [
            'task' => 'required|string',
            'status' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $task = Task::find($args['id']);

        if (!$task) {
            throw new BadRequestGraphQLException('Task not found');
        }

        if ($task->user_id !== (int)$args['user_id']) {
            throw new BadRequestGraphQLException('You are not authorized to update this task');
        }

        unset($args['id']);
        $task->fill($args);
        $task->save();

        return $task;
    }
}
