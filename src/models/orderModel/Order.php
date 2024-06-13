<?php

namespace MyApp\models\orderModel;
use MyApp\models\ModelInterface;

class Order implements ModelInterface {
    private $id;
    private $totalQuantity;
    private $totalAmount;
    private $currencyLabel;
    private $products;

    public function __construct($data) {
        $this->id = $data['orderId'];
        $this->totalQuantity = $data['totalQuantity'];
        $this->totalAmount = $data['totalAmount'];
        $this->currencyLabel = $data['currencyLabel'];
        $this->products = $data['products'];
    }


    public function validate() {
        $this->validateId($this->id);
        $this->validateTotalQuantity($this->totalQuantity);
        $this->validateTotalAmount($this->totalAmount);
        $this->validateCurrencyLabel($this->currencyLabel);
        $this->validateProducts($this->products);
    }
    

    private function validateId($id) {
        if (empty($id) || !is_string($id)) {
            throw new InvalidArgumentException("Invalid or missing order ID.");
        }
    }

    private function validateTotalQuantity($totalQuantity) {
        if (!is_int($totalQuantity) || $totalQuantity <= 0) {
            throw new InvalidArgumentException("Total quantity must be a positive integer.");
        }
    }

    private function validateTotalAmount($totalAmount) {
        if (!is_float($totalAmount) || $totalAmount <= 0) {
            throw new InvalidArgumentException("Total amount must be a positive float.");
        }
    }

    private function validateCurrencyLabel($currencyLabel) {
        $validCurrencyCodes = ['USD']; // Add all valid currency codes here
        if (empty($currencyLabel) || !in_array($currencyLabel, $validCurrencyCodes)) {
            throw new InvalidArgumentException("Invalid or missing currency label.");
        }
    }

    private function validateProducts($products) {
        if (!is_array($products) || empty($products)) {
            throw new InvalidArgumentException("Products must be a non-empty array.");
        }
        foreach ($products as $product) {
            $this->validateId($product['productId']);
            $this->validateId($product['orderDetailId']);
            $this->validateTotalQuantity($product['quantity']);

            if (!is_array($product['attributes'])) {
                throw new InvalidArgumentException("Attributes must be an array");
            }
        }
    }

    public function getProductIds() {
        $productIds = [];
        foreach ($this->products as $product) {
            $productIds[$product['productId']] = $product['productId'];
        }

        return array_values($productIds);
    }

    public function getDetails() {
        return [
            'id' => $this->id,
            'totalQuantity' => $this->totalQuantity,
            'totalAmount' => $this->totalAmount,
            'currencyLabel' => $this->currencyLabel,
            'products' => $this->products
        ];
    }


}