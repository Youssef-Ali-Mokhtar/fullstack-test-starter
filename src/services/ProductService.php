<?php 

namespace MyApp\services;

use MyApp\helper\ParseProduct;
use MyApp\factories\ProductFactory;
use Exception;

class ProductService {

    private $productRepository;

    /**
     * ProductService constructor.
     *
     * @param mixed $productRepository The repository responsible for product data access.
     */
    public function __construct($productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Fetch all products optionally limiting gallery images.
     *
     * @param int|null $galleryLimit The maximum number of gallery images to fetch per product.
     * @return array Processed products data.
     */
    public function getAllProducts($galleryLimit = NULL) {
        $productsData = $this->productRepository->fetchAll(); // Fetch raw product data
        $products = $this->transformProducts($productsData, $galleryLimit); // Transform and format products
        return $products;
    }

    /**
     * Fetch a product by its ID optionally limiting gallery images.
     *
     * @param int $id The product ID to fetch.
     * @param int|null $galleryLimit The maximum number of gallery images to fetch.
     * @return array Processed product data.
     * @throws Exception If the product with the given ID is not found.
     */
    public function getProductById($id, $galleryLimit = NULL) {
        $productsData = $this->productRepository->fetchById($id); // Fetch product data by ID
        if (!$productsData) {
            throw new Exception("Product not found");
        }
        [$product] = $this->transformProducts($productsData, $galleryLimit); // Transform and format product
        return $product;
    }

    /**
     * Fetch products by category optionally limiting gallery images.
     *
     * @param string $category The category name to filter products.
     * @param int|null $galleryLimit The maximum number of gallery images to fetch per product.
     * @return array Processed products data.
     */
    public function getProductsByCategory($category, $galleryLimit = NULL) {
        $productsData = $this->productRepository->fetchByCategory($category); // Fetch product data by category
        $products = $this->transformProducts($productsData, $galleryLimit); // Transform and format products
        return $products;
    }

    /**
     * Process extracted product and attribute data to create a product object.
     * Uses factory pattern to create a product object and polymorphism to assign attribute data.
     *
     * @param array $extractedProduct Extracted product data.
     * @param array $extractedAttributes Extracted attribute data associated with the product.
     * @return array Details of the created product object.
     */
    public function processProduct($extractedProduct, $extractedAttributes) {
        $productObj = ProductFactory::createProduct($extractedProduct); // Create product object using factory pattern
        $productObj->setAttributesSet($extractedAttributes); // Assign attributes data to product using polymorphism
        return $productObj->getDetails(); // Extract and return data from product object
    }


    /**
     * Transform raw product data into a structured format including gallery images.
     *
     * @param array $productsData Raw product data fetched from the repository.
     * @param int|null $galleryLimit The maximum number of gallery images to fetch per product.
     * @return array Processed products data with attached gallery images.
     */
    public function transformProducts($productsData, $galleryLimit = NULL) {
        $aggregateProducts = ParseProduct::aggregateData($productsData); // Aggregate and organize product data
        $productIds = array_keys($aggregateProducts); // Extract product IDs to fetch gallery data

        $galleryData = $this->productRepository->fetchGallery($productIds, $galleryLimit); // Fetch gallery data by product IDs
        $aggregatedGallery = ParseProduct::aggregateData($galleryData); // Aggregate and organize gallery data

        // Extract URLs from gallery data and associate them with product IDs
        $galleryMatched = [];
        foreach ($aggregatedGallery as $key => $value) {
            $galleryMatched[$key] = array_map(function($g) {
                return $g["url"];
            }, $value);
        }

        $products = [];
        foreach ($aggregateProducts as $key => $value) {
            $extractedProduct = ParseProduct::extractProduct($value); // Extract product data excluding attributes
            $extractedProduct['gallery'] = $galleryMatched[$key]; // Attach gallery images to the product data
            $extractedAttributes = ParseProduct::extractAttributes($value); // Extract attributes associated with the product

            $products[] = $this->processProduct($extractedProduct, $extractedAttributes); // Process each product
        }

        return $products; // Return processed products data
    }

}

