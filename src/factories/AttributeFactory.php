<?php

namespace MyApp\factories;

use MyApp\models\attributeModel\Attribute;

class AttributeFactory {
    /**
     * Create an attribute object based on attribute type.
     *
     * @param array $data Associative array containing attribute data.
     * @return Attribute The created attribute object.
     * @throws Exception If the attribute class does not exist or is not valid.
     */
    public static function createAttribute(array $data): Attribute {
        // Remove spaces from attribute name to construct class name
        $attributeType = str_replace(' ', '', $data['name']);
        
        // Construct the full namespace path to the attribute class
        $pathToClass = "MyApp\\models\\attributeModel\\" . ucfirst($attributeType);

        // Check if the class exists
        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        // Create an instance of the attribute class
        $attribute = new $pathToClass($data);

        // Ensure the created object is an instance of Attribute
        if (!($attribute instanceof Attribute)) {
            throw new Exception("Invalid attribute type");
        }

        // Return the created attribute object
        return $attribute;
    }
}

