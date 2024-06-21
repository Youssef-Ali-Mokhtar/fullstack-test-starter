<?php

namespace MyApp\graphQl\resolver\mutation;

use MyApp\services\OrderService;

class OrderResolver {
    private $orderService;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function addOrder($root, $args) {
        $order = $args['order'];
        return $this->orderService->addOrder($order);
    }
}
