<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Auth;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

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
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if ($user = Auth::user()) {
            $user->currentAccessToken()->delete();

            return [ 'message' => 'Successfully logged out' ];
        }

        return [ 'message' => 'User not authenticated' ];
    }
}
