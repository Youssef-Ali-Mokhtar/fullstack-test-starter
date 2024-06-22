<?php

namespace MyApp\factories;

use MyApp\models\productModel\Product;

class ProductFactory {
    
    /**
     * Create a product object based on category data.
     * 
     * @param array $data Product data containing 'category' key.
     * @return Product Created product object.
     * @throws Exception If the product class doesn't exist or isn't an instance of Product.
     */
    public static function createProduct(array $data): Product {
        // Replace spaces in category name to get class name
        $productType = str_replace(' ', '', $data['category']);

        // Build fully qualified class name for product based on category
        $pathToClass = "MyApp\\models\\productModel\\" . ucfirst($productType);

        // Check if the class exists
        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        // Create new instance of product class
        $product = new $pathToClass($data);

        // Validate if the created object is an instance of Product
        if (!($product instanceof Product)) {
            throw new Exception("Invalid product category");
        }

        // Return the created product object
        return $product;
    }
}

