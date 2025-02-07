<?php

class SubmitButton {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->type = "type='submit' ";
		$this->name = "";
		$this->value = "";
		$this->className = "class='btn btn-default'";
		$this->buttonTitle = "";
		$this->id = "";
		$this->otherAttributes = "";
	}
	
	public function addName($name) {
		$this->name = "name='" . $name . "' ";
	}
	
	public function addValue($value) {
		$this->value = "value='" . $value . "' ";
	}
	
	public function addButtonTitle($title) {
		$this->buttonTitle = $title;
	}
	
	public function changeClass($className) {
		$this->className = "class='" . $className . "' ";
	}
	
	public function addID($id) {
		$this->id = "id='" . $id . "' ";
	}
	
	public function addOtherAttributes($attributes) {
		$this->otherAttributes .= $attributes;
	}
	
	public function concatenate() {
		$totalAttributes = $this->type . 
									$this->name . 
									$this->value . 
									$this-> id . 
									$this->className . 
									$this->otherAttributes;
		return $this->view->makeTextWrap("button", $totalAttributes, $this->buttonTitle);
	}
}

?>