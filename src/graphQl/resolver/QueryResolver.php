<?php

namespace MyApp\graphQl\resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\graphQl\type\Types;
use MyApp\graphQl\ServiceContainer;
use MyApp\graphQl\resolver\query\CategoryResolver;
use MyApp\graphQl\resolver\query\ProductResolver;

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
