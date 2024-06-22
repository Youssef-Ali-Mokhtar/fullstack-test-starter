<?php
/**
 * Types.php
 * 
 * This file defines singleton instances of GraphQL types used in the application.
 * Singleton pattern ensures each type is instantiated only once per request,
 * maintaining consistency and reducing overhead in GraphQL resolvers.
 */

namespace MyApp\graphql\type;

use MyApp\graphql\type\queryType\ProductType;
use MyApp\graphql\type\queryType\CategoryType;
use MyApp\graphql\type\inputType\OrderInputType;

/**
 * Singleton class for GraphQL types used in queries and mutations.
 */
class Types {
    // Singleton instances of GraphQL types
    private static $productType;
    private static $categoryType;
    private static $orderInputType;

    /**
     * Returns the singleton instance of ProductType.
     *
     * @return ProductType The singleton instance of ProductType.
     */
    public static function product() {
        return self::$productType ?: (self::$productType = new ProductType());
    }

    /**
     * Returns the singleton instance of CategoryType.
     *
     * @return CategoryType The singleton instance of CategoryType.
     */
    public static function category() {
        return self::$categoryType ?: (self::$categoryType = new CategoryType());
    }

    /**
     * Returns the singleton instance of OrderInputType.
     *
     * @return OrderInputType The singleton instance of OrderInputType.
     */
    public static function orderInput() {
        return self::$orderInputType ?: (self::$orderInputType = new OrderInputType());
    }
}
