<?php

abstract class DBObject {
    private $target_object;
    public function __construct($obj) {
        $this->target_object = $obj;
    }

    public abstract function insert();
    public abstract function update();
    public function regist() {
        if ($this->target_object->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }
}

class ObjectA extends DBObject {
    public function insert() {
        // insert 処理
        echo "--insert--" , PHP_EOL;
    }

    public function update() {
        // update 処理
        echo "--update--" , PHP_EOL;
    }
}

$sample = new stdClass();
$sample->id = 111;
//$sample->id = null;

$obj = new ObjectA($sample);
$obj->regist();


