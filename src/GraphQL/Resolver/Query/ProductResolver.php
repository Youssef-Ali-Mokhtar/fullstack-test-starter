<?php

namespace MyApp\GraphQL\Resolver\Query;

use MyApp\services\ProductService;

class ProductResolver {
    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function getProducts($rootValue, $args) {
        $category = $args['category'] ?? null;
        $galleryLimit = $args['galleryLimit'] ?? null;

        if ($category) {
            return $this->productService->getProductsByCategory($category, $galleryLimit);
        }

        return $this->productService->getAllProducts($galleryLimit);
    }

    public function getProductById($rootValue, $args, $context, $info) {
        $id = $args['id'] ?? null;
        $galleryLimit = $args['galleryLimit'] ?? null;

        return $this->productService->getProductById($id, $galleryLimit);
    }
}
