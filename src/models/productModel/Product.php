<?php

namespace MyApp\models\productModel;

abstract class Product {
    protected $id; 
    protected $name; 
    protected $inStock;
    protected $brand;
    protected $category;
    protected $attributes;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->inStock = $data['inStock'];
        $this->brand = $data['brand'];
        $this->category = $data['category'];
        $this->attributes = [];
    }

    abstract protected function setAttributesSet(array $attributesData);

    public function getDetails(): array {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'inStock' => $this->inStock,
            'brand' => $this->brand,
            'category' => $this->category,
            'attributes' => $this->attributes
        ];
    }
}
?>
