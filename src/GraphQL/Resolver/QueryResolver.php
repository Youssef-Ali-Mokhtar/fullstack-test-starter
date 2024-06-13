<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\GraphQL\Type\ProductType;
use MyApp\GraphQL\Type\CategoryType;

use MyApp\database\Database;
use MyApp\repositories\ProductRepository;
use MyApp\repositories\CategoryRepository;
use MyApp\repositories\OrderRepository;
use MyApp\services\ProductService;
use MyApp\services\CategoryService;
use MyApp\services\OrderService;

class QueryResolver {

    private static $database;
    private static $db;
    private static $categoryRepository;
    private static $productRepository;
    private static $orderRepository;
    private static $categoryService;
    private static $productService;
    private static $orderService;

    public static function create() {

        self::$database = new Database();
        self::$db = self::$database->connect();

        self::$productRepository = new ProductRepository(self::$db);
        self::$categoryRepository = new CategoryRepository(self::$db);
        self::$orderRepository = new OrderRepository(self::$db);

        self::$productService = new ProductService(self::$productRepository);
        self::$categoryService = new CategoryService(self::$categoryRepository);
        self::$orderService = new OrderService(self::$productRepository, self::$orderRepository);

        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(new CategoryType()),
                    'resolve' => [self::class, 'getCategories'],
                ],
                'products' => [
                    'type' => Type::listOf(new ProductType()),
                    'args' => [
                        'category' => Type::string(),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [self::class, 'getProducts'],
                ],
                'product' => [
                    'type' => new ProductType(),
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [self::class, 'getProductById'],
                ],
                'order' => [
                    'type' => Type::string(),
                    'resolve' => [self::class, 'getOrder'],
                ],
            ]
        ]);
    }

    public static function getCategories() {
        
        return self::$categoryService->getCategories();
    }

    public static function getProducts($rootValue, $args) {
        $category = $args['category'] ?? null;
        $galleryLimit = $args['galleryLimit'] ?? null;
        
        if ($category) {
            return self::$productService->getProductsByCategory($category, $galleryLimit);
        }
        
        $products = self::$productService->getAllProducts($galleryLimit);

        return $products;
    }

    public static function getProductById($rootValue, $args, $context, $info) {
        $id = $args['id'] ?? null;
        $galleryLimit = $args['galleryLimit'] ?? null;

        return self::$productService->getProductById($id, $galleryLimit);
    }

    public static function getOrder($rootValue, $args, $context, $info) {

        $jsonString = '
        {
            "totalQuantity": 4,
            "totalAmount": 952.54,
            "currencyLabel": "USD",
            "orderId": "X3m0agVis",
            "products": [
                {
                    "orderDetailId": "huarache-x-stussy-le_41_ZhpC5ndt0z",
                    "productId": "huarache-x-stussy-le",
                    "quantity": 2,
                    "attributes": [
                        {
                            "attributeId": "Size",
                            "itemId": "41"
                        }
                    ]
                },
                {
                    "orderDetailId": "jacket-canada-goosee_Large_lpZ08qRsWg",
                    "productId": "jacket-canada-goosee",
                    "quantity": 1,
                    "attributes": [
                        {
                            "attributeId": "Size",
                            "itemId": "Large"
                        }
                    ]
                },
                {
                    "orderDetailId": "huarache-x-stussy-le_43_UjExIXgiif",
                    "productId": "huarache-x-stussy-le",
                    "quantity": 1,
                    "attributes": [
                        {
                            "attributeId": "Size",
                            "itemId": "43"
                        }
                    ]
                }
            ]
        }';
        
        $orderData = json_decode($jsonString, true);
        
        self::$orderService->addOrder($orderData);
        return "Hey";
    }
}
