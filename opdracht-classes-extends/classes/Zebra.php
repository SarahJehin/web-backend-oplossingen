<?php

class Zebra extends Animal{
    
    protected $species;
    
    
    function __construct($name, $gender, $health, $species) {
        
        parent::__construct($name, $gender, $health);
        
        $this->species = $species;
    }
    
    public function getSpecies() {
        return $this->species;
    }
    
}

?>