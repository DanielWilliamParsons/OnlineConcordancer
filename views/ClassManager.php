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
require_once 'elements/Table.php';

class ClassManagerView {
	
	const RedirectDeleteAnnouncement = "classManager.php?controller=ClassManager&action=editAnnouncement";
	const RedirectEditAnnouncement = "classManager.php?controller=ClassManager&action=editAnnouncement";
	
	public function __construct($username, $userID, $classDetails, $viewDataOne = "", $viewDataTwo = "", $viewDataThree = "", $viewDataFour = "") {
		$this->username = $username;
		$this->userID = $userID;
		$this->classDetails = $classDetails;
		$this->sidebar['Admin Panel'] = "classAdmin.php?controller=ClassAdmin&action=index";
		$this->sidebar['Create a Class'] = "classAdmin.php?controller=ClassAdmin&action=createClass";
		$this->sidebar['Add Students to Pool'] = "classAdmin.php?controller=ClassAdmin&action=addStudents";
		
		//add announcement buttons
		$this->sidebarAnnouncements['Add Announcement'] = "classManager.php?controller=ClassManager&action=addAnnouncement";
		$this->sidebarAnnouncements['Edit Announcement'] = "classManager.php?controller=ClassManager&action=editAnnouncement";
		
		//add student register buttons
		$this->sidebarStudentRegister['Register a Student'] = "classManager.php?controller=ClassManager&action=studentRegister";
		$this->sidebarStudentRegister['Remove a Student'] = "classManager.php?controller=ClassManager&action=removeStudent";
		
		//add lessons and syllabus
		$this->sidebarLessons['Add a Lesson'] = "classManager.php?controller=ClassManager&action=addLesson";
		$this->sidebarLessons['Remove a Lesson'] = "classManager.php?controller=ClassManager&action=removeLesson";
		$this->sidebarLessons['Add a Syllabus'] = "classManager.php?controller=ClassManager&action=addSyllabus";
		$this->sidebarLessons['Remove a Syllabus'] = "classManager.php?controller=ClassManager&action=removeSyllabus";
		
		//go to class
		$this->sidebarClass['During class'] = "classManager.php?controller=ClassManager&action=duringClass";
		$this->sidebarClass['Check Student Work'] = "classManager.php?controller=ClassManager&action=checkStudentWork";
		
		$this->viewDataOne = $viewDataOne;
		$this->viewDataTwo = $viewDataTwo;
		$this->viewDataThree = $viewDataThree;
		$this->viewDataFour = $viewDataFour;
		
		$this->toIndexPage = "<a role='button' href='classManager.php?controller=ClassManager&action=index' class='btn btn-sm btn-warning'>
									<span class='glyphicon glyphicon-arrow-left'></span></a>";
	}
	
	
	public function index() {
	
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		
		//Prepare the Sidebar Single Layout Screen
		$sidebar = $this->renderSidebar(); //Private method below
		
		$data = $this->classDetails['class_id'];
		$header = "Classes / " . $this->classDetails['class_name'];
		$mainpage = new SidebarQuadPanelLayout($sidebar->getSidebarNav(), $data, $this->viewDataOne, $data, $data, $header);
		$mainpage->makeSidebarQuadPanelLayout();
		
	}
	
	
	//View for announcements
	public function addAnnouncement() {
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Prepare the Sidebar Single Layout Screen
		$this->	sidebarAnnouncements['Add Announcement'] = array('active', $this->sidebarAnnouncements['Add Announcement']);
		$sidebar = $this->renderSidebar(); //Private method below.
		
		$view = View::instantiateView();
		$indexButton = $view->makeDiv("class='col-lg-8 col-md-10 col-sm-12' style='margin-bottom:12px;'", $this->toIndexPage); //Sends user back to the index() action page
		
		//Prepare the form to add an announcement
		$announcementForm = $view->makeDiv("class='col-lg-8 col-md-10 col-sm-12 thumbnail' id='createClassForm'", $this->createAddAnnouncementForm());
		
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $indexButton . $announcementForm, $this->classDetails['class_name'] . ": Announcement");
		$mainpage->makeSidebarSingleLayout();
	}
	
	
	//Delete an announcement from the list
	//$viewDataOne should look like this for the header of a table
	//$header[1] = array("headersecond1", "headersecond2", "headersecond3", "headersecond4", "headersecond5")
	//$viewDataTwo should look like this for the body rows of a table
	//$rowData[0] = array("date"=>"data1", "title"=>"data2", "announcement"=>"data3", "deleteForm"=>"data4", "editForm"=>"data5");
	//$rowData[1] = array(array("date"=>"data9", "title"=>"data10", "announcement"=>"data11", "deleteForm"=>"data12", "editForm"=>"data13"), $rowStyle1);  ---style the row
	public function editAnnouncement() {
		$announcementsData = $this->viewDataTwo;
		
		$tableData = array();
		$j = 0; //this will be used as id fodder on the hidden elements of the editAnnouncementForm
		foreach($announcementsData as $announcement) {
			$deleteForm = $this->makeDeleteAnnouncementForm($announcement['announcement_id'], $announcement['class_id'], self::RedirectDeleteAnnouncement);
			$editForm = $this->makeEditAnnouncementForm($announcement['announcement_id'], $announcement['class_id'], self::RedirectEditAnnouncement, $j);
			$tableData[] = array($announcement['date'], 
								$announcement['title'], 
								$announcement['announcement'], 
								$deleteForm, 
								$editForm);
			++$j;
		}
		$tableType = array(Table::ClassTable, Table::ClassTableBordered, Table::ClassTableStriped, Table::ClassTableHover);
		$table = new Table($tableData, $this->viewDataOne, $tableType, true);
		$table = $table->getTable();
		
		//Now append a div to the table so that the edit form has somewhere to pop into.
		$view = View::instantiateView();
		$table = $table . $view->makeDiv("class='' id='popEditForm'", "");
		
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebarAnnouncements['Edit Announcement'] = array('active', $this->sidebarAnnouncements['Edit Announcement']);
		$sidebar = $this->renderSidebar(); //Private method below.
		
		$indexButton = $view->makeDiv("class='col-lg-8 col-md-10 col-sm-12' style='margin-bottom:12px;'", $this->toIndexPage); //Sends user back to the index() action page
		
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $indexButton . $table, $this->classDetails['class_name'] . ": Edit Announcements");
		$mainpage->makeSidebarSingleLayout();
		
	}
	
	public function noAnnouncements() {
		//Prepare the header and navbar and send them to the screenView property of HTMLElement
		//This method is a private method of this class
		$this->createNavbarAndHeader();
		
		//Prepare the Sidebar Single Layout Screen
		$this->sidebarAnnouncements['Edit Announcement'] = array('active', $this->sidebarAnnouncements['Edit Announcement']);
		$sidebar = $this->renderSidebar(); //Private method below.
		
		$view = View::instantiateView();
		$indexButton = $view->makeTextWrap("span", "style='margin-bottom:12px;'", $this->toIndexPage); //Sends user back to the index() action page
		
		//No announcements message section
		$message = $view->makeTextWrap("h3", "class='text-warning' style='margin-bottom:12px;'", $this->viewDataOne);
		
		$mainpage = new SidebarSingleLayout($sidebar->getSidebarNav(), $indexButton . $message, $this->classDetails['class_name'] . ": Edit Announcements");
		$mainpage->makeSidebarSingleLayout();
	}
	
	//Views for the student register
	public function studentRegister() {
		$this->createNavbarAndHeader();
		
		$redirect = "classManager.php?controller=ClassManager&action=studentRegister";
		
		$studentList = $this->viewDataOne;
		$classList = $this->viewDataTwo;
		
		//Make student list table - contains data of all students not yet in the class
		$tableStudents = $this->makeStudentListTable($studentList, "Add Students To This Class", $redirect);
		
		//Make a class list table - contains data of all students currently registered in the class
		$tableClass = $this->makeStudentListTable($classList, "Remove Students From This Class", $redirect);
		
		//Prepare the Sidebar Double Layout Screen
		$this->sidebarStudentRegister['Register a Student'] = array('active', $this->sidebarStudentRegister['Register a Student']);
		$sidebar = $this->renderSidebar();
		
		$view = View::instantiateView();
		$indexButton = $view->makeTextWrap("span", "style='margin-bottom:12px;'", $this->toIndexPage); //Sends user back to the index() action page
																										//Don't forget to put the index button into the view somewhere!
																										//Note also that Firefox is having problems rendering the indexButton with a table under it!!!
																										//Firefox is as stupid as IE sometimes.
																										
		$mainpage = new SidebarDoubleLayout($sidebar->getSidebarNav(), $tableStudents, $tableClass, $this->classDetails['class_name'] . ": Register/Remove Students");
		$mainpage->makeSidebarDoubleLayout();
		
	}
	
	//This private function will create both the header and the navbar together
	private function createNavbarAndHeader() {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView.
		$navbar = new TeacherNavigation("EnglishClass: " . $this->username."'s Classes");
		$navbar->makeTeacherNavigation('home'); //The navbar is pushed to the screenView property
	}
	
	//This private function will create the header for all ClassAdmin pages
	private function createHeader() {
		$head = new Head(CLASS_MANAGER);
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
		$this->sidebar['Admin Panel'] = array('active', $this->sidebar['Admin Panel']);
		$sidebar = new SidebarNav($this->sidebar);
		$sidebar->addNavButtons($this->sidebarAnnouncements);
		$sidebar->addNavButtons($this->sidebarStudentRegister);
		$sidebar->addNavButtons($this->sidebarLessons);
		$sidebar->addNavButtons($this->sidebarClass);
		return $sidebar;
	}
	
	private function makeStudentListTable($studentList, $label, $redirect) {
		$vars = get_object_vars($this); //help to decide which property is being sent to this method
		$headerStudentList = array();
		$headerStudentList[] = array($label);
		$j = 0; //this will be used as id fodder on the hidden elements of the editAnnouncementForm
		if(!empty($studentList)) {
			foreach($studentList as $student_id=>$studentName) {
				if($studentList == $vars['viewDataOne']) {
					$studentListForm = $this->makeStudentList($studentName, $student_id, $redirect);
				} else if ($studentList == $vars['viewDataTwo']) {
					$studentListForm = $this->makeClassList($studentName, $student_id, $redirect);
				}
				$studentListTableData[] = array($studentName . $studentListForm);
				++$j;
			}
			
			$tableType = array(Table::ClassTable, Table::ClassTableBordered, Table::ClassTableStriped, Table::ClassTableHover);
			$tableStudents = new Table($studentListTableData, $headerStudentList, $tableType, true);
			return $tableStudents = $tableStudents->getTable();
			
		} else {
			if($studentList == $vars['viewDataOne']) {
				return $tableStudents = "<h4 class='text-primary'>There are no students in your pool.</h4>";
			} else if ($studentList == $vars['viewDataTwo']) {
				return $tableStudents = "<h4 class='text-primary'>There are no students in this class yet.</h4>";
			}

		}
	}
	
	private function createAddAnnouncementForm() {
		$addAnnouncementForm = new Form("", "", false, "id='myForm'");
		$addAnnouncementForm->horizontalForm();
		$addAnnouncementForm->addTextInput(false, "announcement_title", "", "Announcement Title", "30", "announcement_title", "form-control", "", "Title", "");
		$addAnnouncementForm->addTextarea($disabled=false, "announcement", "", "Write your announcement here", "announcement", "form-control", "3", "", "Announcement");
		$addAnnouncementForm->addHiddenInput("class_id", "class_id", $this->classDetails['class_id']);
		$addAnnouncementForm->addHiddenInput("t_id", "t_id", $this->userID);
		$view = View::instantiateView();
		$button = $view->makeTextWrap("button", "class='col-sm-offset-2 btn btn-sm btn-warning' id='go' onclick='validateAddAnnouncement()'", "Add");
		return ($addAnnouncementForm->getForm() . $button);
	}
	
	private function makeDeleteAnnouncementForm($data1, $data2, $redirect) {
		$deleteForm = new Form("POST", "formHandler.php", false, "id='deleteForm'");
		$deleteForm->horizontalform();
		$deleteForm->addHiddenInput("announcement_id", "delete1", $data1);
		$deleteForm->addHiddenInput("class_id", "delete2", $data2);
		$deleteForm->addHiddenInput("controller", "controller", "FormHandler");
		$deleteForm->addHiddenInput("action", "action", "deleteAnnouncement");
		$deleteForm->addHiddenInput("redirect", "redirect", $redirect); //re-direct url 
		$glyphicon = "<span class='glyphicon glyphicon-trash'></span>";
		$deleteForm->addSubmitButton($glyphicon, "btn btn-sm btn-warning", "delete");
		return $deleteForm->getForm();
	}
	
	private function makeEditAnnouncementForm($data1, $data2, $redirect, $hiddenIDs) { //hiddenIDs are needed for the javascript to create edit forms dynamically
		$editForm = new Form("", "", false, "id='editForm'");
		$editForm -> horizontalform();
		$editForm->addHiddenInput("announcement_id", "announcement" . $hiddenIDs, $data1);
		$editForm->addHiddenInput("class_id", "class_id" . $hiddenIDs, $data2);
		$editForm->addHiddenInput("redirect", "redirect" . $hiddenIDs, $redirect); //re-direct url 
		$glyphicon = "<span class='glyphicon glyphicon-pencil'></span>";
		$view = View::instantiateView();
		$button = $view->makeTextWrap("button", "class='btn btn-sm btn-warning' id='go' onclick='editAnnouncement(this)'", $glyphicon);
		return $editForm->getForm().$button;
	}
	
	private function makeStudentList($studentName, $studentID, $redirect) {
		$listForm = new Form("POST", "formHandler.php", false, "id='studentListForm'");
		$listForm->horizontalform();
		$listForm->addHiddenInput("student_id", "student_id", $studentID);
		$listForm->addHiddenInput("studentName", "studentName", $studentName);
		$listForm->addHiddenInput("class_id", "class_id", $this->classDetails['class_id']);
		$listForm->addHiddenInput("controller", "controller", "FormHandler");
		$listForm->addHiddenInput("redirect", "redirect", $redirect);
		$listForm->addHiddenInput("action", "action", "addStudentToClass");
		$glyphicon = "<span class='glyphicon glyphicon-arrow-right'></span>";
		$listForm->addSubmitButton($glyphicon, "btn btn-sm btn-warning", "");
		return $listForm->getForm();
	}
	
	private function makeClassList($studentName, $studentID, $redirect) {
		$listForm = new Form("POST", "formHandler.php", false, "id='studentListForm'");
		$listForm->horizontalform();
		$listForm->addHiddenInput("student_id", "student_id", $studentID);
		$listForm->addHiddenInput("studentName", "studentName", $studentName);
		$listForm->addHiddenInput("class_id", "class_id", $this->classDetails['class_id']);
		$listForm->addHiddenInput("controller", "controller", "FormHandler");
		$listForm->addHiddenInput("redirect", "redirect", $redirect);
		$listForm->addHiddenInput("action", "action", "removeStudentFromClass");
		$glyphicon = "<span class='glyphicon glyphicon-arrow-left'></span>";
		$listForm->addSubmitButton($glyphicon, "btn btn-sm btn-warning", "");
		return $listForm->getForm();
	}
}

?>