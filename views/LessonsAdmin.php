<?php

require_once 'elements/HTMLElement.php';
require_once 'elements/Head.php';
require_once 'TeacherNavigation.php';
require_once 'elements/SidebarNav.php';
require_once 'elements/SidebarSingleLayout.php';
require_once 'elements/SidebarDoubleLayout.php';
require_once 'elements/SidebarQuadPanelLayout.php';
require_once 'elements/SidebarTwoUpOneDown.php';
require_once 'elements/SidebarOneUpTwoDown.php';
require_once 'elements/Placeholder.php';
require_once 'elements/Form.php';
require_once 'elements/Table.php';

class LessonsAdminView {
	
	public function __construct($username, $userID, $viewDataOne = "", $viewDataTwo = "", $viewDataThree = "", $viewDataFour = "") {
		$this->username = $username;
		$this->userID = $userID;
		$this->sidebar['Lessons Admin Panel'] = "lessonsAdmin.php?controller=LessonsAdmin&action=index";
		$this->sidebar['Create a Syllabus'] = "lessonsAdmin.php?controller=LessonsAdmin&action=createSyllabus";
		$this->sidebar['Create a Lesson'] = "lessonsAdmin.php?controller=LessonsAdmin&action=createLesson";
		
		$this->viewDataOne = $viewDataOne;
		$this->viewDataTwo = $viewDataTwo;
		$this->viewDataThree = $viewDataThree;
		$this->viewDataFour = $viewDataFour;
		
		$this->toIndexPage = "<a role='button' href='lessonsAdmin.php?controller=LessonsAdmin&action=index' class='btn btn-sm btn-warning'>
									<span class='glyphicon glyphicon-arrow-left'></span></a>";
	}
	
	public function index() {
		$this->sidebar['Lessons Admin Panel'] = array('active', $this->sidebar['Lessons Admin Panel']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Design Lessons");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function createSyllabus() {
		$this->sidebar['Create a Syllabus'] = array('active', $this->sidebar['Create a Syllabus']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create A Syllabus");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function createLesson() {
		$this->sidebar['Create a Lesson'] = array('active', $this->sidebar['Create a Lesson']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create A Lesson");
		$mainpage->makeSidebarSingleLayout();
	}
	
	//This private function will create both the header and the navbar together
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView.
		$navbar = new TeacherNavigation("EnglishClass: " . $this->username."'s Classes");
		$navbar->makeTeacherNavigation('lessons'); //The navbar is pushed to the screenView property
	}
	
	//This private function will create the header for all ClassAdmin pages
	private function createHeader() {
		$head = new Head(LESSONS_ADMIN);
		//Add fonts
		$fonts = array(MAVEN_PRO, LUSTRIA);
		$head->addFonts($fonts, "stylesheet", "text/css");
		
		//Add javascript
		$javascript = array(JQUERY, MODERNIZER, MODAL, TOOLTIP, DROPDOWN, POPOVER, COLLAPSE, TRANSITION, HOLDER, TINYMCE, JQUERYUI);
		$head->addJavascript($javascript, "");
		$head->addJavascript("js/main.js", "text/javascript");
		$head->addJavascript("js/ClassManager.js", "text/javascript");
		//$head->addJavascript("js/ajax.js", "text/javascript");
		
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