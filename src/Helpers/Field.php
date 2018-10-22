<?php

namespace PTT\Helpers;


class Field {
    public $name;
    public $type;

    public function __construct($name = false, $type= false, $optional=false) {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;
    }
    public function __toString() {
        return sprintf("%s%s: %s", $this->name, ($this->optional == true) ? '?' : '', $this->type);
    }
}