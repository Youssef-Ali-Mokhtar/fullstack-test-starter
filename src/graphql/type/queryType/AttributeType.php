<?php

namespace MyApp\graphql\type\queryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Attribute',
            'fields' => [
                'id' => Type::id(),
                'displayValue' => Type::string(),
                'value' => Type::string(),
            ]
        ]);
    }
}
