<?php  //  ../views/elements/NavbarButtons.php
/*
	---DATA TYPES
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
	
	---METHODS
	makeNavbarWithHeader - optional parameter. It is assumed that if a parameter is passed then it will be an array of data and would therefore need HTMLizing
	HTMLize means to parse the data in the array into HTML. However, this class is designed with subclassing in mind, so it is unlikely that any parameter will be passed
	I have just left it in as an option in case the subclass later becomes unnecessary.
	
	The same is true for makeNavbarWithNoHeader
	
	There is a method to add buttons to the right of the navbar. This is not set up during the construction and is left as an option for the user to include with the method
	addButtonsRightHTML
	
Procedure to add buttons
//Prepare the data for the button links
$data = array();
$data[] = array("active", "#", "Hello!");
$data[] = array("", "#", "Click Me!");
$data[] = array("", "#", "Wonder about me?");
$data2 = array();
$data2[] = array("active", "#", "Goodbye!");
$data2[] = array("", "#", "Bye!");
$data2[] = array("", "#", "See ya");

//This is how to make a full navbar with three buttons on the left, three on the right, and dropdown buttons either side of them
$navBrandData = array("Daniel", "http://www.index.php", true, "togglemesilly");
$navBar = new NavbarButtons($navBrandData, $data); //add the left buttons
$navBar->addButtonsRightData($data2); //add the right buttons as an array - array will get HTMLized.
$navBar->makeNavbarWithHeader(); //Calls the parent method makeNavbar() which send the navbar to the HTMLElement's screenView
	
*/
require_once "Navbar.php";
class NavbarButtons extends Navbar {
	
	private $buttonsData;
	
	public function __construct($navbarHeader="", $buttonsData="") {
		parent::__construct();
		if($navbarHeader === "") {
			$this->navbarHeader['name'] = "";
			$this->navbarHeader['link'] = "";
			$this->navbarHeader['toggle'] = "";
			$this->navbarHeader['id'] = "";
		} else {
			$navbarHeader = $this->processNavbarHeaderData($navbarHeader);
			$this->navbarHeader['name'] = $navbarHeader[0];
			$this->navbarHeader['link'] = $navbarHeader[1];
			$this->navbarHeader['toggle'] = $navbarHeader[2];
			$this->navbarHeader['id'] = $navbarHeader[3];
		}
		$this->buttonsData = $buttonsData;
		$this->buttonsHTML = "";
		$this->buttonsRightHTML = "";
	}
	
	protected function getButtonsData() {
		return $this->buttonsData;
	}
	
	protected function setButtonsData($buttonsData) {
		$this->buttonsData = $buttonsData;
	}
	
	public function addButtonsRightData($buttonsRightData) {
		$this->addButtonsRightHTML($this->HTMLize($buttonsRightData));
	}
	
	public function setButtonsRightHTML($buttonsRightHTML) {
		$this->buttonsRightHTML = $buttonsRightHTML;
	}
	
	protected function getButtonsRightHTML() {
		return $this->buttonsRightHTML;
	}
	
	protected function setButtonsHTML($buttonsHTML) {
		$this->buttonsHTML = $buttonsHTML;
	}
	
	protected function addButtonsHTML($buttonsHTML) {
		$this->buttonsHTML .= $buttonsHTML;
	}
	
	protected function addButtonsRightHTML($buttonsRightHTML) {
		$this->buttonsRightHTML .= $buttonsRightHTML;
	}
	
	/*
		---These next two methods add a navbar using raw data,
		changing it into HTML first.
	*/
	public function makeNavbarWithHeader($buttonsData="") {
		parent::addNavbarHeader($this->navbarHeader['name'], $this->navbarHeader['link'], $this->navbarHeader['toggle'], $this->navbarHeader['id']);
		if($buttonsData==="") {
			$this->buttonsHTML = $this->wrapList($this->buttonsHTML);
			$this->buttonsRightHTML = $this->wrapListRight($this->buttonsRightHTML);
		} else {
			$this->buttonsHTML = $this->wrapList($this->HTMLize($buttonsData));
			$this->buttonsRightHTML = $this->wrapListRight($this->buttonsRightHTML);
		}
		parent::addMainNavbar($this->buttonsHTML . $this->buttonsRightHTML);
		parent::makeNavbar();
	}
	
	public function makeNavbarNoHeader($buttonsData="") {
		if($buttonsData==="") {
			$this->buttonsHTML = $this->wrapList($this->buttonsHTML);
			$this->buttonsRightHTML = $this->wrapListRight($this->buttonsRightHTML);
		} else {
			$this->buttonsHTML = $this->wrapList($this->HTMLize($buttonsData));
			$this->buttonsRightHTML = $this->wrapListRight($this->buttonsRightHTML);
		}
		parent::addMainNavbar($this->buttonsHTML . $this->buttonsRightHTML);
		parent::makeNavbar();
	}
	
	protected function wrapList($htmlStringList) {
		if($htmlStringList === "") {
			return "";
		}
		$htmlString = $this->getHTML()->makeTextWrap("ul", "class='nav navbar-nav'", $htmlStringList);
		return $htmlString;
	}
	
	protected function wrapListRight($htmlStringList) {
		$htmlString = $this->getHTML()->makeTextWrap("ul", "class='nav navbar-nav navbar-right'", $htmlStringList);
		return $htmlString;
	}
	
	/*
		---Change raw list data into HTML
	*/
	protected function HTMLize($data) {
		if(is_array($data)) {
			return $this->parseArrayOfLinks($data);
		} else {
			return $this->getHTML()->makeTextWrap("li", "class='active'", $data);
		}
	}
	
	private function parseArrayOfLinks($data) {
		$htmlString = "";
		
		foreach($data as $value) {
			if(count($value)==1) { //Some of the subclasses pass HTML strings so they don't need parsing
				$htmlString .= $value[0];
			} else {
		
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
		}
		return $htmlString;
	}
	
	protected function getHTML() {
		return parent::getHTML();
	}
	
	protected function processNavbarHeaderData($navbarHeader) {
	//print_r($navbarHeader);
		if(is_string($navbarHeader)) {
			$navbarHeaderData = array();
			if(strpos($navbarHeader, "/")!==false || strpos($navbarHeader, ".co")!==false) {
				array_push($navbarHeaderData, ""); //Discard the homelink because there is no name to attach the link.
																									//This has created a completely empty array, so no header will be attached
			} else {
				array_push($navbarHeaderData, $navbarHeader);
			}
			$navbarHeader = $navbarHeaderData;
		}
		
		$count = count($navbarHeader);
		for ($i=$count; $i<4; ++$i) {
			array_push($navbarHeader, "");
		}
		//print_r($navbarHeader);
		return $navbarHeader;
	}
	
}

?>