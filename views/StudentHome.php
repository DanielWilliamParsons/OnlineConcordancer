<?php  //  ../views/StudentHome.php

require_once 'elements/HTMLElement.php';
require_once 'elements/Head.php';
require_once 'elements/SidebarNav.php';
require_once 'elements/SidebarSingleLayout.php';
require_once 'StudentNavigation.php';
require_once 'elements/Form.php';

class StudentHomeView {

	public function __construct($userName, $userID, $viewData = "") {
		$this->userName = $userName;
		$this->userID = $userID;
		$this->viewData = $viewData;
		
		//need to include sidebar link urls
		$this->sidebar['Corpus Page'] = "index.php?controller=Corpus&action=index";
		$this->sidebar['My Classes'] = "";
	}
	
	public function index() {
		
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class.
		$this->createNavbarAndHeader();
		
		$sidebar = new SidebarNav($this->sidebar);
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), "Other stuff", "HELLO");
		$mainpage->makeSidebarSingleLayout();
	}
	
	private function createHeader() {
		$head = new Head(STUDENT_HOME);
		//Add fonts
		$fonts = array(MAVEN_PRO, LUSTRIA);
		$head->addFonts($fonts, "stylesheet", "text/css");
		
		//Add javascript
		$javascript = array(JQUERY, MODERNIZER, MODAL, TOOLTIP, DROPDOWN, POPOVER, COLLAPSE, TRANSITION, HOLDER, TINYMCE, JQUERYUI);
		$head->addJavascript($javascript, "");
		$head->addJavascript("js/main.js", "text/javascript");
		$head->addJavascript("js/ClassAdmin.js", "text/javascript");
		
		//Add stylesheets
		$stylesheets = array(BOOTSTRAP_MIN, BOOTSTRAP_THEME_MIN, JQUERY_STYLE, "css/sidebarSingleLayout.css");
		$head->addStylesheet($stylesheets);
		$head->compileHeader(); //pushes to screenView.
	}
	
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView
		$navbar = new StudentNavigation("EnglishClass: " . $this->userName);
		$navbar->makeStudentNavigation('home');
	}
	
}

?>