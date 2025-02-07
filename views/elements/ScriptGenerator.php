<?php

class ScriptGenerator {
	
	public function __construct() {
		$this->scriptWrapTop = "$(document).ready(function() {";
		$this->scriptWrapBottom = "});";
		$this->script = array();
		$this->hiddenHTML = array();
		
		$this->placement = "placement: ";
		$this->container = "container: ";
		$this->delay = "delay: ";
		$this->html = "html: true";
		$this->popoverTitle = "title: ";
		$this->popoverContentWrapLeft = "content: $('#";
		$this->popoverContentID = "";
		$this->popoverContentWrapRight = "').html()";
	}
	
	static $thisClass = false;
	
	public static function instantiateScriptGenerator() {
		if(self::$thisClass == false) {
			return self::$thisClass = new ScriptGenerator();
		} else {
			return self::$thisClass;
		}
	}
	
	public function addTooltip($id, $scriptName = "") {
		$id = substr($id, 4, strlen($id));
		$this->script["$scriptName"] = "$('#$id).tooltip();"; //The ' before # doesn't need completing since it isn't removed from the end of $id
																//in the line above. Trust me, it works!!!
																//Though it's not good because now this method is tied to the data it receives
																//and incoming data MUST have the following style id='something'
	}
	
	public function addPopover($id, $contentID, $placement, $container, $delay, $popoverTitle, $popoverContent, $scriptname = "") {
		//Set javascript plugin properties
		$this->placement .= "'" . $placement . "' ";
		$this->container .= "'" . $container . "' ";
		$this->delay .= "'" . $delay . "' ";
		$this->popoverTitle .= "'" . $popoverTitle . "' ";
		$this->popoverContentID .= "'" . $popoverContentID . "' ";
		
		//Make hidden popover HTML
		$popoverContent = "<div id='" . $contentID . "' class='hide'>" . $popoverContent . "</div>";
		$this->hiddenHTML["$scriptname"] = $popoverContent;
		
		//Make the javascript
		$script = "$('#" . rtrim(substr($id, 4, strlen($id))) . ").popover({" . 
					$this->popoverTitle . ", " . 
					$this->html . ", " . 
					$this->popoverContentWrapLeft . $contentID . $this->popoverContentWrapRight . ", " . 
					$this->placement . ", " . 
					$this->delay . ", " . 
					$this->container . "});";
		$this->script["$scriptname"] = $script;
	}
	
	
	//Gets all the scripts in the script array for outputting at the end of the HTML document
	public function getScript() {
		$outputScript = "";
		
		foreach($this->script as $javascript) {
			$outputScript .= "<script>" . $this->scriptWrapTop . $javascript . $this->scriptWrapBottom . "</script>";
		}
		
		if(!empty($this->hiddenHTML)) {
			foreach($this->hiddenHTML as $html) {
				$outputScript .= $html;
			}
		}
		
		return $outputScript;
	}
	
	//Gets a specific script which the user named
	//Note that the script is then deleted from the array
	public function getMyScriptWithName($scriptName) {
		$myScript = $this->script["$scriptName"];
		$this->script["$scriptName"] = "";
		return "<script>" . $this->scriptWrapTop . $myScript . $this->scriptWrapBottom . "</script>";
	}
	
}

?>