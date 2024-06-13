<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\EnumType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'A task',
        'model' => Task::class,
    ];

    public function fields(): array
    {
        $taskStatusType = new EnumType([
            'name' => 'TaskStatus',
            'values' => [
                'TODO' => ['value' => 'todo'],
                'DONE' => ['value' => 'done'],
            ],
        ]);

        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the task',
            ],
            'task' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The task',
            ],
            'status' => [
                'type' => $taskStatusType,
                'description' => 'The status of the task',
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User')),
                'description' => 'The user of the task',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the task',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The update date of the task',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $field = $info->fieldName;

        switch ($field) {
            case 'id':
            case 'task':
            case 'status':
                return $root->{$field};
            case 'user':
                return $root->user;
        }
    }
}