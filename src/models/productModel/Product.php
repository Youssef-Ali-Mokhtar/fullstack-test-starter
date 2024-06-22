<?php

namespace MyApp\models\productModel;

use MyApp\models\ModelInterface;

abstract class Product implements ModelInterface {
    protected $id; 
    protected $name; 
    protected $inStock;
    protected $brand;
    protected $category;
    protected $gallery;
    protected $description;
    protected $attributes;
    protected $prices;

    /**
     * Constructor for the Product class with validation.
     *
     * @param array $data Array containing product data.
     * @throws \InvalidArgumentException if validation fails.
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->inStock = $data['inStock'];
        $this->brand = $data['brand'];
        $this->category = $data['category'];
        $this->gallery = $data['gallery'];
        $this->description = $data['description'];
        $this->prices = $data['prices'];
        $this->attributes = [];

        $this->validateData(); // Validate data after properties are set
    }

    /**
     * Validates the product data.
     *
     * @throws \InvalidArgumentException if validation fails.
     */
    public function validateData() {
        if (!isset($this->id) || !is_string($this->id)) {
            throw new \InvalidArgumentException('Invalid or missing id.');
        }
        if (!isset($this->name) || !is_string($this->name)) {
            throw new \InvalidArgumentException('Invalid or missing name.');
        }
        if (!isset($this->inStock) || !is_bool($this->inStock)) {
            throw new \InvalidArgumentException('Invalid or missing inStock.');
        }
        if (!isset($this->brand) || !is_string($this->brand)) {
            throw new \InvalidArgumentException('Invalid or missing brand.');
        }
        if (!isset($this->category) || !is_string($this->category)) {
            throw new \InvalidArgumentException('Invalid or missing category.');
        }
        if (!isset($this->gallery) || !is_array($this->gallery)) {
            throw new \InvalidArgumentException('Invalid or missing gallery.');
        }
        if (!isset($this->description) || !is_string($this->description)) {
            throw new \InvalidArgumentException('Invalid or missing description.');
        }
        if (!isset($this->prices) || !is_array($this->prices)) {
            throw new \InvalidArgumentException('Invalid or missing prices.');
        }
    }

    /**
     * Abstract method to set attributes set.
     *
     * @param array $attributesData Array containing attribute data.
     */
    abstract protected function setAttributesSet(array $attributesData);

    /**
     * Get the details of the product.
     *
     * @return array Array containing product details.
     */
    public function getDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'inStock' => $this->inStock,
            'brand' => $this->brand,
            'category' => $this->category,
            'gallery' => $this->gallery,
            'description' => $this->description,
            'attributes' => $this->attributes,
            'prices' => $this->prices
        ];
    }
}
