<?php
// src/GraphQL/Type/Types.php
namespace MyApp\graphql\type;

use MyApp\graphql\type\queryType\ProductType;
use MyApp\graphql\type\queryType\CategoryType;
use MyApp\graphql\type\inputType\OrderInputType;


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
