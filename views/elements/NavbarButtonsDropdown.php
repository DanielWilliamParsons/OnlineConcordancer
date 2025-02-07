<?php //  ../views/elements/NavbarButtonsDropdown.php

/*

	---SUBCLASS---
	Adds dropdown menus to the buttons of NavbarButtons.php
	When constructing this class, must supply navbarHeader data for the parent and buttonsData for the parent.
	
	---DATA TYPES TO BE PROVIDED ON CONSTRUCTION---
	The data for the buttons should either be a string or an multidimensional array
	Multidimensional arrays should look like this:
		$buttonsData[0] = array("active", "http://www.google.com, "Click on me") - "active" is the class for the li
		$buttonsData[1] = array("", "http://www.google.co.jp, "I'm a different link");
	
	The data for the navbarHeader should look like this
		$navbarHeader[name] = "website name"
		$navbarHeader[link] = "homelink"
		$navbarHeader[toggle] = "true" or "false" for the option to collapse the navbar
		$navbarHeader[id] = "idname" to link the navbar id with the data toggle
	However, a string can be passed and a processNavbarHeaderData will change it to an array
	The array value will be determined by whether the string contains a name or a homelink
	If the string seems to contain a homelink with no name, then it will be discarded!
	
	dropdownData should be an array of arrays like so
		$dropdown[] = array("active", "#", "Great!");
		$dropdown[] = array("", "#", "Wonderful!");
		$dropdown[] = array("", "#", "Lovely!");
	
	dropdownName should be just a string for the name to appear on the button
	
	---METHODS---
	Currently, no methods exist to change the attributes outside of this class, but could easily be written since the properties are not private
	prepareNavbar(bool::false, bool::false) - if the first parameter is true then the dropdown menu will be prepared on the left; 
																- if the second parameter is true then the dropdown menu will be appended to the right side buttons
																This method needs re-writing to make it less repetitive - need to add a private method
	
	---PROCEDURE TO MAKE A NAVBAR---
	See the example at the bottom of this document.

*/

require_once "NavbarButtons.php";

class NavbarButtonsDropdown extends NavbarButtons {
	
	public function __construct($navbarHeader="", $buttonsData="", $dropdownData="", $dropdownName="") {
		parent::__construct($navbarHeader, $buttonsData);
		$this->dropdownData = $dropdownData;
		$this->dropdownName = $dropdownName;
		$this->dropdownPackage['li']['class'] = 'dropdown';
		$this->dropdownPackage['a']['href'] = '#';
		$this->dropdownPackage['a']['class'] = 'dropdown-toggle';
		$this->dropdownPackage['a']['data-toggle'] = 'dropdown';
		$this->dropdownPackage['b']['class'] = 'caret';
		$this->dropdownPackage['ul']['class'] = 'dropdown-menu';
		
		$this->rightDropdownData = "";
		$this->rightDropdownName = "";
	}
	
	public function prepareNavbar($dropdownIsLeft=false, $addToRightButtons=false) {
			
			if($addToRightButtons === false) {
				$htmlList = $this->HTMList($this->dropdownData);
				$buttonsData = parent::HTMLize(parent::getButtonsData());
			} else {
				$htmlList = $this->HTMList($this->rightDropdownData);
				$buttonsData = parent::getButtonsRightHTML();
			}
		
			$attributesString = "";
			foreach($this->dropdownPackage['b'] as $key=>$value) {
				$attributesString .= $key . "='" . $value . "' ";
				}
			$aContent = $addToRightButtons==false ? $this->dropdownName : $this->rightDropdownName;
			$aContent .= $this->getHTML()->makeTextWrap('b', $attributesString, "");
		
			$attributesString = "";
			foreach($this->dropdownPackage['a'] as $key=>$value) {
				$attributesString .= $key . "='" . $value . "' ";
				}
			$ahref = $this->getHTML()->makeTextWrap('a', $attributesString, $aContent);
		
			$attributesString = "";
			foreach($this->dropdownPackage['ul'] as $key=>$value) {
				$attributesString .= $key . "='" . $value . "' ";
				}
			$dropdownContent = $ahref . $this->getHTML()->makeTextWrap('ul', $attributesString, $htmlList);
	
			$attributesString = "";
			foreach($this->dropdownPackage['li'] as $key=>$value) {
				$attributesString .= $key . "='" . $value . "' ";
				}
			$dropdownCompleted = $this->getHTML()->makeTextWrap('li', $attributesString, $dropdownContent);

			if($dropdownIsLeft===true) {
				if($addToRightButtons === false) {
					parent::setButtonsHTML($dropdownCompleted . $buttonsData);
				} else {
					parent::setButtonsRightHTML($dropdownCompleted . $buttonsData);
				}
				
			} else {
				if($addToRightButtons === false) {
					parent::setButtonsHTML($buttonsData . $dropdownCompleted);
				} else {
					parent::setButtonsRightHTML($buttonsData . $dropdownCompleted);
				}
			}	
	}
	
