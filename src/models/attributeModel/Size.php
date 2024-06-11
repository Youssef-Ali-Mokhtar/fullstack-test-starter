<?php

namespace MyApp\models\attributeModel;

use MyApp\models\attributeModel\Attribute;

class Size extends Attribute {

    const TYPE = 'Size';

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setItems(array $items) {

        if($this->name === self::TYPE) {
            $this->items = $items;
        }

    }

}
