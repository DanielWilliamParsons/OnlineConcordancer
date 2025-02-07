<?php

class CheckboxInput {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->type = "type='checkbox' ";
		$this->name = "";
		$this->value = "";
		$this->checked = false; //This value should be a boolean, true or false
		$this->disabled = false;
		$this->id = "";
		$this->label = "";
		$this->className = "";
		$this->otherAttributes = "";
	}
	
	public function addName($name) {
		$this->name = "name='" . $name . "' ";
	}
	
	public function addValue($value) {
		$this->value = "value='" . $value . "' ";
	}
	
	public function addID($id) {
		$this->id = "id='" . $id . "' ";
	}
	
	public function addClass($className) {
		$this->className = "class='" . $className . "' ";
	}
	
	public function addOtherAttributes($attributes) {
		$this->otherAttributes .= $attributes;
	}
	
	public function setLabel($label) {
		$this->label = $label;
	}
	
	public function setDisabled($bool) {
		if($bool === true || $bool === false) {
			$this->disabled = $bool;
		} else {
			$this->disabled = false;
		}
	}
	
	public function setChecked($bool) {
		if($bool === true || $bool === false) {
			$this->checked = $bool;
		} else {
			$this->checked = false;
		}
	}
	
	public function concatenate($bool) {
		if($this->checked === true) {
			$checked = " checked";
		} else {
			$checked = "";
		}
		
		if($this->disabled === true) {
			$disabled = " disabled";
		} else {
			$disabled = "";
		}
		
		$totalAttributes = $this->type .
									$this->name . 
									$this->value . 
									$this->id . 
									$this->className . 
									$this->otherAttributes . 
									$checked . $disabled;
		$checkbox = $this->view->makeLinkWrap("input", $totalAttributes);
		if($bool===false) {
			return $this->view->makeTextWrap("label", "", $checkbox . $this->label); //Wraps the textbox in a label for the form.
		} else {
			return $this->view->makeTextWrap("label", "class='checkbox-inline'", $checkbox . $this->label); //Wraps the textbox in a label for the form.
		}
		
	}
}

?>