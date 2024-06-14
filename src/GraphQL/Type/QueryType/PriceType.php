<?php

namespace MyApp\GraphQL\Type\QueryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use MyApp\GraphQL\Type\QueryType\CurrencyType;

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
