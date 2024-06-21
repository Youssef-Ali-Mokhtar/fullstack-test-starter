<?php

namespace MyApp\graphql\type\inputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\graphql\type\inputType\AttributeInputType;

class ProductInputType extends InputObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'ProductInput',
            'fields' => [
                'productId' => Type::nonNull(Type::string()),
                'id' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int()),
                'attributes' => Type::nonNull(Type::listOf(Type::nonNull(new AttributeInputType())))
            ]
        ]);
    }
}

