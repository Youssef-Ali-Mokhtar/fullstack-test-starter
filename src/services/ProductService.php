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

    //Get all products
    public function getAllProducts($galleryLimit = NULL) {
        //Fetch products joined with attributes (without gallery)
        $productsData = $this->productRepository->fetchAll();

        $products = $this->transformProducts($productsData, $galleryLimit);

        // echo json_encode($products[0]['prices']);
        return $products;
    }

    //Get product by id
    public function getProductById($id, $galleryLimit=NULL) {
        $productsData = $this->productRepository->fetchById($id);
        if (!$productsData) {
            throw new Exception("Product not found");
        }

        [$products] = $this->transformProducts($productsData, $galleryLimit);

        return $products;
    }

    //Get products by category
    public function getProductsByCategory($category, $galleryLimit = NULL) {
        $productsData = $this->productRepository->fetchByCategory($category);

        $products = $this->transformProducts($productsData, $galleryLimit);

        return $products;
    }




    //Create product object and apply POLYMORPHISM
    public function processProduct($extractedProduct, $extractedAttributes) {

        $productObj = ProductFactory::createProduct($extractedProduct); //Create product object using factory pattern

        $productObj->setAttributesSet($extractedAttributes); //Leverage polymorphism to assign attributes data to its product

        return $productObj->getDetails(); //Extract data from product object
    }

    //Transforms duplicated SQL raw data into a format that matches the required schema
    public function transformProducts($productsData, $galleryLimit = NULL) {
        //Assign product rows to it's associated product id
        $aggregateProducts = ParseProduct::aggregateData($productsData);

        //Extract product ids to fetch gallery data
        $productIds = [];
        foreach($aggregateProducts as $key=>$value) {
            $productIds[] = $key;
        }
        
        //Fetch gallery pictures for products
        $galleryData = $this->productRepository->fetchGallery(productIds:$productIds, limit:$galleryLimit);
        
        //Assign gallery rows to its associated product id
        $aggregatedGallery = ParseProduct::aggregateData($galleryData);

        //Extract url string from gallery data
        $galleryMatched = [];
        foreach($aggregatedGallery as $key=>$value) {
            $galleryMatched[$key] = array_map(function($g){
                return $g["url"];
            },$value);
        }
        
        //For each product inside transformProduct function, we attach gallery to product
        //Then leverage polymorphism for each product
        $products = [];
        foreach($aggregateProducts as $key => $value) {
            $extractedProduct = ParseProduct::extractProduct($value); //Extract product without attributes data
            $extractedProduct['gallery'] = $galleryMatched[$key];  //Attach gallery associated with its product
            $extractedAttributes = ParseProduct::extractAttributes($value); //Extract attributes without product data

            $products[] = $this->processProduct($extractedProduct, $extractedAttributes);
        }

        return $products;
    }


}
?>
