<?php

namespace MyApp\models\attributeModel;

use InvalidArgumentException;
use MyApp\models\attributeModel\Attribute;

class WithUSB3ports extends Attribute {

    const TYPE = 'With USB 3 ports';

    /**
     * WithUSB3ports constructor.
     *
     * @param array $data Data containing attributes for 'With USB 3 ports'.
     * @throws \Exception If validation fails in the parent constructor.
     */
    public function __construct($data) {
        parent::__construct($data);
    }

    /**
     * Set the items for the 'With USB 3 ports' attribute.
     *
     * @param array $items Items array for 'With USB 3 ports' attributes.
     * @throws \InvalidArgumentException If the name is not 'With USB 3 ports'.
     */
    public function setItems(array $items) {
        if ($this->name === self::TYPE) {
            $this->items = $items;
        } else {
            throw new InvalidArgumentException("Cannot set items for attribute '{$this->name}'. Expected type 'With USB 3 ports'.");
        }
    }

}

