<?php

namespace MyApp\repositories;

use PDO;

class ProductRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    //One query, only Product table, no join with attribute
    public function fetchAll() {
        $query = "
        SELECT p.id AS productId, p.name AS productName, p.inStock, p.category, 
                p.brand, a.id AS attributeId, a.name AS attributeName, a.type, i.id AS itemId, 
                i.value, i.displayValue
        FROM product AS p
        LEFT JOIN product_attribute_item AS pai 
        ON p.id = pai.productId 
        LEFT JOIN attribute AS a 
        ON pai.attributeId = a.id 
        LEFT JOIN item AS i
        ON pai.itemId = i.id
        ORDER BY p.category, p.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //One query, get product by id, join with attribute table
    public function fetchById($id) {
        $query = "
        SELECT p.id AS productId, p.name AS productName, p.inStock, p.category, 
                p.brand, a.id AS attributeId, a.name AS attributeName, a.type, i.id AS itemId, 
                i.value, i.displayValue
        FROM product AS p
        LEFT JOIN product_attribute_item AS pai 
        ON p.id = pai.productId 
        LEFT JOIN attribute AS a 
        ON pai.attributeId = a.id 
        LEFT JOIN item AS i 
        ON pai.itemId = i.id
        WHERE p.id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchByCategory($category) {
        $query = "
        SELECT p.id AS productId, p.name AS productName, p.inStock, p.category, 
                p.brand, a.id AS attributeId, a.name AS attributeName, a.type, i.id AS itemId, 
                i.value, i.displayValue
        FROM product AS p
        LEFT JOIN product_attribute_item AS pai 
        ON p.id = pai.productId 
        LEFT JOIN attribute AS a 
        ON pai.attributeId = a.id 
        LEFT JOIN item AS i
        ON pai.itemId = i.id
        WHERE category = :category
        ORDER BY p.category, p.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
