<?php

namespace MyApp\graphql\type\queryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\graphql\type\queryType\CurrencyType;

class PriceType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Price',
            'fields' => [
                'amount' => Type::float(),
                'currency' => new CurrencyType(),
            ]
        ]);
    }
}
