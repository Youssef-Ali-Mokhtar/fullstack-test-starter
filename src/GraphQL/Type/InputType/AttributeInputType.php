<?php

namespace MyApp\GraphQL\Type\InputType;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class AttributeInputType extends InputObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'AttributeInput',
            'fields' => [
                'attributeId' => Type::nonNull(Type::string()),
                'itemId' => Type::nonNull(Type::string())
            ]
        ]);
    }
}