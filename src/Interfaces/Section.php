<?php 


namespace PTT\Interfaces;


interface Section {

    public function build(): string;
    public function append(Section $section);
}