<?php

namespace MyApp\repositories;

use PDO;
use PDOException;

class ProductRepository {
    private $conn;

    /**
     * Constructor to initialize the repository with a database connection.
     *
     * @param PDO $db PDO database connection instance.
     */
    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    
    /**
     * Fetch all products joined with attributes, items, and prices.
     * Does not include gallery data to avoid unnecessary duplication.
     *
     * @return array Array of product records fetched from the database.
     */
    public function fetchAll() {
        try {
            $query = "SELECT 
                p.id AS productId, 
                p.name AS productName,
                p.inStock, 
                p.description, 
                p.category, 
                p.brand, 
                a.id AS attributeId, 
                a.name AS attributeName,
                a.type,
                i.id AS itemId, 
                i.value, 
                i.displayValue,
                price.id AS priceId,
                price.amount, 
                c.label AS currencyLabel, 
                c.symbol AS currencySymbol
            FROM 
                product AS p
            LEFT JOIN 
                productAttributeItem AS pai ON p.id = pai.productId
            LEFT JOIN 
                attribute AS a ON pai.attributeId = a.id
            LEFT JOIN 
                item AS i ON pai.itemId = i.id
            LEFT JOIN 
                price ON p.id = price.product_id
            LEFT JOIN 
                currency AS c ON c.label = price.currency_id
            ORDER BY 
                p.category, p.id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error and handle exception
            error_log($e->getMessage());
            return [];
        }
    }
    

    /**
     * Fetch product by its ID joined with attributes, items, and prices.
     *
     * @param string $id Product ID to fetch.
     * @return array Array containing product details fetched from the database.
     */
    public function fetchById($id) {
        try {
            $query = "SELECT 
                p.id AS productId, 
                p.name AS productName,
                p.inStock, 
                p.description, 
                p.category, 
                p.brand, 
                a.id AS attributeId, 
                a.name AS attributeName,
                a.type, 
                i.id AS itemId, 
                i.value, 
                i.displayValue,
                price.id AS priceId,
                price.amount, 
                c.label AS currencyLabel, 
                c.symbol AS currencySymbol
            FROM 
                product AS p
            LEFT JOIN 
                productAttributeItem AS pai ON p.id = pai.productId
            LEFT JOIN 
                attribute AS a ON pai.attributeId = a.id
            LEFT JOIN 
                item AS i ON pai.itemId = i.id
            LEFT JOIN 
                price ON p.id = price.product_id
            LEFT JOIN 
                currency AS c ON c.label = price.currency_id
            WHERE 
                p.id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error and handle exception
            error_log($e->getMessage());
            return [];
        }
    }


    /**
     * Fetch products by their category joined with attributes, items, and prices.
     *
     * @param string $category Product category to filter by.
     * @return array Array of product records filtered by category.
     */
    public function fetchByCategory($category) {
        try {
            $query = "SELECT 
                p.id AS productId, 
                p.name AS productName,
                p.inStock, 
                p.description, 
                p.category, 
                p.brand, 
                a.id AS attributeId, 
                a.name AS attributeName,
                a.type, 
                i.id AS itemId,
                i.value, 
                i.displayValue,
                price.id AS priceId,
                price.amount, 
                c.label AS currencyLabel, 
                c.symbol AS currencySymbol
            FROM 
                product AS p
            LEFT JOIN 
                productAttributeItem AS pai ON p.id = pai.productId
            LEFT JOIN 
                attribute AS a ON pai.attributeId = a.id
            LEFT JOIN 
                item AS i ON pai.itemId = i.id
            LEFT JOIN 
                price ON p.id = price.product_id
            LEFT JOIN 
                currency AS c ON c.label = price.currency_id
            WHERE 
                p.category = :category
            ORDER BY 
                p.category, p.id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error and handle exception
            error_log($e->getMessage());
            return [];
        }
    }


    /**
     * Fetches gallery data for products.
     * If product IDs are provided, fetches gallery only for those products.
     * If limit is provided, limits the number of gallery items fetched per product.
     *
     * @param array $productIds Optional array of product IDs to filter by.
     * @param int|null $limit Optional limit on the number of gallery items per product.
     * @return array Array of gallery data fetched from the database.
     */
    public function fetchGallery($productIds = [], $limit = NULL) {
        try {
            // Base query with ROW_NUMBER() for limiting rows per productId
            $query = "SELECT productId, url
                FROM (
                    SELECT productId, url, ROW_NUMBER() OVER (PARTITION BY productId ORDER BY id) AS row_num
                    FROM gallery
                ) AS numbered_rows";

            // Add a WHERE clause if product IDs are provided
            if (!empty($productIds)) {
                // Create placeholders for the product IDs
                $placeholders = implode(',', array_fill(0, count($productIds), '?'));
                $query .= " WHERE productId IN ($placeholders)";
            }

            // Add the row_num limit if provided
            if ($limit !== NULL) {
                $query .= !empty($productIds) ? " AND" : " WHERE";
                $query .= " row_num <= ?";
            }

            // Prepare the statement
            $stmt = $this->conn->prepare($query);

            // Bind values to placeholders
            $paramIndex = 1;
            if (!empty($productIds)) {
                foreach ($productIds as $id) {
                    $stmt->bindValue($paramIndex++, $id, PDO::PARAM_STR); // Assuming productId is VARCHAR
                }
            }

            // Bind the limit value if provided
            if ($limit !== NULL) {
                $stmt->bindValue($paramIndex, $limit, PDO::PARAM_INT);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error and handle exception
            error_log($e->getMessage());
            return [];
        }
    }


    /**
     * Checks if the provided product IDs exist in the database.
     *
     * @param array $productIds Array of product IDs to check.
     * @return array Array of existing product IDs found in the database.
     */
    public function checkProducts($productIds) {
        try {
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
            $query = "SELECT id FROM product WHERE id IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($productIds);
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            return $result;
        } catch (PDOException $e) {
            // Log error and handle exception
            error_log($e->getMessage());
            return [];
        }
    }

}