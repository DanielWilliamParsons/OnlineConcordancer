<?php

class TextInput {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->type = "type='text' ";
		$this->name = "";
		$this->value = "";
		$this->placeholder = "";
		$this->maxlength = "";
		$this->id = "";
		$this->className = "";
		$this->iconOn = false;
		$this->icon = "glyphicon glyphicon-";
		$this->disabled = false;
		$this->otherAttributes = "";
	}
	
	public function addName($name) {
		$this->name = "name='" . $name . "' ";
	}
	
	public function addValue($value) {
		$this->value = "value='" . $value . "' ";
	}
	
	public function addPlaceholder($placeholder) {
		$this->placeholder = "placeholder='" . $placeholder . "' ";
	}
	
	public function addMaxlength($maxlength) {
		$this->maxlength = "maxlength='" . $maxlength . "' ";
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
	
	public function setIconOn($iconName) {
		$this->iconOn = true;
		$this->icon .= $iconName;	
	}
	
	public function setDisabled($bool) {
		if($bool === true || $bool === false) {
			$this->disabled = $bool;
		} else {
			$bool = false;
		}
	}
	
	public function concatenate() {
		//Decide if the input has an icon
		if($this->iconOn === true) {
			$icon = $this->icon . " form-control-feedback";
			$icon = "class='" . $icon . "'";
			$icon = $this->view->makeTextWrap("span", $icon, "");
		} else {
			$icon = "";
		}
		
		if($this->disabled === true) {
			$disabled = " disabled";
		} else {
			$disabled = "";
		}
		
		$totalAttributes = $this->type . 
									$this->name . 
									$this->value . 
									$this->placeholder . 
									$this->maxlength . 
									$this->id . 
									$this->className . 
									$this->otherAttributes .
									$disabled;
		return $this->view->makeLinkWrap("input", $totalAttributes, $icon);
	}
}

?>