<?php

namespace MyApp\graphql\type\inputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\graphql\type\inputType\ProductInputType;

class OrderInputType extends InputObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'OrderInput',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'totalQuantity' => Type::nonNull(Type::int()),
                'totalAmount' => Type::nonNull(Type::float()),
                'currencyLabel' => Type::nonNull(Type::string()),
                'products' => Type::listOf(new ProductInputType())
            ]
        ]);
    }
}


