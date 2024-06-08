<?php

    namespace MyApp\models\categoryModel;
    use MyApp\models\ModelInterface;

    class Category implements ModelInterface {
        private $name;

        public function __construct($data) {
            $this->name = $data['name'];
        }

        public function getDetails() {
            return ['name'=>$this->name];
        }
    }
?>