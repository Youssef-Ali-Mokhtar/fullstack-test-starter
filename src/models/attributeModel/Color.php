<?php

namespace MyApp\models\attributeModel;

use InvalidArgumentException;
use MyApp\models\attributeModel\Attribute;

class Color extends Attribute {

    const TYPE = 'Color';

    /**
     * Color constructor.
     *
     * @param array $data Data containing attributes for Color.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the items for Color attributes.
     *
     * @param array $items Items array for Color attributes.
     * @throws \InvalidArgumentException If the name is not 'Color'.
     */
    public function setItems(array $items) {
        if ($this->name === self::TYPE) {
            $this->items = $items;
        } else {
            throw new InvalidArgumentException("Cannot set items for attribute '{$this->name}'. Expected type 'Color'.");
        }
    }

}



