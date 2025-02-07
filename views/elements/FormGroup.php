<?php

class FormGroup {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->hasSuccess = false;
		$this->hasWarning = false;
		$this->hasError = false;
		$this->attributes = "";
	}
	
	public function createFormGroup($id, $labelTitle, $inputElementHTML) {
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";
		
		$label = $this->view->makeTextWrap("label", "for='$id'", $labelTitle);
		return $this->view->makeDiv($this->attributes, $label . $inputElementHTML);
	}
	
	public function createFormGroupInline($id, $labelTitle, $inputElementHTML) {
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";
		
		$label = $this->view->makeTextWrap("label", "class='sr-only' for='$id'", $labelTitle);
		return $this->view->makeDiv($this->attributes, $label . $inputElementHTML);
	}
	
	public function createFormGroupHorizontal($id, $labelTitle, $inputElementHTML) {
	
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";
		
		$label = $this->view->makeTextWrap("label", "for='$id' class='col-sm-2 control-label'", $labelTitle);
		$inputDiv = $this->view->makeDiv("class='col-sm-10'", $inputElementHTML);
		return $this->view->makeDiv($this->attributes, $label . $inputDiv);
	}
	
	public function createFormGroupCheckbox($inputElementHTML) {
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";
		return $this->view->makeDiv($this->attributes, $inputElementHTML);
	}
	
	public function createFormGroupCheckboxInline($inputElementHTML) {
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";
		return $this->view->makeDiv($this->attributes, $inputElementHTML);
	}
	
	public function createFormGroupCheckboxHorizontal($inputElementHTML) {
	
		$this->attributes = "class='form-group";
		if($this->hasSuccess === true) {
			$this->attributes .= " has-success has-feedback";
		}
		
		if($this->hasWarning === true) {
			$this->attributes .= " has-warning has-feedback";
		}
		
		if($this->hasError === true) {
			$this->attributes .= " has-error has-feedback";
		}
		
		$this->attributes .= "'";

		$inputDiv = $this->view->makeDiv("class='col-sm-offset-2 col-sm-10'", $inputElementHTML);
		return $this->view->makeDiv($this->attributes, $inputDiv);
	}
	
}

?>