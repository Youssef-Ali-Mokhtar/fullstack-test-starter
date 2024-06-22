<?php

namespace MyApp\models\attributeModel;

use InvalidArgumentException;
use MyApp\models\attributeModel\Attribute;

class TouchIDinkeyboard extends Attribute {

    const TYPE = 'Touch ID in keyboard';

    /**
     * TouchIDinkeyboard constructor.
     *
     * @param array $data Data containing attributes for Touch ID in keyboard.
     * @throws \Exception If validation fails in the parent constructor.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the items for the Touch ID in keyboard attribute.
     *
     * @param array $items Items array for Touch ID in keyboard attributes.
     * @throws \InvalidArgumentException If the name is not 'Touch ID in keyboard'.
     */
    public function setItems(array $items) {
        if ($this->name === self::TYPE) {
            $this->items = $items;
        } else {
            throw new InvalidArgumentException("Cannot set items for attribute '{$this->name}'. Expected type 'Touch ID in keyboard'.");
        }
    }

}

