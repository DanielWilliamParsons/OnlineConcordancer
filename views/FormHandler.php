<?php // ../views/ClassAdmin.php

require_once 'elements/HTMLElement.php';
require_once 'elements/Head.php';
require_once 'TeacherNavigation.php';
require_once 'elements/SidebarNav.php';
require_once 'elements/SidebarSingleLayout.php';
require_once 'elements/Placeholder.php';
require_once 'elements/Table.php';

class FormHandlerView {
	public function __construct($username, $userID, $viewMessage, $redirect="") {
		$this->sidebar['Admin Panel'] = "classAdmin.php?controller=ClassAdmin&action=index";
		$this->sidebar['Create a Class'] = "classAdmin.php?controller=ClassAdmin&action=createClass";
		$this->sidebar['Add Students to Pool'] = "classAdmin.php?controller=ClassAdmin&action=addStudents";
		$this->username = $username;
		$this->userID = $userID;
		$this->viewMessage = $viewMessage;
		$this->redirect = $redirect;
	}
	
	public function formHandleError() {
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Prepare the Sidebar Single Layout Screen
		$sidebar = $this->renderSidebar(); //Private method below.
		
		$view = View::instantiateView();
		
		//Prepare the form to add an announcement
		$message = $view->makeTextWrap("h3", "class='text-warning'", $this->viewMessage);
		$redirectButton = "<a role='button' href='" . $this->redirect . "' class='btn btn-sm btn-primary'>
									<span class='glyphicon glyphicon-refresh'></span></a>";
		
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(),  $message . $redirectButton, "Database Processing Error");
		$mainpage->makeSidebarSingleLayout();
	}
	
	//This private function will create both the header and the navbar together
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView.
		$navbar = new TeacherNavigation("EnglishClass: " . $this->username."'s Classes");
		$navbar->makeTeacherNavigation('home'); //The navbar is pushed to the screenView property
	}
	
	//This private function will create the header for all ClassAdmin pages
	private function createHeader() {
		$head = new Head(FORM_HANDLER);
		//Add fonts
		$fonts = array(MAVEN_PRO, LUSTRIA);
		$head->addFonts($fonts, "stylesheet", "text/css");
		
		//Add javascript
		$javascript = array(JQUERY, MODERNIZER, MODAL, TOOLTIP, DROPDOWN, POPOVER, COLLAPSE, TRANSITION, HOLDER, TINYMCE, JQUERYUI);
		$head->addJavascript($javascript, "");
		$head->addJavascript("js/main.js", "text/javascript");
		
		//Add stylesheets
		$stylesheets = array(BOOTSTRAP_MIN, BOOTSTRAP_THEME_MIN, JQUERY_STYLE, "css/sidebarSingleLayout.css");
		$head->addStylesheet($stylesheets);
		$head->compileHeader(); //pushes to screenView
	}
	
	private function renderSidebar() {
		$sidebar = new SidebarNav($this->sidebar);
		return $sidebar;
	}
}

?>