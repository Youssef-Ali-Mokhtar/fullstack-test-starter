<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\Types;
use MyApp\GraphQL\ServiceContainer;
use MyApp\GraphQL\Resolver\Query\CategoryResolver;
use MyApp\GraphQL\Resolver\Query\ProductResolver;

class QueryResolver {
    public static function create(ServiceContainer $serviceContainer) {
        $categoryResolver = new CategoryResolver($serviceContainer->getCategoryService());
        $productResolver = new ProductResolver($serviceContainer->getProductService());

        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(Types::category()),
                    'resolve' => [$categoryResolver, 'getCategories'],
                ],
                'products' => [
                    'type' => Type::listOf(Types::product()),
                    'args' => [
                        'category' => Type::string(),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [$productResolver, 'getProducts'],
                ],
                'product' => [
                    'type' => Types::product(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [$productResolver, 'getProductById'],
                ],
            ]
        ]);
    }
}
