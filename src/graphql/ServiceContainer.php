<?php

namespace MyApp\graphql;

use MyApp\database\Database;
use MyApp\repositories\ProductRepository;
use MyApp\repositories\CategoryRepository;
use MyApp\repositories\OrderRepository;
use MyApp\services\ProductService;
use MyApp\services\CategoryService;
use MyApp\services\OrderService;

/**
 * ServiceContainer class manages and provides access to GraphQL-related services.
 */

class ServiceContainer {
    private $db;
    private $productRepository;
    private $categoryRepository;
    private $orderRepository;
    private $productService;
    private $categoryService;
    private $orderService;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();

        $this->productRepository = new ProductRepository($this->db);
        $this->categoryRepository = new CategoryRepository($this->db);
        $this->orderRepository = new OrderRepository($this->db);

        $this->productService = new ProductService($this->productRepository);
        $this->categoryService = new CategoryService($this->categoryRepository);
        $this->orderService = new OrderService($this->productRepository, $this->orderRepository);
    }

    public function getProductService() {
        return $this->productService;
    }

    public function getCategoryService() {
        return $this->categoryService;
    }

    public function getOrderService() {
        return $this->orderService;
    }
}
