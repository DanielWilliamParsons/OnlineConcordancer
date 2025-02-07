<?php //  ../views/elements/Assignments.php
require_once 'elements/AssignmentsWrapper.php';
require_once 'elements/NavbarButtonsDropdown.php';
require_once 'elements/HTMLElement.php';
require_once 'elements/LinkedList.php';
require_once 'elements/Head.php';

/*
	---MAIN VIEW---
	This is the main view for the students' assignments page.
	This view uses the Iterator pattern to generate the nested view elements.
*/

class AssignmentsView {
	
	private $mainView;
	private $navbar;
	private $assignments;
	
	public function __construct() {
		$this->mainView = "";
		$this->navbar = "";
		$this->	assignments[0]['topTitle'] = "Title";
		$this->assignments[0]['content'] = "This is some content";
		$this->assignments[0]['bottom'] = "This is yet to be decided what will go in here - stats about performance and links probably";
		$this->	assignments[1]['topTitle'] = "Title 2";
		$this->assignments[1]['content'] = "This is some more content";
		$this->assignments[1]['bottom'] = "Probably a tonne of stat stuff";
		$this->	assignments[2]['topTitle'] = "<a href='index.php?controller=home&action=index'>Title 3</a>";
		$this->assignments[2]['content'] = "This is some content baby";
		$this->assignments[2]['bottom'] = "Bottom stuff";
		$this->	assignments[3]['topTitle'] = "Title 4";
		$this->assignments[3]['content'] = "More content generated here!";
		$this->assignments[3]['bottom'] = "Bottom stuff";
		$this->	assignments[4]['topTitle'] = "Title 5";
		$this->assignments[4]['content'] = "Even more content generated here!";
		$this->assignments[4]['bottom'] = "Bottom stuff yes";
		$this->	assignments[5]['topTitle'] = "Title 6";
		$this->assignments[5]['content'] = "Here is an essay that I feel like writing. Please tell me what you think of this essay because it is going to be very important for me!";
		$this->assignments[5]['bottom'] = "Bottom stuff again.";
		$this->navData = array("Daniel", "http://www.google.co.uk", true, "togglemesilly");
		$this->data[0] = array("active", "#", "Hello!");
		$this->data[1] = array("", "#", "Click Me!");
		$this->data[2] = array("", "#", "Wonder about me?");
		$this->dropdown[0] = array("active", "#", "Great!");
		$this->dropdown[1] = array("", "#", "Wonderful!");
		$this->dropdown[2] = array("", "#", "Lovely!");
	}
	
	public function createView($toolbox) {
		$header = new Head(ASSIGNMENTS_HEADER);
		$header->addJavascript("js/main.js");
		$header->addFonts("http://fonts.googleapis.com/css?family=Lustria", "stylesheet", "text/css");
		$header->addFonts("http://fonts.googleapis.com/css?family=Maven+Pro:400,500", "stylesheet", "text/css");
		$header->addJavascript("http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");
		$header->addJavascript("js/tooltip.js");
		$header->addJavascript("js/dropdown.js");
		$header->addJavascript("js/popover.js");
		$header->addJavascript("js/collapse.js");
		$header->addJavascript("js/transition.js");
		$header->addStylesheet("css/bootstrap.min.css");
		$header->addStylesheet("css/bootstrap-theme.min.css");
		$header->addStylesheet("css/mycss.css");
		$header->addJavascript("js/vendor/modernizr-2.6.2-respond-1.1.0.min.js");
		$header->addJavascript("js/tab.js");
		$header->compileHeader();
		$navbar = new NavbarButtonsDropDown($this->navData, $this->data, $this->dropdown, "Dropdown Menu");
		$navbar->prepareNavbar(false);
		$navbar->makeNavbarWithDropdown();
		$mainpageCreator = new AssignmentsWrapper($this->assignments);
		while($mainpageCreator != null) {
			$mainpageCreator->makeContent($toolbox);
			$mainpageCreator = $mainpageCreator->nextContent();
		}
	}
}
?>