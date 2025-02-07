<?php
require_once "TextInput.php";

class EmailInput extends TextInput{
	
	public function __construct() {
		parent::__construct();
		$this->view = View::instantiateView();
		$this->type = "type='email' ";
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
		
		$totalAttributes = $this->type .
									$this->name . 
									$this->value . 
									$this->placeholder . 
									$this->id . 
									$this->className . 
									$this->otherAttributes;
		return $this->view->makeLinkWrap("input", $totalAttributes, $icon);
	}
}

?>