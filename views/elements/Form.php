<?php  //  ../views/elements/Form.php

/*
	---FORM ELEMENTS---
	Creates form on the fly with simple methods - use this reference to create forms easily!
	
	---METHODS---
	***Note, the following parameters are strings***
	***Default is to enable all the fields***
	
		*TEXT INPUT* addTextInput($disabled=false, $name="", $value="", 
						$placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="")
		
		*EMAIL INPUT* addEmailInput($disabled=false, $name="", $value="", 
						$placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="")
		
		*PASSWORD INPUT* addPasswordInput($disabled=false, $name="", $value="", 
							$placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="")
		
		*NUMBER INPUT* addNumberInput($disabled=false, $name="", $value="", 
							$placeholder="", $maxlength="", $id="", $className="", $iconName="", $min="", $max="", $step="", $labelTitle="")
		
		*DATE INPUT*   addDateInput($disabled=false, $name="", $value="", 
							$placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="")
		
		*SUBMIT BUTTON* addSubmitButton($title="", $class="", $id="", $name="", $value="", $otherAttributes="") - add javascript to $otherAttributes as necessary
		
		*HIDDEN FIELD* addHiddenInput($name="", $id="", $value="")
		
		*TEXT AREA FIELD* addTextarea($disabled=false, $name="", $value="", $placeholder="", $id="", $class="", $rows="", $otherAttributes, $labelTitle)
	
	
	***The following parameters are arrays***
	
		*CHECKBOX* addCheckBoxes(array $disabled, array $checked, 
					array $name, array $value, array $id, array $className, array $label)
					
		*RADIOS* addRadios(array $disabled, array $checked, array $name, 
					array $value, array $id, array $className, array $label)
		
		*SELECT*  addSelectInput($options, $disabled=false, $name="", $class="", 
					$id="", $otherAttributes="", $labelTitle="")
		The $options in select must be an array of the type $option[$value]=>$label
			where $value is the array key that will become the value of the option, and $label will become the label that the user can choose
					
	---CREATION---
	Can decide on a default form by doing nothing.
	Create a horizontal form with horizontalForm()
	Create an inline form with inline()
	
	---VIEW---
	makeForm() pushes form's HTML to HTMLEntities' ScreenView property
	getForm() returns the form to the caller
	showForm() outputs the raw form as it stands.
	
	---AJAX---
	To create form processing using ajax, create the form without any post or method
	Do not add a submit button.
	Instead, create a button with an attribute for onclick=somejavascript()
	The javascript should get each form element's value using document.getElementById() method
	Then the call to the ajax index should be sent with these post values
*/


require_once "FormInputs/TextInput.php";
require_once "FormInputs/NumberInput.php";
require_once "FormInputs/EmailInput.php";
require_once "FormInputs/PasswordInput.php";
require_once "FormInputs/DateInput.php";
require_once "FormInputs/Textarea.php";
require_once "FormInputs/CheckboxInput.php";
require_once "FormInputs/RadioInput.php";
require_once "FormInputs/SubmitButton.php";
require_once "FormInputs/HiddenInput.php";
require_once "FormInputs/SelectInput.php";
require_once "ScriptGenerator.php";
require_once "HTMLElement.php";
require_once "FormGroup.php";

class Form {
	
	const INLINE = "class='form-inline' ";
	const HORIZONTAL = "class='form-horizontal' ";
	
	public function __construct($method="", $action="", $multi=false, $id="") {
		$this->view = View::instantiateView();
		$this->className = "";
		$this->role = "role='form' ";
		$this->method = "method='" . $method . "' ";
		$this->action = "action='" . $action . "' ";
		$this->formGroup = new FormGroup();
		$this->javascriptAJAX = "";
		$this->inputElements = "";
		$this->multi = $multi;
		$this->id = "";
	}
	
	public function inlineForm() {
		$this->className = self::INLINE;
	}
	
	public function horizontalForm() {
		$this->className = self::HORIZONTAL;
	}
	
	public function setMethod($method) {
		$this->method = "method='" . $method . "' ";
	}
	
	public function setAction($actionFile) {
		$this->action = "action='" . $actionFile . "' ";
	}
	
	public function setMultipartEncodingTrue() {
		$this->multi = true;
	}
	
