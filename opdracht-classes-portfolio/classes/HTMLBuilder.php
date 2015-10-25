<?php


class HTMLBuilder {
    
    protected $headerFile;
    protected $bodyFile;
    protected $footerFile;
    
    function __construct($headerFile, $bodyFile, $footerFile) {
        
        $this->headerFile   = $headerFile;
        $this->bodyFile     = $bodyFile;
        $this->footerFile   = $footerFile;
    }
    
    public function buildHeader() {
        
        //var_dump($this->getCSSFiles()); 
        //alle css bestanden ophalen
        $arrOfCSSFiles = $this->getCSSFiles();
        
        //alle css bestanden in een link element steken
        $stringOfCSSLinks = $this->createLinks($arrOfCSSFiles);
        
        include $this->headerFile;
        
    }
    
    public function buildBody() {
        
        include $this->bodyFile;
        
    }
    
    
    public function buildFooter() {
        
        //alle js bestanden ophalen
        $arrOfJsFiles = $this->getJsFiles();
        
        //alle js bestanden in een script tag steken
        $stringOfJsTags = $this->createJsTags($arrOfJsFiles);
        
        include $this->footerFile;
        
    }
    
    
    public function getCSSFiles() {
        
        //met scandir krijg je alle files en directories van een directory terug als array, door de paramter 1 krijg je ze in tegengestelde alfabetische volgorde
        //je krijgt op het einde .. en . terug, deze mag je niet opnemen in je links
        $cssFiles = scandir("css", 1);
        
        return $cssFiles;
    }
    
    public function createLinks($cssFilesArray) {
        
        $arrayOfLinkElements = array();
        //array aanmaken met alle links voor de css
        for($index = 0; $index < (count($cssFilesArray)-2); $index++) {
            $arrayOfLinkElements[$index] = "<link rel='stylesheet' type='text/css' href='css/".$cssFilesArray[$index]."'>";
        }
        //in html mag dit niet binnenkomen als array, maar als 1 string --> array naar string => implode
        $stringOfLinks = implode("\r\n", $arrayOfLinkElements);
        
        return $stringOfLinks;
        
    }
    
    
    
    public function getJsFiles() {
        
        //met scandir krijg je alle files en directories van een directory terug als array, door de paramter 1 krijg je ze in tegengestelde alfabetische volgorde
        //je krijgt op het einde .. en . terug, deze mag je niet opnemen in je links
        $jsFiles = scandir("js", 1);
        
        return $jsFiles;
    }
    
    
    public function createJsTags($jsFilesArray) {
        
        $arrayOfTags = array();
        //array aanmaken met alle links voor de css
        for($index = 0; $index < (count($jsFilesArray)-2); $index++) {
            $arrayOfTags[$index] = "<script src='js/".$jsFilesArray[$index]."'></script>";
        }
        //in html mag dit niet binnenkomen als array, maar als 1 string --> array naar string => implode
        $stringOfTags = implode("\r\n", $arrayOfTags);
        
        return $stringOfTags;
        
    }
    
    
    
    
}


?>