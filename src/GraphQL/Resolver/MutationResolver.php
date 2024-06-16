<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\GraphQL\Type\Types;
use MyApp\database\Database;
use MyApp\services\OrderService;
use MyApp\repositories\ProductRepository;
use MyApp\repositories\OrderRepository;

class MutationResolver {

    private static $database;
    private static $db;
    private static $productRepository;
    private static $orderRepository;
    private static $orderService;
    
    public static function create() {

        self::$database = new Database();
        self::$db = self::$database->connect();

        self::$productRepository = new ProductRepository(self::$db);
        self::$orderRepository = new OrderRepository(self::$db);

        self::$orderService = new OrderService(self::$productRepository, self::$orderRepository);

        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'addOrder' => [
                    'type' => Type::string(),
                    'args' => [
                        'order' => Types::orderInput(),
                    ],
                    'resolve' => [self::class, 'addOrder']
                ],
            ],
        ]);
    
    }

    static public function addOrder($root, $args) {
        // Example resolve function logic
        $order = $args['order'];
        
        return self::$orderService->addOrder($order);
    }
    
}
