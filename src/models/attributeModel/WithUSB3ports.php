<?php

namespace MyApp\models\attributeModel;

use MyApp\models\attributeModel\Attribute;

class WithUSB3ports extends Attribute {

    const TYPE = 'With USB 3 ports';

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

