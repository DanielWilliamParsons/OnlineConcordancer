<?php

class Logout extends BaseController {
	public function __construct($action, $urlvalues) {
		parent::__construct($action, $urlvalues);
	}
	
	protected function index() {
		$this->StartSession();
		$this->LogUserOut();
	}
}

?>