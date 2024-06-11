<?php

namespace MyApp\models\attributeModel;

use MyApp\models\attributeModel\Attribute;

class Capacity extends Attribute {

    const TYPE = 'Capacity';

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setItems(array $items) {

        if($this->name === self::TYPE) {
            $this->items = $items;
        }

    }

}