	public function makeNavbarWithDropdown() {
		parent::makeNavbarWithHeader();
	}
	
	public function addButtonsRightData($buttonsRightData) {
		parent::addButtonsRightData($buttonsRightData); //Note this function automatically HTMLize's the data
	}
	
	public function addButtonsRightWithDropdownData($buttonsRightData, $buttonsDropdownRightData, $rightDropdownName, $dropdownIsLeft=true) {
		$this->rightDropdownName = $rightDropdownName;
		$this->rightDropdownData = $buttonsDropdownRightData;
		parent::addButtonsRightData($buttonsRightData);
		$this->prepareNavbar($dropdownIsLeft, true);
	}
	
	protected function HTMList($data) {
		$htmlString = "";
		foreach($data as $value) {
			
			if($value[2] !== "") {
					$a = $this->getHTML()->makeTextWrap("a", "href='$value[1]'", $value[2]);
					} else {
						$a = "";
						}
				
				if($value[0] !== "") {
					$htmlString .= $this->getHTML()->makeTextWrap("li", "class='$value[0]'", $a);
					} else {
						$htmlString .= $this->getHTML()->makeTextWrap("li", "", $a);
						}
		}
		return $htmlString;
	}
	
	protected function getHTML() {
		return parent::getHTML();
	}
}
/*
//Prepare the data for the button links
$data = array();
$data[] = array("active", "#", "Hello!");
$data[] = array("", "#", "Click Me!");
$data[] = array("", "#", "Wonder about me?");
$data2 = array();
$data2[] = array("active", "#", "Goodbye!");
$data2[] = array("", "#", "Bye!");
$data2[] = array("", "#", "See ya");
$dropdown = array();
$dropdown[] = array("active", "#", "Great!");
$dropdown[] = array("", "#", "Wonderful!");
$dropdown[] = array("", "#", "Lovely!");
$dropdownRight = array();
$dropdownRight[] = array("active", "#", "Aweful!");
$dropdownRight[] = array("", "#", "Terrrible!");
$dropdownRight[] = array("", "#", "Sneezy!");

//This is how to make a full navbar with three buttons on the left, three on the right, and dropdown buttons either side of them
$navData = array("Daniel", "http://www.google.co.uk", true, "togglemesilly");
$navBar = new NavbarButtonsDropdown($navData, $data, $dropdown, "Oh dear!");
$navBar -> prepareNavbar(false); //false here means the dropdown data will be on the right
$navBar->addButtonsRightWithDropdownData($data2, $dropdownRight, "Beat this", true); //true means "beat this" will be on the left
$navBar->addButtonsRightWithDropdownData("", $dropdown, "Poohead", false); //false means "poohead" will be on the right
$navBar->addButtonsRightData($dropdown);
$navBar->addButtonsRightData($dropdownRight);
$navBar -> makeNavbarWithDropdown();


$letsSee = View::instantiateView();
$out = $letsSee-> getScreenViewAsHTML();
echo htmlentities($out);
*/
//Silly testing
/*

*/

?>