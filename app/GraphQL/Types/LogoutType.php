<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LogoutType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Logout',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Indicates whether the logout was successful',
            ],
        ];
    }
}
