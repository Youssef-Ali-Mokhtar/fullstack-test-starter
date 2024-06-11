<?php


namespace MyApp\factories;

use MyApp\models\productModel\Product;


class ProductFactory {
    public static function createProduct(array $data): Product {
        $productType = str_replace(' ', '', $data['category']);

        

        // CHANGE VARIABLE NAME!!!
        $pathToClass = "MyApp\\models\\productModel\\" . ucfirst($productType);

        

        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        $product = new $pathToClass($data);

        if (!($product instanceof Product)) {
            throw new Exception("Invalid product category");
        }

        return $product;
    }
}

