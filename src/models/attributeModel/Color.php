<?php

namespace MyApp\models\attributeModel;

use MyApp\models\attributeModel\Attribute;

class Color extends Attribute {

    const TYPE = 'Color';

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setItems(array $items) {

        if($this->name === self::TYPE) {
            $this->items = $items;
        }

    }

}

?>
