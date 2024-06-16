<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the token'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the user'
            ],
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The token of the user'
            ],

            // TODO: This must be handled as a JSON string
            // Context: Due to my limited knowledge of this, I don't know yet how to handle values like
            // [expires_in: "2024-06-15T17:03:19.389896Z"]
            'abilities' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The abilities of the user',
                'resolve' => function ($root) {
                    return json_encode($root['abilities']);
                }
            ],
            'expires_at' => [
                'type' => Type::string(),
                'description' => 'The expiration date of the token'
            ],
            'tokenable_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the tokenable model'
            ],
            'tokenable_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The type of the tokenable model'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The update date of the token'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The creation date of the token'
            ],
        ];
    }
}
