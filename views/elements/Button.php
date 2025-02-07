<?php

require_once "HTMLElement.php";
require_once "Tooltip.php";
require_once "ScriptGenerator.php";

class Button extends Tooltip {
	
	public function __construct($buttonTitle = "", $href = "", $class = "", $id = "") {
		parent::__construct();
		$this->classname = "class='" . $class . "' ";
		$this->id = "id='" . $id . "' ";
		$this->buttonTitle = $buttonTitle;
		$this->otherAttributes = "";
		$this->href = "href='" . $href . "' ";
	}
	
	//Concatenates the button and sends it to the HTMLElement's Screen View
	public function makeButton() {
		$view = View::instantiateView();
		if($this->id == "id='' ") $this->id = "";
		if($this->classname == "class=''") $this->classname = "";
		
		//Add javascript for the tooltip plugin if necessary
		$javascriptPlugin = "";
		if($this->data_placement !== "data-placement=") {
			$script = ScriptGenerator::instantiateScriptGenerator();
			if($this->id == "") $this->id = "id='example" . rand(2,100) . "' ";
			$script->addTooltip($this->id, $this->id);
		}
		$attributes = $this->classname . $this->id . $this->otherAttributes;
		$view->pushHTMLtoScreenView($view->makeTextWrap("button", $attributes, $this->buttonTitle));
	}
	
	//Concatenates the button and returns it to the caller
	public function getButton() {
		$view = View::instantiateView();
		if($this->id == "id='' ") $this->id = "";
		if($this->classname == "class=''") $this->classname = "";
		
		
		//Add javascript for the tooltip plugin if necessary
		$javascriptPlugin = "";
		if($this->data_placement !== "data-placement=") {
			$script = ScriptGenerator::instantiateScriptGenerator();
			if($this->id == "") $this->id = "id='example" . rand(2,100) . "' ";
			$script->addTooltip($this->id, $this->id);
		}
		$attributes = $this->classname . $this->id . $this->otherAttributes;
		return $view->makeTextWrap("button", $attributes, $this->buttonTitle);
	}
	
	//Concatenates the button and outputs the raw HTML to the screen
	//This will not add any javascript functionality since it is raw HTML
	public function showButton() {
		$view = View::instantiateView();
		if($this->id == "id='' ") $this->id = "";
		if($this->classname == "class=''") $this->classname = "";
		$attributes = $this->classname . $this->id . $this->otherAttributes;
		echo $view->makeTextWrap("button", $attributes, $this->buttonTitle);
	}
	
	public function addTooltip($data_placement, $title) {
		$this->data_placement .= "'" . $data_placement . "' ";
		$this->tooltipTitle .= "'" . $title . "' ";
		$this->otherAttributes = $this->data_toggle . " " . $this->data_placement . " " . $this->tooltipTitle . " ";
	}
	
	public function addPopover($contentID, $placement, $container, $delay, $popoverTitle, $popoverContent, $scriptname="") {
		$script = ScriptGenerator::instantiateScriptGenerator();
		$script->addPopover($this->id, $contentID, $placement, $container, $delay, $popoverTitle, $popoverContent, $scriptname);
	}
	
	public function setClass($class) {
		$this->classname = "class='" . $class . "' ";
	}
	
	public function setID($id) {
		$this->id = "id='" . $id . "' ";
	}
	
	public function setButtonTitle($title) {
		$this->buttonTitle = $title;
	}
	
	public function setHref($href) {
		$this->href = "href='" . $href . "' ";
	}
	
	public function addOtherAttributes($otherAttributes) {
		$this->otherAttributes .= $otherAttributes;
	}
	
	
}

?>