<?php

namespace MyApp\GraphQL\Type\QueryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\QueryType\AttributeSetType;
use MyApp\GraphQL\Type\QueryType\PriceType;

class ProductType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Product',
            'fields' => [
                'id' => Type::id(),
                'name' => Type::string(),
                'inStock' => Type::boolean(),
                'gallery' => Type::listOf(Type::string()),
                'description' => Type::string(),
                'category' => Type::string(),
                'attributes' => Type::listOf(new attributeSetType()),
                'prices' => Type::listOf(new PriceType()),
                'brand' => Type::string(),
            ]
        ]);
    }
}
