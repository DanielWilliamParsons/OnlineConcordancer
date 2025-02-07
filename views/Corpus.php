<?php  //  ../views/Corpus.php

require_once 'elements/HTMLElement.php';
require_once 'elements/Head.php';
require_once 'elements/SidebarNav.php';
require_once 'elements/CorpusLayout.php';
require_once 'elements/LearnerCorpusLayout.php';
require_once 'elements/corpusTemplates/CorpusInterface.php';
require_once 'elements/corpusTemplates/LearnerCorpusInterface.php';
require_once 'elements/corpusTemplates/ManagerView.php';
require_once 'StudentNavigation.php';
require_once 'TeacherNavigation.php';
require_once 'elements/Form.php';

class CorpusView {
	
	public function __construct($userName, $userID, $viewData = "") {
		$this->userName = $userName;
		$this->userID = $userID;
		$this->viewData = $viewData;
	}
	
	public function index() {
		$this->createNavbarAndHeader();
		$corpusInterface = new CorpusInterface($this->userID);
		$viewPage = new CorpusLayout("Statistical data will appear here", "See wider texts here", "Concordance lines will appear here", $corpusInterface->getCorpusInterface());
		$viewPage->makeCorpusLayout();
	}
	
	public function learner() {
		$this->createNavbarAndHeader("learnercorpus");
		$corpusInterface = new LearnerCorpusInterface($this->userID);
		$learnerViewPage = new LearnerCorpusLayout("Professional Writers Data", "Student Writers Data", "Comparison Statistics", $corpusInterface->getCorpusInterface());
		$learnerViewPage->makeCorpusLayout();
	}
	
	public function manage() {
		$this->createNavbarAndHeader();
		$corpusInterface = new CorpusInterface($this->userID);
		$corpusManager = new ManagerView();
		$viewPage = new CorpusLayout($corpusManager->getManagerView(), "Teacher Saved Work", "Other things", "Manage All Corpora");
		$viewPage->makeCorpusLayout();
	}
	
	public function myCorpus() {
		$this->createNavbarAndHeader();
		$corpusInterface = new CorpusInterface($this->userID);
		$viewPage = new CorpusLayout("Manage, upload, edit", "My saved work", "Other things", "Manage Your Own Corpus");
		$viewPage->makeCorpusLayout();
	}
	
	private function createHeader() {
		$head = new Head(CORPUS);
		//Add fonts
		$fonts = array(MAVEN_PRO, LUSTRIA);
		$head->addFonts($fonts, "stylesheet", "text/css");
		
		//Add javascript
		$javascript = array(JQUERY, MODERNIZER, MODAL, TOOLTIP, DROPDOWN, POPOVER, COLLAPSE, TRANSITION, HOLDER, TINYMCE, JQUERYUI);
		$head->addJavascript($javascript, "");
		$head->addJavascript("js/main.js", "text/javascript");
		$head->addJavascript("js/tooltip.js", "text/javascript");
		$head->addJavascript("js/ClassAdmin.js", "text/javascript");
		$head->addJavascript("js/Corpus.js", "text/javascript");
		$head->addJavascript("js/CorpusSearch.js", "text/javascript");
		
		//Add stylesheets
		$stylesheets = array(BOOTSTRAP_MIN, BOOTSTRAP_THEME_MIN, JQUERY_STYLE, "css/sidebarSingleLayout.css", "css/corpusInterface.css");
		$head->addStylesheet($stylesheets);
		$head->compileHeader(); //pushes to screenView.
	}
	
	private function createNavbarAndHeader($learner = "") {
		$this->createHeader(); //The header is pushed to the HTMLElement's screenView
		
		if(substr($this->userID, 0, 8) == "teacher_") {
			$navbar = new TeacherNavigation("Corpus: " . $this->userName);
			if($learner === "") {
				$navbar->makeTeacherNavigation('corpus');
			} else {
				$navbar->makeTeacherNavigation($learner);
			}
			
		} else if (substr($this->userID, 0, 8) == "student_") {
			$navbar = new StudentNavigation("Corpus: " . $this->userName);
			if($learner === "") {
				$navbar->makeStudentNavigation('corpus');
			} else {
				$navbar->makeStudentNavigation($learner);
			}
		}
	}
	
}


?>