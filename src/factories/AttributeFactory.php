<?php

namespace MyApp\factories;

use MyApp\models\attributeModel\Attribute;


class AttributeFactory {
    public static function createAttribute(array $data): Attribute {
        $attributeType = str_replace(' ', '', $data['name']);
        $pathToClass = "MyApp\\models\\attributeModel\\" . ucfirst($attributeType);

        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        $attribute = new $pathToClass($data);

        if (!($attribute instanceof Attribute)) {
            throw new Exception("Invalid attribute type");
        }

        return $attribute;
    }
}
?>
