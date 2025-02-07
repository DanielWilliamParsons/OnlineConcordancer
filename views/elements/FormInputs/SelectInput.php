<?php //   ../views/elements/FormInputs/SelectInput.php

class SelectInput {
	
	public function __construct(array $options) {
		$this->view = View::instantiateView();
		$this->name = "";
		$this->id = "";
		$this->className = "";
		$this->options = $options;
		$this->disabled = false;
		$this->otherAttributes = "";
	}
	
	public function addName($name) {
		$this->name = "name='" . $name . "' ";
	}
	
	public function addID($id) {
		$this->id = "id='" . $id . "' ";
	}
	
	public function addClassName($classname) {
		$this->className = "class='" . $classname . "' ";
	}
	
	public function setDisabled($bool) {
		if($bool !== true || $bool !== false) {
			$bool = false;
		}
		$this->disabled = $bool;
	}
	
	public function addOtherAttributes($otherAttributes) {
		$this->otherAttributes .= $otherAttributes;
	}
	
	public function concatenate() {
		$options = "<option value='None'> -Select- </option>";
		foreach($this->options as $key=>$value) {
			$options .= "<option value='" . $key . "'>" . $value . "</option>";
		}
		
		if($this->disabled === true) {
			$disabled = " disabled";
		} else {
			$disabled = "";
		}
		
		$attributes = $this->name . 
						$this->id . 
						$this->className . 
						$this->otherAttributes . 
						$disabled;
		return $this->view->makeTextWrap("select", $attributes, $options);
	}
	
}

?>