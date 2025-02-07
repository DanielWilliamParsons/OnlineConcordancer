<?php

require_once 'elements/HTMLElement.php';
require_once 'elements/Head.php';
require_once 'TeacherNavigation.php';
require_once 'elements/SidebarNav.php';
require_once 'elements/SidebarSingleLayout.php';
require_once 'elements/Placeholder.php';
require_once 'elements/Form.php';

class ClassAdminAjaxView {
	
	public function __construct($username, $userID, $viewData = "") {
		$this->username = $username;
		$this->userID = $userID;
		$this->viewData = $viewData;
	}
	
	public function createClass() {
		$view = View::instantiateView();
		if(is_string($this->viewData['message'])) {
			$viewMessage = $this->viewData['message'];
		} else {
			$messages = $this->viewData['message']['message'];
			$viewMessage = "";
			if(is_string($messages)) {
				$viewMessage = $messages;
			} else {
				foreach($messages as $message) {
					$viewMessage .= $message . "<br/>";
				}
			}
			
		}
		$viewMessage = $view->makeTextWrap("h4", "class='text-danger'", $viewMessage);
		$view->pushHTMLtoScreenView($viewMessage . $this->remakeClassForm());

	}
	
	private function remakeClassForm() {
		
		$classname = $this->viewData['formData']['classname'];
		$date_start = $this->viewData['formData']['date_start'];
		$date_finish = $this->viewData['formData']['date_finish'];
		$details = $this->viewData['formData']['classDetails'];
		$file_link = $this->viewData['formData']['file_link'];
				
		$syllabusData = $this->viewData['syllabus_details'];
		if(empty($syllabusData)) {
			$syllabusData = array();
		}
		
		$createClassForm = new Form("", "", false, "id='myForm'");
		$createClassForm->horizontalForm();
		$createClassForm->addTextInput(false, "classname", "$classname", 
						"Class Name", "100", "classname", "form-control", "", "Name");
		$createClassForm->addTextarea(false, "classDetails", "$details", "Class Details", "classDetails",
											"", "5", "", "Details");
		$createClassForm->addTextInput(false, "startdate", "$date_start", "Start Date", "", "startdate", "form-control", "", "Start Date");
		$createClassForm->addTextInput(false, "finishdate", "$date_finish", "Finish Date", "", "finishdate", "form-control", "", "Finish Date");
		$createClassForm->addCheckBoxes(array(false), array(true), 
					array("active"), array("y"), array("active"), array(""), array("Make class active"));
		$createClassForm->addSelectInput($syllabusData, false, "syllabus_data", "form-control", "syllabus_data", "", "Attach a Syllabus");
		$createClassForm->addTextInput(false, "file_link", "$file_link", "External Links as url", "", "file_link", "form-control", "", "Link");
		$view = View::instantiateView();
		$button = $view->makeTextWrap("button", "class='col-sm-offset-2 btn btn-sm btn-success' onclick='createClass()'", "submit");
		
		return ($createClassForm->getForm() . $button);
	}

	
}

?>