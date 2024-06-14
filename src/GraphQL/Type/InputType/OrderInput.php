<?php

namespace MyApp\GraphQL\Type\InputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\GraphQL\Type\InputType\ProductInput;

class OrderInput extends InputObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'OrderInput',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'totalQuantity' => Type::nonNull(Type::int()),
                'totalAmount' => Type::nonNull(Type::float()),
                'currencyLabel' => Type::nonNull(Type::string()),
                'products' => Type::listOf(new ProductInput())
            ]
        ]);
    }
}


