<?php

namespace MyApp\models\attributeModel;
use MyApp\models\ModelInterface;

abstract class Attribute implements ModelInterface {
    protected $id;
    protected $name;
    protected $type;
    protected $items;

    /**
     * Attribute constructor.
     *
     * @param array $data Array containing attribute data.
     * @throws \Exception if validation fails.
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->items = [];
        
        $this->validateData();
    }

    /**
     * Validate the input data.
     *
     * @param array $data Array containing attribute data.
     * @throws \Exception if required fields are missing or invalid.
     */
    public function validateData() {
        if (empty($this->id)) {
            throw new \Exception('ID is required');
        }
        if (empty($this->name)) {
            throw new \Exception('Name is required');
        }
        if (empty($this->type)) {
            throw new \Exception('Type is required');
        }
    }

    /**
     * Abstract method to set items for the attribute.
     *
     * @param array $items Array containing items data.
     */
    abstract public function setItems(array $items);

    /**
     * Get the details of the attribute.
     *
     * @return array Array containing attribute details.
     */
    public function getDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'items' => $this->items
        ];
    }
}
