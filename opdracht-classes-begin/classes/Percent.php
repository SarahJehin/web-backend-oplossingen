<?php


class Percent {
 
    public $absolute;
    public $relative;
    public $hundred;
    public $nominal;
    
    // Een constructor wordt automatisch uitgevoerd bij het aanmaken van een instantie van een class
    public function __construct($new, $unit) {
        $this->absolute = $this->formatNumber(($new / $unit));
        //echo($this->absolute);
        $this->relative = $this->formatNumber(($this->absolute-1));
        $this->hundred = $this->formatNumber(($this->absolute * 100));
        if($this->absolute > 1) {
            $this->nominal = "positive";
        }
        else if($this->absolute == 1) {
            $this->nominal = "status quo";
        }
        else if($this->absolute < 1) {
            $this->nominal = "negative";
        }
    }
    
    public function formatNumber($number) {
        return number_format($number, 2, '.', '');
    }
    
    
}
    


?>