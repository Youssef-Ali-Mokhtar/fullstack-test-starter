<?php

namespace MyApp\services;

use MyApp\models\orderModel\Order;

class OrderService {
    private $productRepository;
    private $orderRepository;

    /**
     * OrderService constructor.
     *
     * @param mixed $productRepository The repository for products.
     * @param mixed $orderRepository The repository for orders.
     */
    public function __construct($productRepository, $orderRepository) {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Add a new order.
     *
     * @param array $data The data representing the order.
     * @return string Success message or error message if validation fails.
     * @throws Exception If some products in the order do not exist in the database.
     */
    public function addOrder($data) {
        $order = new Order($data);

        $this->checkOrderProducts($order); // Validate if each product exists in the database

        return $this->orderRepository->addOrder($order->getDetails());
    }

    /**
     * Check if all products in the order exist in the database.
     *
     * @param Order $order The order object containing products.
     * @throws Exception If some products in the order do not exist in the database.
     */
    private function checkOrderProducts($order) {
        $productIds = $order->getProductIds();

        $existingProductIds = $this->productRepository->checkProducts($productIds);

        if (count($productIds) !== count($existingProductIds)) {
            throw new Exception("Some products in the order do not exist in the database.");
        }
    }
}

