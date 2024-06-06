<?php 

namespace MyApp\services;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use MyApp\helper\ParseProduct;
use MyApp\factories\ProductFactory;

class ProductService {
    private $productRepository;

    public function __construct($productRepository) {
        $this->productRepository = $productRepository;
    }

    //One query, only Product table, no join with attribute
    public function getAllProducts() {
        $productsData = $this->productRepository->fetchAll();
        $products = self::formatProducts($productsData);
        return $products;
    }

    //GET ONE PRODUCT BY ID IN ONE QUERY
    public function getProductById($id) {
        $data = $this->productRepository->fetchById($id);
        if (!$data) {
            throw new Exception("Product not found");
        }
        $product = self::formatProduct($data);
        return $product;
    }


    public function getProductsByCategory($category) {
        $productsData = $this->productRepository->fetchByCategory($category);
        $products = self::formatProduct($data);
        return $products;
    }






    public static function formatProduct($data) {
        $extractedProduct = ParseProduct::extractProduct($data); //EXTRACT PRODUCT 
        $extractedAttributes = ParseProduct::extractAttributes($data); //EXTRACT ATTRIBUTES
        $productObj = ProductFactory::createProduct($extractedProduct); //FACTORY PATTERN FOR PRODUCT

        $productObj->setAttributesSet($extractedAttributes); //LEVERAGING POLYMORPHISM TO SET ATTRIBUTES

        return $productObj->getDetails();
    }

    public static function formatProducts($data) {
        $organizedData = [];

        foreach ($data as $row) {
            $id = $row['productId'];
            if (!isset($organizedData[$id])) {
                $organizedData[$id] = [];
            }
            $organizedData[$id][] = $row;
        }
    
        // Reset the keys to be numerical

        $numOrganizedData = array_values($organizedData);

        $products = [];

        foreach($numOrganizedData as $p) {
            $products[] = self::formatProduct($p);
        }

        return $products;
    }

}
?>
