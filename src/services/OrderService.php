<?php

    namespace MyApp\services;

    use MyApp\models\orderModel\Order;

    class OrderService {
        private $productRepository;
        private $orderRepository;

        public function __construct($productRepository, $orderRepository) {
            $this->productRepository = $productRepository;
            $this->orderRepository = $orderRepository;
        }

        public function addOrder($data) {

            $order = new Order($data);
    
            $order->validate(); //Validate order fields (basic validation)
            
            $this->checkOrderProducts($order); // Validate if each product exists in the database

            echo $this->orderRepository->addOrder($order->getDetails());
        }

        private function checkOrderProducts($order) {
            $productIds = $order->getProductIds();

            $existingProductIds = $this->productRepository->checkProducts($productIds);

            if (count($productIds) !== count($existingProductIds)) {
                throw new Exception("Some products in the order do not exist in the database.");
            }
        }
    }
