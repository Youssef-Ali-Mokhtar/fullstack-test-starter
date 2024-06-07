<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MutationResolver {
    public static function create() {
        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'sum' => [
                    'type' => Type::int(),
                    'args' => [
                        'x' => ['type' => Type::int()],
                        'y' => ['type' => Type::int()],
                    ],
                    'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
                ],
            ],
        ]);
    }
}
