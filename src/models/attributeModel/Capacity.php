<?php

namespace MyApp\models\attributeModel;

use InvalidArgumentException;
use MyApp\models\attributeModel\Attribute;

class Capacity extends Attribute {

    const TYPE = 'Capacity';

    /**
     * Capacity constructor.
     *
     * @param array $data Data containing attributes for Capacity.
     * @throws \Exception If validation fails in the parent constructor.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the items for the Capacity attribute.
     *
     * @param array $items Items array for Capacity attributes.
     * @throws \InvalidArgumentException If the name is not 'Capacity'.
     */
    public function setItems(array $items) {
        if ($this->name === self::TYPE) {
            $this->items = $items;
        } else {
            throw new InvalidArgumentException("Cannot set items for attribute '{$this->name}'. Expected type 'Capacity'.");
        }
    }

}

