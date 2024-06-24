<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class RegisterMutation extends Mutation
{
    protected $attributes = [
        'name' => 'register',
        'description' => 'A register mutation'
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Register'));
    }

    public function args(): array
    {
        return [
            'first_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The first name of user',
            ],
            'last_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The last name of user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of user',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The password of user',
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user = User::create($args);

        if ($user) {
            return [
                'message' => 'User created successfully',
            ];
        }
    }
}
