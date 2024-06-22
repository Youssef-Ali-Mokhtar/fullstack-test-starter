<?php

namespace MyApp\repositories;

use PDO;

class CategoryRepository {
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
     * Fetches all categories from the database.
     *
     * @return array Array of category records fetched from the database.
     */
    public function fetchCategories() {
        $query = "SELECT * FROM category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

