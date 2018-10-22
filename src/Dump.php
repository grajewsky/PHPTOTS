<?php 
namespace PTT;
use PTT\Interfaces\Convert;

class Dump {
    public static function dump($filepath, Convert $converter): void {
        file_put_contents($filepath, $converter->convert());
    }
} 