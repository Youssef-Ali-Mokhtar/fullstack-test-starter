<?php


namespace MyApp\Controller;

use MyApp\database\Database;
use MyApp\repositories\ProductRepository;
use MyApp\repositories\CategoryRepository;
use MyApp\services\ProductService;
use MyApp\services\CategoryService;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;


class GraphQL {

    private static $database;
    private static $db;
    private static $categoryRepository;
    private static $productRepository;
    private static $categoryService;
    private static $productService;

    static public function handle() {

        self::$database = new Database();
        self::$db = self::$database->connect();

        self::$productRepository = new ProductRepository(self::$db);
        self::$productService = new ProductService(self::$productRepository);

        self::$categoryRepository = new CategoryRepository(self::$db);
        self::$categoryService = new CategoryService(self::$categoryRepository);

        try {
            $currencyType = new ObjectType([
                'name' => 'Currency',
                'fields' => [
                    'label' => Type::string(),
                    'symbol' => Type::string(),
                ]
            ]);
            
            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => Type::float(),
                    'currency' => $currencyType,
                ]
            ]);
            
            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => Type::id(),
                    'displayValue' => Type::string(),
                    'value' => Type::string(),
                ]
            ]);
            
            $attributeSetType = new ObjectType([
                'name' => 'AttributeSet',
                'fields' => [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'type' => Type::string(),
                    'items' => Type::listOf($attributeType),
                ]
            ]);
            
            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'inStock' => Type::boolean(),
                    'gallery' => Type::listOf(Type::string()),
                    'description' => Type::string(),
                    'category' => Type::string(),
                    'attributes' => Type::listOf($attributeSetType),
                    'prices' => Type::listOf($priceType),
                    'brand' => Type::string(),
                ]
            ]);
            
            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'name' => Type::string(),
                ]
            ]);
            
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'echo' => [
                        'type' => Type::string(),
                        'args' => [
                            'message' => Type::string(),
                        ],
                        'resolve' => static fn ($rootValue, array $args): string => $rootValue['prefix'] . $args['message'],
                    ],
                    'categories' => [
                        'type' => Type::listOf($categoryType),
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
        
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn ($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                ],
            ]);
        
            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
            );
        
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
        
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
        
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
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
    
        return self::$productService->getAllProducts($galleryLimit);
    }

    public static function getProductById($rootValue, $args, $context, $info) {
        $id = $args['id'] ?? null;
        $galleryLimit = $args['galleryLimit'] ?? null;

        return self::$productService->getProductById($id, $galleryLimit);
    }


}