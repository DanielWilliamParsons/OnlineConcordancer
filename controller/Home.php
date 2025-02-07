<?php //  ../controllers/Home.php

/*
	---HOME CONTROLLER---
	This is the controller for the Home Page.
*/

class Home extends BaseController {
	private $observer;
	private $view;
	private $model;
	public function __construct($action, $urlvalues) {
		parent::__construct($action, $urlvalues);
	}
	
	/*
	private function __destruct() {
		unset($this->observer);
		unset($this->model);
		unset($this->view);
		echo "Ive been destroyed";
	}*/
	
	protected function index() {
		$this->StartSession();
		//print_r($_SESSION);
	}
}
?>