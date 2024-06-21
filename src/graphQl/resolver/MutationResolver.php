<?php

namespace MyApp\graphQl\resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\graphQl\type\Types;
use MyApp\graphQl\ServiceContainer;
use MyApp\graphQl\resolver\mutation\OrderResolver;

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
