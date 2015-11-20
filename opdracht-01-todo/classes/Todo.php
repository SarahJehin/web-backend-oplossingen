<?php

class Todo {
    
    protected $name;
    protected $status;
    
    function __construct($name, $status) {
        $this->name = $name;
        $this->status = $status;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function changeStatus() {
        
        if($this->status == "not_done") {
            $this->status = "done";
        }
        else {
            $this->status = "not_done";
        }
        return $this->status;
    }
    
    
}


?>