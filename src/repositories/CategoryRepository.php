<?php

    namespace MyApp\repositories;

    use PDO;

    class CategoryRepository {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function fetchCategories() {
            $query = "SELECT * FROM category";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
