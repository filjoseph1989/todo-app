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
use Rebing\GraphQL\Support\Mutation;

class DeleteTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTask',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    /**
     * Get the arguments for the mutation.
     *
     * @return array<string, \GraphQL\Type\Definition\Argument>
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the task to delete',
            ]
        ];
    }

    /**
     * Resolves the mutation and deletes a task.
     *
     * @param mixed $root The root value of the mutation.
     * @param array $args The arguments passed to the mutation.
     * @param mixed $context The context value of the mutation.
     * @param ResolveInfo $resolveInfo Information about the resolver.
     * @param Closure $getSelectFields A function to get the selected fields.
     * @return bool True if the task was deleted, false otherwise.
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): bool
    {
        $validator = Validator::make($args, [
            'id' => 'required|integer|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $task = Task::find($args['id']);

        if (!$task) {
            throw new BadRequestGraphQLException("Task not found");
        }

        $task->delete();

        return true;
    }
}