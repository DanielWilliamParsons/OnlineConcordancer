<?php

class Textarea {
	
	public function __construct() {
		$this->classname = "class='form-control'";
		$this->rows = "3";
		$this->placeholder = "";
		$this->name = "";
		$this->id = "";
		$this->value = "";
		$this->otherAttributes = "";
		$this->disabled = false;
		
		$this->view = View::instantiateView();
	}
	
	public function addClassname($class) {
		$this->classname = "class='" . $class . "' ";
	}
	
	public function addRows($number) {
		$this->rows = "rows='" . $number . "' ";
	}
	
	public function addPlaceholder($placeholder) {
		$this->placeholder = "placeholder='" . $placeholder . "' ";
	}
	
	public function addName($name) {
		$this->name = "name='" . $name . "' ";
	}
	
	public function addID($id) {
		$this->id = "id='" . $id . "' ";
	}
	
	public function addValue($value) {
		$this->value = "value='" . $value . "' ";
	}
	
	public function addOtherAttributes($attributes) {
		$this->otherAttributes .= $attributes;
	}
	
	public function setDisabled($bool) {
		if($bool !== true || $bool !== false) {
			$bool = false;
		}
		$this->disabled = $bool;
	}
	
	public function concatenate() {
		if($this->disabled === true) {
			$disabled = " disabled";
		} else {
			$disabled = "";
		}
		
		$totalAttributes = $this->name . 
									$this->value . 
									$this->rows . 
									$this->placeholder .  
									$this->id . 
									$this->classname . 
									$this->otherAttributes .
									$disabled;
		return $this->view->makeTextWrap("textarea", $totalAttributes, "");
	}
	
}

?>