<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type'
    ];

    /**
     * Returns an array containing the fields of the UserType
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the user',
                'alias' => 'user_id',
                'resolve' => function ($root, $args) {
                    return $root->id;
                },
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],
            'first_name' => [
                'type' => Type::string(),
                'description' => 'The first name of user',
            ],
            'last_name' => [
                'type' => Type::string(),
                'description' => 'The last name of user',
            ],
            'email_verified_at' => [
                'type' => Type::string(),
                'description' => 'The email verified at of user',
            ],
        ];
    }

    /**
     * Resolves the field based on the root, arguments, context and the information about the field.
     *
     * @param mixed $root The source object on which the field is being resolved.
     * @param mixed[] $args The arguments passed to the field.
     * @param mixed $context The context passed to the field resolver.
     * @param ResolveInfo $info The information about the field.
     * @return string|null The resolved value of the field.
     */
    public function resolve($root, $args, $context, ResolveInfo $info): ?string
    {
        $field = $info->fieldName;

        switch ($field) {
            case 'id':
            case 'first_name':
            case 'last_name':
            case 'email':
            case 'email_verified_at':
                return $root->{$field};
        }
    }
}
