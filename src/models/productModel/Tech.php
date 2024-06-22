<?php

namespace MyApp\models\productModel;

use MyApp\factories\AttributeFactory;

class Tech extends Product {

    /**
     * Tech constructor.
     *
     * @param array $data Array containing product data.
     * @throws \Exception if validation fails in the parent constructor.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the attributes set for Tech.
     *
     * @param array $attributesData Array containing attribute data.
     * @throws \Exception if the attribute creation fails or the attribute name is invalid.
     */
    public function setAttributesSet(array $attributesData) {
        $attributeNames = ['Color', 'Capacity', 'With USB 3 ports', 'Touch ID in keyboard'];

        foreach ($attributesData as $attributeData) {
            if (in_array($attributeData['name'], $attributeNames)) {
                $attribute = AttributeFactory::createAttribute($attributeData);
                
                $attribute->setItems($attributeData['items']);
                
                $this->attributes[] = $attribute->getDetails();
            } else {
                throw new \Exception('Invalid attribute name: ' . $attributeData['name']);
            }
        }
    }
}
