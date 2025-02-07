<?php  //  ../views/elements/Placeholder.php

//If a button is required for ajax links, set $putDataInButtons to true and add a name for the buttons
//Currently only one button name is allowed for all the buttons. Upgrade later!
/*
	---PLACEHOLDER---
	This can be used to create an "edit" button, too.
	The last three attributes when constructing this object set up the edit buttons
	Can construct like so
	new Placeholder($labels, $linkIDs, $src, $subtext, true, "Edit", editClass(this));
	true means the edit button is included
	"Edit" is the title on the button
	editClass(this) is the javascript which will be accessed when the button is clicked

*/

class Placeholder {
	
	const ROW_PLACEHOLDERS = "class='row placeholders' ";
	const PLACEHOLDER_WRAP = "class='col-xs-6 col-sm-4 col-md-3 placeholder thumbnail'  id='placeholderWrap'";
	const IMG = "class='img-responsive' ";
	
	public function __construct(array $label, array $linkIDs, array $src, array $subtext, $putDataInForm=false, $buttonNames="", $action="", $dataIdName = "", $dataName = "") {
		
		$this->linkIDs = $linkIDs;
		$this->label = $label;
		$this->subtext = $subtext;
		$this->src = $src;
		$this->example = "<img data-src='docs-assets/js/holder.js/200x200/text:hello world'>";
		//imagesRow will be created through concatenation
		$this->imagesRow = "";
		$this->view = View::instantiateView();
		$this->putDataInForm = $putDataInForm;
		$this->buttonNames = $buttonNames;
		$this->action = $action;
		$this->dataIdName = $dataIdName; //this is the name for hidden field in the form, defaults to "class_id"
		$this->dataName = $dataName; //this is the name used in a post in hidden fields, e.g. class_name
		
	}
	
	public function makePlaceholder() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getPlaceholder() {
		return $this->concatenate();
	}
	
	public function showPlaceholder() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$count = count($this->label);
		for($i=0; $i<$count; ++$i) {
			$form = "";
			if($this->putDataInForm == true) {
				$form = new Form("POST", $this->action, false, "");
				$form->horizontalForm();
				if($this->dataIdName !== "") {
					$form->addHiddenInput($this->dataIdName, $this->linkIDs[$i], $this->linkIDs[$i]);
				} else {
					$form->addHiddenInput("class_id", $this->linkIDs[$i], $this->linkIDs[$i]);
				}
				if($this->dataName !== "") {
					$form->addHiddenInput($this->dataName, $this->label[$i], $this->label[$i]);
				} else {
					$form->addHiddenInput("class_name", $this->label[$i], $this->label[$i]);
				}
				$form->addSubmitButton($this->buttonNames, "btn btn-sm btn-warning");
				$form = $form->getForm();
			}
			
			if($this->is_odd($i)) {
				$image = "class= 'placeholder' id='roundCircleOrange'";
			} else {
				$image = "class= 'placeholder' id='roundCircleBlue'";
			}

			$j = $i+1;
			$a = $this->view->makeTextWrap("h5", "", "Class: " . $j);
			$image = $this->view->makeDiv($image, $a);
			$image = $image . "<h4>" . $this->label[$i] . "</h4>";
			$image = $image . "<p class='text-muted'>" . $this->subtext[$i] . "</p><div class='pull-right' style='padding-right:30px'>" . $form . "</div>";
			$this->imagesRow .= $this->view->makeDiv(self::PLACEHOLDER_WRAP, $image);
		}
		
		return $this->imagesRow = $this->view->makeDiv(self::ROW_PLACEHOLDERS, $this->imagesRow);
	}
	
	private function is_odd($i) {
		if(is_integer($i/2)) {
			return false;
		} else return true;
	}
	
}

?>