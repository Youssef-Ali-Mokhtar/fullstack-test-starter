<?php

namespace MyApp\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\CurrencyType;

class PriceType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Price',
            'fields' => [
                'amount' => Type::string(),
                'currency' => new CurrencyType(),
            ]
        ]);
    }
}
