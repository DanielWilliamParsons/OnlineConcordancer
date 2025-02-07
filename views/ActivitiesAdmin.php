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

class ActivitiesAdminView {
	
	public function __construct($username, $userID, $viewDataOne = "", $viewDataTwo = "", $viewDataThree = "", $viewDataFour = "") {
		$this->username = $username;
		$this->userID = $userID;
		$this->sidebar['Create Activities'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=index";
		$this->sidebar['My Activities'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=myActivities";

		$this->sidebarActivities['Assignment'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=addAssignment";
		$this->sidebarActivities['Multiple Choice Quiz'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=addMultiChoiceQuiz";
		$this->sidebarActivities['Gap Fill Activity'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=addGapFillActivity";
		$this->sidebarActivities['Guided Exercise'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=addGuidedExercise";
		$this->sidebarActivities['DDL Exercise'] = "activitiesAdmin.php?controller=ActivitiesAdmin&action=addDDLExercise";
		
		$this->viewDataOne = $viewDataOne;
		$this->viewDataTwo = $viewDataTwo;
		$this->viewDataThree = $viewDataThree;
		$this->viewDataFour = $viewDataFour;
		
		$this->toIndexPage = "<a role='button' href='activitiesAdmin.php?controller=LessonsAdmin&action=index' class='btn btn-sm btn-warning'>
									<span class='glyphicon glyphicon-arrow-left'></span></a>";
	}
	
	public function index() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function myActivities() {
		$this->sidebar['My Activities'] = array('active', $this->sidebar['My Activities']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Manage Your Activities");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addAssignment() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->sidebarActivities['Assignment'] = array('active', $this->sidebarActivities['Assignment']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities / Assignment");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addMultiChoiceQuiz() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->sidebarActivities['Multiple Choice Quiz'] = array('active', $this->sidebarActivities['Multiple Choice Quiz']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities / MCQ");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addGapFillActivity() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->sidebarActivities['Gap Fill Activity'] = array('active', $this->sidebarActivities['Gap Fill Activity']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities / Gap Fill");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addGuidedExercise() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->sidebarActivities['Guided Exercise'] = array('active', $this->sidebarActivities['Guided Exercise']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities / Guided Exercise");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addDDLExercise() {
		$this->sidebar['Create Activities'] = array('active', $this->sidebar['Create Activities']);
		$this->sidebarActivities['DDL Exercise'] = array('active', $this->sidebarActivities['DDL Exercise']);
		$this->createNavbarAndHeader();
		$sidebar = $this->renderSidebar();
		$sidebar->addNavButtons($this->sidebarActivities);
		$data = $this->viewDataOne;
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $data, "Create Activities / DDL Exercise");
		$mainpage->makeSidebarSingleLayout();
	}
	
	//This private function will create both the header and the navbar together
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView.
		$navbar = new TeacherNavigation("EnglishClass: " . $this->username."'s Classes");
		$navbar->makeTeacherNavigation('activities'); //The navbar is pushed to the screenView property
	}
	
	//This private function will create the header for all ClassAdmin pages
	private function createHeader() {
		$head = new Head(ACTIVITIES_ADMIN);
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