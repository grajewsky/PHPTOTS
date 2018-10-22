<?php 


namespace PTT\Lang\Typescript;
use \zpt\anno\Annotations;

use PTT\Interfaces\Convert;
use PTT\Interfaces\LangBuilder;
use PTT\Helpers\Field;
use PTT\Lang\Typescript\Section\Basic;
use PTT\Lang\Typescript\Section\Field as ClassField;
use \ReflectionClass;
use \ReflectionMethod;
use \ReflectionProperty;

class TypescriptInterface extends LangBuilder implements Convert {

    protected $fields = array();
    protected $name;
    protected $extends;
    protected $imports = array();
    protected $disableImportTypes = array('boolean', 'number', 'string');

    private function getType(\ReflectionProperty $propertyRef): ?string {
        $annotations = new Annotations($propertyRef);
            if($annotations["type"] != null) {
                if(!in_array(strtolower($annotations['type']), $this->disableImportTypes)) {
                    array_push($this->imports, $annotations['type']);
                }
                return $annotations["type"];
            }
    }
    private function isOptional(\ReflectionProperty $propertyRef): bool {
        $annotations = new Annotations($propertyRef);
        if(@$annotations["optional"] != null) {
            return \boolval($annotations['optional']);
        }
        return false;

    }
    public function convert(string $clazz) : string {
        $class = null;
        if(class_exists($clazz, true)){
            $class = new $clazz;
        }
        $refClass = new ReflectionClass($class);
        $this->name = $refClass->getShortName();
        $parentClass = $refClass->getParentClass();
        $this->extends = $parentClass->getShortName();

        if($refClass != null) {
            foreach($refClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                array_push($this->fields, new Field($property->getName(), $this->getType($property), $this->isOptional($property)));
            }
        }
        return $this->build();

    }
    public function getName(): string {
        return $this->name;
    }
    protected function build(): string {
        $basic = new Basic($this->name, $this->extends, $this->imports);

        foreach($this->fields as $field) {
            $basic->append(new ClassField($field));
        }
        return $basic->build();

    }
}