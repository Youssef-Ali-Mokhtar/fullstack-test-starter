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
        $query = "SELECT * FROM product";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //One query, get product by id, join with attribute table
    public function fetchById($id) {
        $query = "
        SELECT p.id AS productId, p.name AS productName, p.inStock, p.category, p.brand, a.id AS attributeId, a.name AS attributeName, a.type, i.id AS itemId, i.value, i.displayValue
        FROM product_attribute_item AS pai
        RIGHT JOIN product AS p
        ON p.id = pai.productId
        JOIN attribute AS a
        ON a.id = pai.attributeId
        JOIN item AS i
        ON i.id = pai.itemId
        WHERE p.id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchByCategory($category) {
        $query = "SELECT * FROM product WHERE category = :category";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
