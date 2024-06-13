<?php

namespace App\GraphQL\Traits;

use GraphQL\Type\Definition\EnumType;

trait TaskEnumTrait
{
    /**
     * Returns the GraphQL EnumType for the task status.
     *
     * @return EnumType The GraphQL EnumType for the task status.
     */
    protected function taskStatusType(): EnumType
    {
        return new EnumType([
            'name' => 'TaskStatus',
            'values' => [
                'TODO' => ['value' => 'todo'],
                'DONE' => ['value' => 'done'],
            ],
        ]);
    }
}
