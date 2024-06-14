<?php

namespace MyApp\GraphQL\Type\QueryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\QueryType\AttributeType;

class AttributeSetType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::id(),
                'name' => Type::string(),
                'type' => Type::string(),
                'items' => Type::listOf(new AttributeType()),
            ]
        ]);
    }
}
