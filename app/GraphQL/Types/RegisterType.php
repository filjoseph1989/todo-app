<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class RegisterType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Register',
        'description' => 'Register a new user',
    ];

    public function fields(): array
    {
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Successful registered',
            ],
        ];
    }
}