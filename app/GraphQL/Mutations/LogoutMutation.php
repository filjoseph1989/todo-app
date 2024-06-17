<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Auth;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LogoutMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logout',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Logout');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the user',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $userId = $args['user_id'];
        $user = Auth::user();

        if ($user && $user->id === (int)$userId) {
            $user->tokens()->delete();
            return [ 'message' => 'Successfully logged out' ];
        } else {
            return [ 'message' => 'User not authenticated' ];
        }
    }
}
