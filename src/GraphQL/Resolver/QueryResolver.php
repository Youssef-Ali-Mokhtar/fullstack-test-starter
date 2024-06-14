<?php

namespace MyApp\GraphQL\Resolver;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use MyApp\GraphQL\Type\QueryType\ProductType;
use MyApp\GraphQL\Type\QueryType\CategoryType;

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

        $productType = new ProductType();

        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'resolve' => function() {
                        return "Hello!!";
                    }
                ],
                'categories' => [
                    'type' => Type::listOf(new CategoryType()),
                    'resolve' => [self::class, 'getCategories'],
                ],
                'products' => [
                    'type' => Type::listOf($productType),
                    'args' => [
                        'category' => Type::string(),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [self::class, 'getProducts'],
                ],
                'product' => [
                    'type' => $productType,
                    'args' => [
                        'id' => Type::nonNull(Type::id()),
                        'galleryLimit' => Type::int(),
                    ],
                    'resolve' => [self::class, 'getProductById'],
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
}
