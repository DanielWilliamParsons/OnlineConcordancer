<?php  // ../views/elements/AssignmentToolbox.php
require_once "LinkedList.php";
class AssignmentsToolbox implements LinkedList{
	
	public function __construct($assignments) {
		$this->view = View::instantiateView();
		$this->assignments = $assignments; //HTML String
	}
	
	private function createLeftbox($toolbox) {
		$containerAttributes[0]['class'] = 'left-bar';
		$containerAttributes[1]['class'] = 'row';
		$leftbox = $this->view->makeDiv($containerAttributes[0], $toolbox);
		$leftbox = $this->view->makeDiv($containerAttributes[1], $leftbox);
		return $leftbox;
	}
	
	
	public function makeContent($toolbox) {
		$all = $this->createLeftbox($toolbox);
		$containerAttributes[0]['class'] = 'my-fluid-container';
		$this->assignments = $this->view->makeDiv($containerAttributes[0], $all . $this->assignments);
	}
	
	public function nextContent() {
		$this->view->pushHTMLtoScreenView($this->assignments);
		return null;
	}
}

?>