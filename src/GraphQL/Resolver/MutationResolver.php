<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\Types;
use MyApp\GraphQL\ServiceContainer;
use MyApp\GraphQL\Resolver\Mutation\OrderResolver;

class MutationResolver {
    public static function create(ServiceContainer $serviceContainer) {
        $orderResolver = new OrderResolver($serviceContainer->getOrderService());

        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'addOrder' => [
                    'type' => Type::string(),
                    'args' => [
                        'order' => Types::orderInput(),
                    ],
                    'resolve' => [$orderResolver, 'addOrder']
                ],
            ],
        ]);
    }
}
