<?php
require_once 'TextInput.php';

class NumberInput extends TextInput {
	
	public function __construct() {
		parent::__construct();
		$this->type = "type='number' ";
		$this->max = "";
		$this->min = "";
		$this->step = "";
	}
	
	public function addMax($maxValue) {
		$this->max = "max='" . $maxValue . "' ";
	}
	
	public function addMin($minValue) {
		$this->min = "min='" . $minValue . "' ";
	}
	
	public function addStep($step) {
		$this->step = "step='" . $step . "'";
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
									$this->max . 
									$this->min . 
									$this->step . 
									$this->id . 
									$this->className . 
									$this->otherAttributes;
		return $this->view->makeLinkWrap("input", $totalAttributes, $icon);
	}
}

?>