<?php

namespace MyApp\graphql\resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\graphql\type\Types;
use MyApp\graphql\ServiceContainer;
use MyApp\graphql\resolver\mutation\OrderResolver;

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
