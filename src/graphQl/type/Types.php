<?php
// src/GraphQL/Type/Types.php
namespace MyApp\graphQl\type;

use MyApp\graphQl\type\queryType\ProductType;
use MyApp\graphQl\type\queryType\CategoryType;
use MyApp\graphQl\type\inputType\OrderInputType;


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
