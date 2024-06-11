<?php

namespace MyApp\models\attributeModel;

use MyApp\models\attributeModel\Attribute;

class TouchIDinkeyboard extends Attribute {

    const TYPE = 'Touch ID in keyboard';

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setItems(array $items) {

        if($this->name === self::TYPE) {
            $this->items = $items;
        }

    }

}
