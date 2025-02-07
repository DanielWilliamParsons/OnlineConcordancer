<?php  //  ../views/elements/HTMLElement.php
/*
		Daniel Parsons, 2014 PHP HTML Factory
		
		---View---
		
		This class creates a HTML element strings such as <div> ... </div>
		It can add classes, and it makes sure there is only one class by using the latest class
		It can add ids, and it makes sure there is only one id by using the latest id
		It can add any attribute which the user of this class includes, however, each attribute can only be used once.
		If an attribute is called more than once, then the attribute is updated with the latest attribute's value.
		It can add content to the element, with no limits to what that content is, including other HTML elements, which allows for nesting.
		
		
		---Patterns---
		
		I am trying to use a Factory pattern combined with a Singleton pattern.
		The HTMLElement could be called hundreds of times in a single page call
		It may be more efficient to use a single instance of it, re-setting the html attributes and content
		properties after each element is created using makeElement().
		This way the instance variables stay in memory and don't have to be re-created
		with each call to it.
		The interface defines all the factory functions for making the various HTML elements required.
		So long as there is only ONE instance of this class, then there will only ever be ONE View
		There will only ever be ONE instance variable screenView which will finally be output to the user.
		
*/

require_once "ScriptGenerator.php";
interface IView {
	function makeDiv($attributes, $content);
	function makeTextWrap($textWrapType, $attributes="", $content=""); //This is for generic tags - h1, h2, h3, ul, li, a, etc
	function makeLinkWrap($linkWrapType, $attributes="", $content="");
}

class View implements IView{
	private $leftTag, $elementType, $rightTag, $endTag;
	private $elementAttributes;
	private $content;
	protected $screenView; // ---This is the final view which will get created for the user
	
	static $thisClass = false; // ---Used to check whether the class has been instantiated or not
	
	private function __construct() {
		$this->leftTag = "<";
		$this->elementType = "";
		$this->rightTag = ">";
		$this->endTag = "";
		$this->screenView = array();
	}
	
	/*
		---This instantiates the singleton---
	*/
	public static function instantiateView() {
		if(self::$thisClass == false) {
			return self::$thisClass = new View;
		} else {
			return self::$thisClass;
		}
	}
	
	/*
		---The View---
			These methods set up the screenView for the user;
	*/
	public function pushHTMLtoScreenView($HTML) {
		$this->screenView[] = $HTML;
	}
	
	public function pushArraytoScreenView($array) {
		foreach($array as $value) {
			$this->screenView[] = $value;
		}
	}
	
	public function getScreenViewAsHTML() {
		$screenView = "";
		foreach ($this->screenView as $value) {
			$screenView .= $value;
		}
		$script = ScriptGenerator::instantiateScriptGenerator();
		return $screenView . $script->getScript();
	}
	
	public function getScreenViewAsArray() {
		return $this->screenView;
	}
	
	
	/*
		---IMPLEMENTATION
		---From here all the functions in the interface get implemented---
	*/
	public function makeDiv($attributes, $content) {
		$this->element = "";
		$this->elementType = "div ";
		$this->setEndTag("div");
		
		if(is_array($attributes)) {
			$attributesString = $this->parseAttributesArray($attributes);
		} elseif(is_string($attributes)) {
			$attributesString = $attributes;
		} else {
			$attributesString = "class='primary'";
		}
		
		if(is_array($content)) {
			$contentString = $this->parseContentArray();
			return $this->makeElement($attributesString, $contentString);
		} elseif(is_string($content)) {
			return $this->makeElement($attributesString, $content);
		} else {
			echo "LOG AN ERROR";
		}
	}
	
	public function makeTextWrap($textWrapType, $attributes="", $content="") {
		$this->element = "";
		$this->elementType = $textWrapType . " ";
		$this->setEndTag($textWrapType);
		
		if(is_array($attributes)) {
			$attributesString = $this->parseAttributesArray($attributes);
		} elseif(is_string($attributes)) {
			$attributesString = $this->parseAttributesString($attributes);
		} else {
			$attributesString = "class='primary'";
		}
		
		if(is_array($content)) {
			$contentString = $this->parseContentArray($content);
			return $this->makeElement($attributesString, $contentString);
		} elseif(is_string($content) || $content=="") {
			return $this->makeElement($attributesString, $content);
		} else {
			echo "LOG AN ERROR";
		}
	}
	
	public function makeLinkWrap($linkWrapType, $attributes="", $content="") {
		$this->element = "";
		$this->elementType = $linkWrapType . " ";
		$this->setEndTag("");
		
		if(is_array($attributes)) {
			$attributesString = $this->parseAttributesArray($attributes);
		} elseif(is_string($attributes)) {
			$attributesString = $this->parseAttributesString($attributes);
		} else {
			$attributesString = "class='primary'";
		}
		
		if(is_array($content)) {
			$contentString = $this->parseContentArray();
			return $this->makeElement($attributesString, $contentString);
		} elseif(is_string($content) || $content=="") {
			return $this->makeElement($attributesString, $content);
		} else {
			echo "LOG AN ERROR";
		}
		
	}
	
	/*
		---private helper functions are defined from here
	*/
	
	private function setEndTag($endTag) {		
		if($endTag === "") {
			$this->endTag = "";
		} else {
			$this->endTag = "</" . $endTag . ">";
		}
	}
	
	private function parseAttributesArray($attributesArray) {
		$attributesString = "";
		$keys = array_keys($attributesArray);
		if(is_string($keys[0])) {
			foreach($attributesArray as $key=>$value) {
				$attributesString .= $key . "='" . $value . "' ";
			}
		} elseif(is_numeric($keys[0])) {
			foreach($attributesArray as $value) {
				$attributesString .= $value . ", ";
			}
		} else {
			$attributesString .= "class='primary'";
		}
		return $attributesString;
	}
	
	private function parseAttributesString($attributesString) {
		//Need to write a function which ensures the string looks like this:
		//class='Primary' id='thisId'
		return $attributesString;
	}
	
	private function parseContentArray($contentArray) {
		$contentString = "";
		foreach($contentArray as $value) {
			$contentString .= $value;
		}
		return $contentString;
	}
	
	/*
		---All the properties of the class are concatenated here---
	*/
	private function makeElement($attributes="", $content="") {
						$element =  $this->leftTag . 
									$this->elementType . " " .
									$attributes;
						$element = rtrim($element);
						$element .= $this->rightTag . 
									$content . 
									$this->endTag;
						return $element;
									
	}
	
}