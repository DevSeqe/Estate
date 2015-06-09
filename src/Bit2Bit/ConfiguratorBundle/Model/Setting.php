<?php

namespace Bit2Bit\ConfiguratorBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Setting extends AbstractEntity {

    protected $id;
    protected $name;
    protected $key;
    protected $value;
    protected $description;

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setKey($key) {
        $this->key = $key;
        return $this;
    }

    public function getKey() {
        return $this->key;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

}
