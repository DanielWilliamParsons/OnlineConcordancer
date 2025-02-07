<?php
require_once "views/elements/Form.php";
require_once "views/elements/ButtonBlockPanel.php";
require_once "views/elements/Head.php";
require_once "views/elements/ButtonBlockPanel.php";
require_once "views/elements/ThreeColumnScreen.php";
require_once "views/elements/HTMLElement.php";
require_once "views/elements/Modal.php";

class LoginView {
	public function __construct() {
		$this->view = View::instantiateView();
		$this->userMessage = "";
	}
	
	public function sendMessage($message) {
		$this->userMessage .= $this->view->makeTextWrap("h5", "id='notice'", $message);
	}
	
	public function createView() {

		$teacherForm = new Form("POST", "index.php?controller=Login&action=index", false);
		$teacherForm->addTextInput(false, "username", "", "Username", 20, "teacher", "form-control", "", "");
		$teacherForm->addPasswordInput(false, "password", "", "Password", 100, "teacher", "form-control", "", "");
		$teacherForm->addHiddenInput("usertype", "", "teacher");
		$teacherForm->addSubmitButton("Login", "btn btn-success", "", "", "");

		$studentForm = new Form("POST", "index.php?controller=Login&action=index", false);
		$studentForm->addTextInput(false, "username", "", "Username", 20, "student", "form-control", "", "");
		$studentForm->addPasswordInput(false, "password", "", "Password", 100, "student", "form-control", "", "");
		$studentForm->addHiddenInput("usertype", "", "student");
		$studentForm->addSubmitButton("Login", "btn btn-success", "", "", "");
		
		//Create the <head>...</head> element
		$head = new Head(LOGIN_HEADER);
		
		//Add fonts
		$fonts = array(MAVEN_PRO, LUSTRIA);
		$head->addFonts($fonts, "stylesheet", "text/css");
		
		//Add javascript
		$javascript = array(JQUERY, MODERNIZER);
		$head->addJavascript($javascript, "");
		$head->addJavascript("js/main.js", "text/javascript");
		
		//Add stylesheets
		$stylesheets = array(BOOTSTRAP_MIN, BOOTSTRAP_THEME_MIN, "css/home.css");
		$head->addStylesheet($stylesheets);
		$head->compileHeader(); //pushes to screenView
		
		//Create the modals for the login
		$teacherModal = new Modal("teacher", "Teacher Login", $teacherForm->getForm());
		$teacherModal->createModal(); //pushes to screenView
		$studentModal = new Modal("student", "Student Login", $studentForm->getForm());
		$studentModal->createModal(); //pushes to screenView
		
		//Create buttons on the button panel
		
		$title = "Login";
		$buttons['teacher'] = array('class'=>"btn btn-danger btn-lg btn-block", 'id'=>"teacher", 'href'=>"#", 
							'otherAttributes'=>"data-toggle='modal' data-target='#teacher'"); //Be care that the data-targets are the
																								//same as the Modal ids
		$buttons['student'] = array('class'=>"btn btn-success btn-lg btn-block", 'id'=>"student", 'href'=>"#", 
							'otherAttributes'=>"data-toggle='modal' data-target='#student'");
		$buttonBlock = new ButtonBlockPanel($title, $buttons, $this->userMessage);
		$buttonPanel = $buttonBlock->getButtonPanel(); //returns the button panel.
		
		//Create the three-column screen
		$screen = new ThreeColumnScreen();
		$screen->setTitle("Corpus");
		$screen->setMiddleContentFromOffset($buttonPanel, 6, 3);
		$screen->compileScreen(); //pushes to screenView
		
		$this->view->pushHTMLtoScreenView("<script src='js/modal.js'></script>");
		$this->view->pushHTMLtoScreenView(FOOTER); //I'm too lazy to make a footer class!
		return $this->view->getScreenViewAsHTML();
		
	}
}

?>