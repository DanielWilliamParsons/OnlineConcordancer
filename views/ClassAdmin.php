<?php // ../views/ClassAdmin.php

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

class ClassAdminView {
	
	public function __construct($userName, $userID, $viewData = "") {
		$this->userName = $userName;
		$this->userID = $userID;
		$this->sidebar['Admin Panel'] = "classAdmin.php?controller=ClassAdmin&action=index";
		$this->sidebar['Create a Class'] = "classAdmin.php?controller=ClassAdmin&action=createClass";
		$this->sidebar['Add Students to Pool'] = "classAdmin.php?controller=ClassAdmin&action=addStudents";
		$this->sidebar['Corpus Work'] = "index.php?controller=Corpus&action=index";
		
		//add edit student buttons
		$this->sidebarEditStudents['Add students to a class'] = "classAdmin.php?controller=ClassAdmin&action=addStudentsToClass";
		$this->sidebarEditStudents['Message Students'] = "classAdmin.php?controller=ClassAdmin&action=messageStudents";
		
		$this->viewData = $viewData;
	}
	
	public function index() {
	
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Get the viewData and put into placeholders
		$placeholder = new Placeholder($this->viewData['classname'], $this->viewData['id'], $this->viewData['fileLink'], $this->viewData['active'],
										 true, "Go to class", "classManager.php?controller=ClassManager&action=index", "class_id");
		$placeholder = $placeholder->getPlaceholder(); //get the HTML - put it in the $mainpage later
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebar['Admin Panel'] = array('active', $this->sidebar['Admin Panel']);		
		$sidebar = new SidebarNav($this->sidebar);
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $placeholder, "Classes");
		$mainpage->makeSidebarSingleLayout();
		
	}
	
	public function createClass() {
	
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Create the form using a private method
		$createClassForm = $this->createClassForm();
		$view = View::instantiateView();
		$createClassForm = $view->makeDiv("class=' col-lg-offset-2 col-lg-8 col-md-10 col-sm-12 thumbnail' id='createClassForm'", $createClassForm);
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebar['Create a Class'] = array('active', $this->sidebar['Create a Class']);		
		$sidebar = new SidebarNav($this->sidebar);
		
		//Preare the mainpage, adding the sidebar and the form contents to the page
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $createClassForm, "Classes / Create");
		$mainpage->makeSidebarSingleLayout();
	}
	
	public function addStudents() {
		
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Create the form using a private method
		$addStudentForm = $this->createAddStudentForm();
		$view = View::instantiateView();
		$addStudentForm = $view->makeDiv("class=' col-lg-offset-2 col-lg-8 col-md-10 col-sm-12 thumbnail' id='createClassForm'", $addStudentForm);
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebar['Add Students to Pool'] = array('active', $this->sidebar['Add Students to Pool']);
		$sidebar = new SidebarNav($this->sidebar);
		$sidebar->addNavButtons($this->sidebarEditStudents);
		
		//Prepare the mainpage, adding the sidebar and the form contents to the page
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $addStudentForm, "Classes / Create Student Accounts");
		$mainpage->makeSidebarSingleLayout();
		
	}
	
	
	
	public function addStudentsToClass() {
		
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebar['Add Students to Pool'] = array('active', $this->sidebar['Add Students to Pool']);
		$sidebar = new SidebarNav($this->sidebar);
		$sidebar->addNavButtons($this->sidebarEditStudents);
		
		//Prepare the mainpage
		$mainpage = new SidebarOneUpTwoDown($sidebar->getSidebarNav(), "Hello.", "How are you?", "Hi!", "Classes / Add Students");
		$mainpage->makeSidebarOneUpTwoDown();
	}
	
	
	//This private function will create the header for all ClassAdmin pages
	private function createHeader() {
		$head = new Head(CLASS_ADMIN);
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
		$head->compileHeader(); //pushes to screenView
	}
	
	//This private function will create both the header and the navbar together
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView.
		$navbar = new TeacherNavigation("EnglishClass: " . $this->userName."'s Classes");
		$navbar->makeTeacherNavigation('home'); //The navbar is pushed to the screenView property
	}
	
	private function createClassForm() {
		
		$syllabusData = $this->viewData;
		if(empty($syllabusData)) {
			$syllabusData = array();
		}
		
		$createClassForm = new Form("", "", false, "id='myForm'");
		$createClassForm->horizontalForm();
		$createClassForm->addTextInput(false, "classname", "", 
						"Class Name", "100", "classname", "form-control", "", "Name", "");
		$createClassForm->addTextarea(false, "classDetails", "", "Class Details", "classDetails",
											"", "5", "", "Details");
		$createClassForm->addTextInput(false, "startdate", "", "Start Date", "", "startdate", "form-control", "", "Start Date", "");
		$createClassForm->addTextInput(false, "finishdate", "", "Finish Date", "", "finishdate", "form-control", "", "Finish Date", "");
		$createClassForm->addCheckBoxes(array(false), array(true), 
					array("active"), array("y"), array("active"), array(""), array("Make class active"));
		$createClassForm->addSelectInput($syllabusData, false, "syllabus_data", "form-control", "syllabus_data", "", "Attach a Syllabus");
		$createClassForm->addTextInput(false, "file_link", "", "External Links as url", "", "file_link", "form-control", "", "Link", "");
		$view = View::instantiateView();
		$button = $view->makeTextWrap("button", "class='col-sm-offset-2 btn btn-sm btn-success' onclick='validateForm()'", "submit");
		return ($createClassForm->getForm() . $button);
	}
	
	private function createAddStudentForm() {
		$addStudentForm = new Form("", "", false, "id='myForm'");
		$addStudentForm->horizontalForm();
		$addStudentForm->addTextInput(false, "studentname", "", "Name of your student", "100", "studentname", "form-control", "", "Student Name", "");
		$addStudentForm->addTextInput(false, "username", "", "Add a unique user name for the student", "100", "username", "form-control", "", "Username", " onBlur='checkUsername(this)'");
		//$addStudentForm->addMessageSpan("ajaxBack");
		$addStudentForm->addPasswordInput(false, "studentpassword1", "", "Choose a password for the student", "100", "studentpassword1", "form-control", "", "Password");
		$addStudentForm->addPasswordInput(false, "studentpassword2", "", "Re-write the password", "100", "studentpassword2", "form-control", "", "Password");
		$view = View::instantiateView();
		$button = $view->makeTextWrap("button", "class='col-sm-offset-2 btn btn-sm btn-success' id='go' onclick='validateAddStudent()'", "Add");
		return ($addStudentForm->getForm() . $button);
	}
	
	private function arandomThumbnail() {
		$content = "<div class='row'>
					<div class='col-sm-6 col-md-4'>
						<div class='placeholder'>
						<img data-src='../../doc-assets/js/holder.js/100x100/text:hello world'>
							<div class='caption'>
							<h3>Thumbnail label</h3>
							<p>...</p>
								<p><a href='#' class='btn btn-primary' role='button'>Button</a> <a href='#' class='btn btn-default' role='button'>Button</a></p>
								</div>
								</div></div></div>";
	}
}

?>