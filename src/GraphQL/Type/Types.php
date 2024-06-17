<?php
// src/GraphQL/Type/Types.php
namespace MyApp\GraphQL\Type;

use MyApp\GraphQL\Type\QueryType\ProductType;
use MyApp\GraphQL\Type\QueryType\CategoryType;
use MyApp\GraphQL\Type\InputType\OrderInputType;


//To make sure types are instantiated only once inside QueryResolver and MutationResolver

class Types {
    private static $productType;
    private static $categoryType;
    private static $orderInputType;

    public static function product() {
        return self::$productType ?: (self::$productType = new ProductType());
    }

    public static function category() {
        return self::$categoryType ?: (self::$categoryType = new CategoryType());
    }

    public static function orderInput() {
        return self::$orderInputType ?: (self::$orderInputType = new OrderInputType());
    }


}
