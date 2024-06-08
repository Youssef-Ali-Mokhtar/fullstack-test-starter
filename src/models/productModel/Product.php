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
    protected $attributes;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->inStock = $data['inStock'];
        $this->brand = $data['brand'];
        $this->category = $data['category'];
        $this->gallery = $data['gallery'];
        $this->attributes = [];
    }

    abstract protected function setAttributesSet(array $attributesData);

    public function getDetails() {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'inStock' => $this->inStock,
            'brand' => $this->brand,
            'category' => $this->category,
            'gallery' => $this->gallery,
            'attributes' => $this->attributes
        ];
    }
}
?>
