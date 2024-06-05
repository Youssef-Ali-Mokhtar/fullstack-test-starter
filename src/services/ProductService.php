<?php 

namespace MyApp\services;

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
        //DO I NEED A FACTORY METHOD HERE?
        $products = ParseProduct::convertInStockToBool($productsData);
        return $products;
    }

    //GET ONE PRODUCT BY ID IN ONE QUERY
    public function getProductById($id) {

        $data = $this->productRepository->fetchById($id);

        if (!$data) {
            throw new Exception("Product not found");
        }
        
        $extractedProduct = ParseProduct::extractProduct($data); //EXTRACT PRODUCT 
        $extractedAttributes = ParseProduct::extractAttributes($data); //EXTRACT ATTRIBUTES
        $productObj = ProductFactory::createProduct($extractedProduct); //FACTORY PATTERN FOR PRODUCT

        $productObj->setAttributesSet($extractedAttributes); //LEVERAGING POLYMORPHISM TO SET ATTRIBUTES

        return $productObj->getDetails();
    }

    public function getProductsByCategory($category) {
        $productsData = $this->productRepository->fetchByCategory($category);
        $products = ParseProduct::convertInStockToBool($productsData);
        return $products;
    }
}
?>
