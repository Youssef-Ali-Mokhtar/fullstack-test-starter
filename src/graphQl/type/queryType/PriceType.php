<?php

namespace MyApp\graphQl\type\queryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\graphQl\type\queryType\CurrencyType;

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
