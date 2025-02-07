<?php //  ..//views/elements/Navbar.php
/*
	---BASE CLASS FOR THE NAVBAR---
	
	---Properties---
	VIEW - (class View) creates an instance of View - used to create HTML elements
	navAttributes - (array) the attributes for the main containers of the navbar;
	collapsibleAttributes - (array) the attributes which link to CSS bootstrap calling collapsible behaviour on mobile devices
	navbarCollapse - (array) what the navbar will look like when it is collapsed.
	navbarCollapseIcon - (array) the icon added to the buttons when the navbar is collapsed
	innerHTML - (string) a property of the navbar which is built from the root of the HTML file; it gradually gets concatenated recursively to build the navbar
	
	---Methods---
	makeNavbar() : calls the innerHTML property and concatenates to a string, then pushes to the VIEW to build the navbar
	addNavbarHeader($brand="", $homeLink="", $addCollapseToggle, $dataTargetID="") : add a brand at the top left corner of the navbar.
			Also add dataTargetID so that the collapsible part of the navbar can be connected to the buttons which show when collapsed.
	addMainNavbar($HTMLString) : any subclass using this method must supply an HTML string. The above addNavbarHeader will have set the collapsibleAttributes[id] value,
			so these attributes can now be concatenated. The method then continues to wrap the attributes in a div string calling a method on the View class's instance property.
			This is added to the innerHTML property.
	
*/

abstract class Navbar {
	public function __construct() {
		$this->VIEW = View::instantiateView();
		//The main navbar
		$this->navAttributes['div']['class'] = 'container-fluid';
		$this->navAttributes['nav']['class'] = 'navbar navbar-default navbar-fixed-top';
		$this->navAttributes['nav']['role'] = 'navigation';
		//The collapsible container
		$this->collapsibleAttributes['collapsible_container']['class'] = 'collapse navbar-collapse';
		$this->collapsibleAttributes['collapsible_container']['id'] = ''; //Should be provided by the user in addNavbarHeader method
		//The collapsed button
		$this->navbarCollapse['button']['type'] = 'button';
		$this->navbarCollapse['button']['class'] = 'navbar-toggle';
		$this->navbarCollapse['button']['data-toggle'] = 'collapse';
		$this->navbarCollapse['button']['data-target'] = ''; //Should be provided by the user in addNavbarHeader method
		//The collapsed icon
		$this->navbarCollapseIcon[0] = 'sr-only';
		$this->navbarCollapseIcon[1] = 'icon-bar';
		$this->innerHTML = "";
	}
	
	protected function makeNavbar() {
		$navbar = $this->innerHTML;
		foreach($this->navAttributes as $navPartName=>$navPart) {
			$navAttributes = "";
			foreach($navPart as $key=>$value) {
				if($value === "") {
					$navAttributes .= "";
				} else {
					$navAttributes .= $key . "='" . $value . "' ";
				}		
			}
			$navbar = $this->getHTML()->makeTextWrap($navPartName, $navAttributes, $navbar);
		}
		$this->pushScreenView($navbar);
	}
	
	protected function setInnerHTML($innerHTML) {
		$this->innerHTML = $innerHTML;
	}
	
	protected function addInnerHTML($innerHTML) {
		$this->innerHTML .= $innerHTML;
	}
	
	protected function addNavbarHeader($brand="", $homeLink="", $addCollapseToggle, $dataTargetID="") {
		$this->setdataTargets($dataTargetID);
		$toggleButton = "";
		
		if($addCollapseToggle === true) {
			//Make the icon
			$icon = $this->getHTML()->makeTextWrap("span", "class='" . $this->navbarCollapseIcon[0] . "' ", "Toggle Navigation");
			for($i=0; $i<=2; ++$i) {
				$icon .= $this->getHTML()->makeTextWrap("span", "class='" . $this->navbarCollapseIcon[1] . "' ", "");
			}
		
			//Make the button for the icon
			$buttonAttributes = $this->navbarCollapse;
			$attributeString = "";
			foreach($buttonAttributes['button'] as $key=>$value) {
				$attributeString .= $key . "='" . $value . "' ";
			}
			$toggleButton .= $this->getHTML()->makeTextWrap("button", $attributeString, $icon);
		}
		
		//Make the home link for the webpage title
		if($homeLink === "") {
			$homeLink = "#";
		}
		$brandName = $this->getHTML()->makeTextWrap("a", "class='navbar-brand', href='$homeLink'", $brand);
		
		//Make the header container and add it to the innerHTML property.
		$navbarHeader = $this->getHTML()->makeDiv("class='navbar-header'", $toggleButton . $brandName);
		$this->addInnerHTML($navbarHeader);
	}
	
	//Subclasses which create the main navbar must supply the HTML string, not the data values as an array.
	protected function addMainNavbar($navbarHTMLString) {
		$mainNavbarAttributes = "";
		foreach($this->collapsibleAttributes['collapsible_container'] as $key=>$value) {
			$mainNavbarAttributes .= $key . "='" . $value . "' ";
		}
		$mainNavbar = $this->getHTML()->makeDiv($mainNavbarAttributes, $navbarHTMLString);
		$this->addInnerHTML($mainNavbar);
	}
	
	/*
		---Semantics---
		The reason the method below wasn't called getView() was because it seems to mean
		that it returns the instance variable screenView from the singleton View class.
		However, getting THIS class's instance variable (View class) in most cases is about
		processing HTML script. Therefore, getHTML() seems a more intuitive name
		for this method.
		
		---Coding---
		The other option was to create a separate class called BaseView
		However, this would mean tracking and concatenating code for each part of the
		final view which might later be unwieldy. The point of this is to have a place to store
		the whole view, the final HTML script output to the user.
		A singleton class with an instance variable for the script seems perfect for the job!
	*/
	protected function getHTML() {
		return $this->VIEW;
	}
	
	protected function pushScreenView($screenView) {
		if(is_array($screenView)) {
			$this->getHTML()->pushArraytoScreenView($screenView);
		} elseif(is_string($screenView)) {
			$this->getHTML()->pushHTMLtoScreenView($screenView);
		}
	}
	
	/*
		---SUBCLASSING---
			These protected methods allow for subclassing
			Subclassing allows for the user to change the styles of the navbar
			By setting and getting classes
	*/
	
	protected function setNavAttributesWithArray($array) {
		$this->navAttributes = $array;
	}
	
	protected function addNavAttributes($navPart, $className, $value) {
		$this->navAttributes[$navPart][$className] = $value;
	}
	
	protected function setdataTargets($id) {
		$this->collapsibleAttributes['collapsible_container']['id'] = $id;
		$this->navbarCollapse['button']['data-target'] = $id;
	}
	
	/*
		---HELPER FUNCTIONS---
			The data needs to be examined to see what it comprises.
			These helper functions will help determine whether the data needs cleaning
			or whether it can be passed as is.
	*/
	
}

?>