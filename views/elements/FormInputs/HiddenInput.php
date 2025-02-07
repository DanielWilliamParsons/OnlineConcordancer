<?php

class HiddenInput {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->type = "type='hidden' ";
		$this->name = "";
		$this->value = "";
		$this->id = "";
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
		
	public function concatenate() {

		$totalAttributes = $this->type . 
									$this->name . 
									$this->value . 
									$this->id;
		return $this->view->makeLinkWrap("input", $totalAttributes, "");
	}
}

?>