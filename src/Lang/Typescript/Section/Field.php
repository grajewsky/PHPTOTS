<?php 

namespace PTT\Lang\Typescript\Section;

use PTT\Interfaces\Section;
use  PTT\Helpers\Field as BasicField;

class Field implements Section {
    protected $field;

    public function __construct(BasicField $field) {
        $this->field = $field;
    }
    public function build(): string{
       return sprintf("%s", $this->field);
        
    }
    public function append(Section $section) {
        // no child service
    }
}