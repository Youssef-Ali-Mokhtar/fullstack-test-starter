<?php

namespace MyApp\models\productModel;

use MyApp\models\productModel\Clothes;
use MyApp\factories\AttributeFactory;

class Clothes extends Product {
    public function __construct($data) {
        parent::__construct($data);
    }

    public function setAttributesSet(array $attributesData) {

        $attributeNames = ['Size'];

        foreach ($attributesData as $attributeData) {

            if (in_array($attributeData['name'], $attributeNames)) {

                $attribute = AttributeFactory::createAttribute($attributeData);
                
                $attribute->setItems($attributeData['items']);
                
                $this->attributes[] = $attribute->getDetails();
            }

        }

    }
}