	public function addMessageSpan($id) {
		$span= "<span id='" . $id . "'</span>";
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline("", "", $span);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal("", "", $span);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup("", "", $span);
		}
	}
	
	public function addTextInput($disabled=false, $name="", $value="", $placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="", $otherAttributes="") {
		$textInput = new TextInput();
		if($name!=="") $textInput->addName($name);
		if($value!=="") $textInput->addValue($value);
		if($maxlength!=="") $textInput->addMaxlength($maxlength);
		if($id!=="") $textInput->addID($id);
		if($className!=="") $textInput->addClass($className);
		if($placeholder!=="") $textInput->addPlaceholder($placeholder);
		$textInput->setDisabled($disabled);
		if($iconName!=="") $textInput->setIconOn($iconName);
		if($otherAttributes!=="") $textInput->addOtherAttributes($otherAttributes);
		$textInput = $textInput->concatenate();
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $textInput);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $textInput);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $textInput);
		}
			
	}
	
	public function addEmailInput($disabled=false, $name="", $value="", $placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="") {
		$emailInput = new EmailInput();
		if($name!=="") $emailInput->addName($name);
		if($value!=="") $emailInput->addValue($value);
		if($placeholder!=="") $emailInput->addPlaceholder($placeholder);
		if($maxlength!=="") $emailInput->addMaxlength($maxlength);
		if($id!=="") $emailInput->addID($id);
		if($className!=="") $emailInput->addClass($className);
		$emailInput->setDisabled($disabled);
		if($iconName!=="") $emailInput->setIconOn($iconName);
		$emailInput = $emailInput->concatenate();
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $emailInput);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $emailInput);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $emailInput);
		}
	}
	
	public function addPasswordInput($disabled=false, $name="", $value="", $placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="") {
		$passwordInput = new PasswordInput();
		if($name!=="") $passwordInput->addName($name);
		if($value!=="") $passwordInput->addValue($value);
		if($placeholder!=="") $passwordInput->addPlaceholder($placeholder);
		if($maxlength!=="") $passwordInput->addMaxlength($maxlength);
		if($id!=="") $passwordInput->addID($id);
		if($className!=="") $passwordInput->addClass($className);
		$passwordInput->setDisabled($disabled);
		if($iconName!=="") $passwordInput->setIconOn($iconName);
		$passwordInput = $passwordInput->concatenate();
		
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $passwordInput);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $passwordInput);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $passwordInput);
		}
	}
	
	public function addNumberInput($disabled=false, $name="", $value="", $placeholder="", $maxlength="", $id="", $className="", $iconName="", $min="", $max="", $step="", $labelTitle="") {
		$numberInput = new NumberInput();
		if($name!=="") $numberInput->addName($name);
		if($value!=="") $numberInput->addValue($value);
		if($maxlength!=="") $numberInput->addMaxlength($maxlength);
		if($id!=="") $numberInput->addID($id);
		if($className!=="") $numberInput->addClass($className);
		if($placeholder!=="") $numberInput->addPlaceholder($placeholder);
		$numberInput->setDisabled($disabled);
		if($iconName!=="") $numberInput->setIconOn($iconName);
		if($min!=="") $numberInput->addMin($min);
		if($max!=="") $numberInput->addMax($max);
		if($step!=="") $numberInput->addStep($step);
		$numberInput = $numberInput->concatenate();
		
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $numberInput);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $numberInput);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $numberInput);
		}
	}
	
	public function addDateInput($disabled=false, $name="", $value="", $placeholder="", $maxlength="", $id="", $className="", $iconName="", $labelTitle="") {
		$textInput = new DateInput();
		if($name!=="") $textInput->addName($name);
		if($value!=="") $textInput->addValue($value);
		if($maxlength!=="") $textInput->addMaxlength($maxlength);
		if($id!=="") $textInput->addID($id);
		if($className!=="") $textInput->addClass($className);
		if($placeholder!=="") $textInput->addPlaceholder($placeholder);
		$textInput->setDisabled($disabled);
		if($iconName!=="") $textInput->setIconOn($iconName);
		$textInput = $textInput->concatenate();
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $textInput);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $textInput);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $textInput);
		}
			
	}
	
	public function addTextarea($disabled=false, $name="", $value="", $placeholder="", $id="", $class="", $rows="", $otherAttributes="", $labelTitle="") {
		$textarea = new Textarea();
		if($name!=="") $textarea->addName($name);
		if($value!=="") $textarea->addValue($value);
		if($placeholder!=="") $textarea->addPlaceholder($placeholder);
		if($id!=="") $textarea->addID($id);
		if($class!=="") $textarea->addClassname($class);
		if($rows!=="") $textarea->addRows($rows);
		if($otherAttributes!=="") $textarea->addOtherAttributes($otherAttributes);
		$textarea->setDisabled($disabled);
		
		$textarea = $textarea->concatenate();
		
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $textarea);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $textarea);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $textarea);
		}
	}
	
	public function addCheckBoxes(array $disabled, array $checked, array $name, array $value, array $id, array $className, array $label) {
		$count = count($label);
		for($i=0; $i<$count; ++$i) {
			$checkboxInput[$i] = new CheckboxInput();
		}
		
		if(count($name)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->addName($name[$key]);
			}
		}
		
		if(count($value)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->addValue($value[$key]);
			}
		}
		
		if(count($id)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->addID($id[$key]);
			}
		}
		
		if(count($className)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->addClass($className[$key]);
			}
		}
		
		if(count($disabled)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->setDisabled($disabled[$key]);
			}
		}
		
		if(count($checked)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->setChecked($checked[$key]);
			}
		}
		
		if(count($label)>=1) {
			foreach($checkboxInput as $key=>&$checkbox) {
				$checkbox->setLabel($label[$key]);
			}
		}

		
		foreach($checkboxInput as &$checkbox) {
			if($this->className === self::INLINE) {
				$checkbox = $checkbox->concatenate(true);
			} else {
				$checkbox = $checkbox->concatenate(false);
			}
			
			$checkbox = $this->view->makeDiv("class='checkbox'", $checkbox);
		}
		$checkboxes = implode("", $checkboxInput);
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxInline($checkboxes);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxHorizontal($checkboxes);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroupCheckbox($checkboxes);
		}
		
	}
	
	public function addRadios(array $disabled, array $checked, array $name, array $value, array $id, array $className, array $label) {
		$count = count($label);
		for($i=0; $i<$count; ++$i) {
			$radioInput[$i] = new RadioInput();
		}
		
		if(count($name)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->addName($name[$key]);
			}
		}
		
		if(count($value)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->addValue($value[$key]);
			}
		}
		
		if(count($id)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->addID($id[$key]);
			}
		}
		
		if(count($className)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->addClass($className[$key]);
			}
		}
		
		if(count($disabled)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->setDisabled($disabled[$key]);
			}
		}
		
		if(count($checked)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->setChecked($checked[$key]);
			}
		}
		
		if(count($label)>=1) {
			foreach($radioInput as $key=>&$radio) {
				$radio->setLabel($label[$key]);
			}
		}

		
		foreach($radioInput as &$radio) {
			if($this->className === self::INLINE) {
				$radio = $radio->concatenate(true);
			} else {
				$radio = $radio->concatenate(false);
			}
			$radio = $this->view->makeDiv("class='radio'", $radio);
		}
		$radios = implode("", $radioInput);
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxInline($radios);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxHorizontal($radios);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroupCheckbox($radios);
		}
		
	}
	
	public function addSelectInput($options, $disabled=false, $name="", $class="", $id="", $otherAttributes="", $labelTitle="") {
		$select = new SelectInput($options);
		if($name!=="") $select->addName($name);
		if($class!=="") $select->addClassName($class);
		if($id!=="") $select->addID($id);
		$select->setDisabled($disabled);
		if($otherAttributes!=="") $select->addOtherAttributes($otherAttributes);
		
		$select = $select->concatenate();
		
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupInline($id, $labelTitle, $select);
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupHorizontal($id, $labelTitle, $select);
		} else {
			$this->inputElements .= $this->formGroup->createFormGroup($id, $labelTitle, $select);
		}
	}
	
	public function addSubmitButton($title="", $class="", $id="", $name="", $value="", $otherAttributes="") {
		$button = new SubmitButton();
		if($title!=="") $button->addButtonTitle($title);
		if($class!=="") $button->changeClass($class);
		if($id!=="") $button->addID($id);
		if($name!=="") $button->addName($name);
		if($value!=="") $button->addValue($value);
		if($otherAttributes!=="") $button->addOtherAttributes($otherAttributes);
		$button = $button->concatenate();
		if($this->className === self::INLINE) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxInline($button); //This method wraps the button in the same divs and labels, so it can be used.
		} else if ($this->className === self::HORIZONTAL) {
			$this->inputElements .= $this->formGroup->createFormGroupCheckboxHorizontal($button);
		} else {
			$this->inputElements .= $button;
		}
	}
	
	public function addHiddenInput($name="", $id="", $value="") {
		$hidden = new HiddenInput();
		if($id!=="") $hidden->addID($id);
		if($name!=="") $hidden->addName($name);
		if($value!=="") $hidden->addValue($value);
		$hidden = $hidden->concatenate();
		$this->inputElements .= $hidden;
	}
	
	public function makeForm() {
		
		if($this->multi == true) {
			$encoding = "enctype='multipart/form-data'";
		} else {
			$encoding = "";
		}
		
		if($this->method == "method=''") $this->method="";
		if($this->action == "action=''") $this->action="";
		
		$formAttributes = $this->role . 
									$this->className .
									$this->action . 
									$this->method . 
									$this->id . 
									$encoding;
		$form = $this->view->makeTextWrap("form", $formAttributes, $this->inputElements);
		$this->view->pushHTMLtoScreenView($form);
	}
	
	public function getForm() {
		if($this->multi == true) {
			$encoding = "enctype='multipart/form-data'";
		} else {
			$encoding = "";
		}
		
		if($this->method == "method=''") $this->method="";
		if($this->action == "action=''") $this->action="";
		
		$formAttributes = $this->role . 
									$this->className .
									$this->action . 
									$this->method .
									$this->id . 
									$encoding;
		$form = $this->view->makeTextWrap("form", $formAttributes, $this->inputElements);
		return $form;
	}
	
	public function showForm() {
		if($this->multi == true) {
			$encoding = "enctype='multipart/form-data'";
		} else {
			$encoding = "";
		}
		if($this->method == "method=''") $this->method="";
		if($this->action == "action=''") $this->action="";
		
		$formAttributes = $this->role . 
									$this->className .
									$this->action . 
									$this->method .
									$this->id . 
									$encoding;
		$form = $this->view->makeTextWrap("form", $formAttributes, $this->inputElements);
		echo $form;
	}
	
}

?>