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
use MyApp\GraphQL\Schema\Schema as MySchema;

class GraphQL {


    // See docs on schema options:
    // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options

    static public function handle() {

        try {
            
            $schema = MySchema::create();
        
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