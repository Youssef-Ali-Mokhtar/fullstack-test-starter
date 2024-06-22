<?php

namespace MyApp\repositories;

use PDO;
use PDOException;

class OrderRepository {
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
     * Adds an order and its details to the database using transactional processing.
     *
     * @param array $data Array containing order data including products and their attributes.
     * @return string Success message or error message if operation fails.
     */
    public function addOrder($data) {
        try {
            // Begin the transaction
            $this->conn->beginTransaction();

            // Insert into orders table
            $orderSQL = "INSERT INTO orders (id, totalQuantity, totalAmount, currencyLabel) 
                         VALUES (:id, :totalQuantity, :totalAmount, :currencyLabel)";
            $stmt = $this->conn->prepare($orderSQL);
            $stmt->execute([
                ':id' => $data['id'],
                ':totalQuantity' => $data['totalQuantity'],
                ':totalAmount' => $data['totalAmount'],
                ':currencyLabel' => $data['currencyLabel']
            ]);

            // Prepare orderDetail and orderDetailAttribute SQL
            $orderDetailSQL = "INSERT INTO orderDetail (id, quantity, orderId, productId) VALUES ";
            $orderDetailValues = [];
            $orderDetailAttributesSQL = "INSERT INTO orderDetailAttribute (attributeId, itemId, orderDetailId) VALUES ";
            $orderDetailAttributesValues = [];

            // Loop through each product and append values to the query
            foreach ($data['products'] as $product) {
                $orderDetailValues[] = "('{$product['id']}', {$product['quantity']}, '{$data['id']}', '{$product['productId']}')";
                
                // Loop through each attribute and append values to the query
                foreach ($product['attributes'] as $attribute) {
                    $orderDetailAttributesValues[] = "('{$attribute['attributeId']}', '{$attribute['itemId']}', '{$product['id']}')";
                }
            }

            // Append the concatenated values to the base SQL and execute
            if (!empty($orderDetailValues)) {
                $orderDetailSQL .= implode(", ", $orderDetailValues);
                $this->conn->exec($orderDetailSQL);
            }

            if (!empty($orderDetailAttributesValues)) {
                $orderDetailAttributesSQL .= implode(", ", $orderDetailAttributesValues);
                $this->conn->exec($orderDetailAttributesSQL);
            }

            // Commit the transaction
            $this->conn->commit();

            return "Data inserted successfully.";

        } catch (PDOException $e) {
            // Rollback the transaction in case of errors
            $this->conn->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
}

