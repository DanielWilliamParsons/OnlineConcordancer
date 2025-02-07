<?php  // ../views/elements/AssignmentMain.php
require_once 'AssignmentsToolbox.php';
class AssignmentsMain implements LinkedList{

	private $assignmentsData;
	
	public function __construct($assignmentsData) {
		$this->view = View::instantiateView();
		$this->assignmentsData = $assignmentsData; //HTML String
		$this->assignments = ""; //This will be created by createRightbox()
	}
	
	private function createRightbox() {
			$assignments = "";
			$containerAttributes[0]['class'] = 'row';
			$containerAttributes[0]['id'] = 'addPadding';
			$containerAttributes[1]['class'] = 'my-fluid-container rightBox';
			$assignments = $this->view->makeDiv($containerAttributes[0], $this->assignmentsData);
			$assignments = $this->view->makeDiv($containerAttributes[1], $assignments);
		$this->assignments = $assignments;
	}	
	
	public function makeContent($toolbox) {
		return $this->createRightbox();
	}
	
	public function nextContent() {
		return new AssignmentsToolbox($this->assignments);
	}
}

?>