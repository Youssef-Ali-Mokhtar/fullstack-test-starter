<?php

namespace MyApp\models\categoryModel;

use MyApp\models\ModelInterface;

class Category implements ModelInterface {
    private $name;

    /**
     * Category constructor.
     *
     * @param array $data Array containing category data.
     * @throws \Exception If validation fails.
     */
    public function __construct($data) {
        $this->name = $data['name'];

        $this->validateData();
    }

    /**
     * Validate category data.
     *
     * @param array $data Array containing category data.
     * @throws \Exception If validation fails.
     */
    public function validateData() {
        if (!isset($this->name) || !is_string($this->name) || empty(trim($this->name))) {
            throw new \Exception('Category name must be a non-empty string.');
        }
    }

    /**
     * Get the details of the category.
     *
     * @return array Details of the category.
     */
    public function getDetails() {
        return ['name' => $this->name];
    }
}

