<?php

namespace MyApp\models\attributeModel;
use MyApp\models\ModelInterface;

abstract class Attribute implements ModelInterface {
    protected $id;
    protected $name;
    protected $type;
    protected $items;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->items = [];
    }

    abstract public function setItems(array $items);

    public function getDetails() {
        
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'type'=>$this->type,
            'items'=>$this->items
        ];
    }
}
?>

