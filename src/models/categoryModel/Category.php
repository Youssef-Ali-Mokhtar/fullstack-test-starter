<?php

    namespace MyApp\models\categoryModel;

    class Category {
        private $name;

        public function __construct($data) {
            $this->name = $data['name'];
        }

        public function getDetails() {
            return ['name'=>$this->name];
        }
    }
?>