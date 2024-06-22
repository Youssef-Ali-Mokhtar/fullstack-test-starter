<?php

namespace MyApp\models\attributeModel;

use InvalidArgumentException;
use MyApp\models\attributeModel\Attribute;

class Size extends Attribute {

    const TYPE = 'Size';

    /**
     * Size constructor.
     *
     * @param array $data Data containing attributes for Size.
     * @throws \Exception If validation fails in the parent constructor.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the items for the Size attribute.
     *
     * @param array $items Items array for Size attributes.
     * @throws \InvalidArgumentException If the name is not 'Size'.
     */
    public function setItems(array $items) {
        if ($this->name === self::TYPE) {
            $this->items = $items;
        } else {
            throw new InvalidArgumentException("Cannot set items for attribute '{$this->name}'. Expected type 'Size'.");
        }
    }

}

