<?php 


namespace PTT\Lang\Typescript\Section;

use PTT\Interfaces\Section;


class Basic implements Section {
    protected $childs = array();
    protected $name = null;
    protected $extends;
    protected $imports = array();

    public function __construct(string $name, string $parent = null, array $imports) {
        $this->name = $name;
        $this->extends = ($parent == null) ? '' : sprintf("extends %s", $parent);
        $this->imports = $imports;
    }
    public function build(): string {
        $string = " %s\nexport interface %s %s {\n\t%s\n} ";
        $body = "";
        foreach($this->childs as $child) {
            $body .= sprintf("%s;\n\t", $child->build());
        }
        $imports = "";
        foreach($this->imports as $import ) {
            $imports .= sprintf("import { %s } from './%s';\n", $import, $import);
        }   
        return sprintf($string, $imports, $this->name, $this->extends, $body);
    }
    public function append(Section $section) {
        array_push($this->childs, $section);
    }
}