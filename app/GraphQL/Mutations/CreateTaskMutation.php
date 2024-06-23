<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Task;
use App\GraphQL\Traits\TaskEnumTrait;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateTaskMutation extends Mutation
{
    use TaskEnumTrait;

    protected $attributes = [
        'name' => 'createTask',
        'description' => 'A mutation'
    ];

    /**
     * Define the return type of the mutation.
     *
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Task'));
    }

    /**
     * Get the arguments for the mutation.
     *
     * @return array<string, \GraphQL\Type\Definition\InputObjectType>
     */
    public function args(): array
    {
        return [
            'task' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The task to be updated',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The user id of the task',
            ]
        ];
    }

    /**
     * Resolves the mutation and creates a new task.
     *
     * @param mixed $root The root value of the mutation.
     * @param array $args The arguments passed to the mutation.
     * @param mixed $context The context of the mutation.
     * @param ResolveInfo $resolveInfo Information about the resolver.
     * @param Closure $getSelectFields A function to get the fields to select.
     * @return Task The newly created task.
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): Task
    {
        $validator = Validator::make($args, [
            'task' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $task = Task::create([
            'task' => $args['task'],
            'user_id' => $args['user_id'],
        ]);

        return $task;
    }
}