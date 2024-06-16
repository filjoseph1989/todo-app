<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Auth;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Login');
    }

    /**
     * Get the arguments for the mutation.
     *
     * @return array<string, \GraphQL\Type\Definition\Argument>
     */
    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of user',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The password of user',
            ],
        ];
    }

    /**
     * Define the validation rules for the mutation arguments.
     *
     * @param  array  $args The arguments passed to the mutation.
     * @return array The validation rules.
     */
    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * Resolve the mutation and return the result.
     *
     * @param mixed $root The root value.
     * @param array $args The arguments passed to the mutation.
     * @param mixed $context The context value.
     * @param ResolveInfo $resolveInfo The information about the query.
     * @param Closure $getSelectFields A function to get the selected fields.
     * @return mixed The result of the mutation.
     */
    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('GraphQL', ['expires_in' => now()->addHour()]);

            return [
                'id' => $user->id,
                'abilities' => $token->accessToken->abilities,
                'expires_at' => $token->accessToken->expires_at,
                'tokenable_id' => $token->accessToken->tokenable_id,
                'tokenable_type' => $token->accessToken->tokenable_type,
                'token' => $token->plainTextToken,
            ];
        }

        return null;
    }
}