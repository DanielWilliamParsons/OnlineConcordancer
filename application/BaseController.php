<?php  //  ../application/BaseController.php
require_once "BaseObserver.php";
abstract class BaseController extends BaseObserver{
	protected $urlvalues;
	protected $action;
	public function __construct($action, $urlvalues) {
		parent::__construct();
		$this->action = $action;
		$this->urlvalues = $urlvalues;
	}
	public function ExecuteAction() {
		return $this->{$this->action}();
	}
	
	protected function ReturnView($view) {
		echo ($view);
	}
	
	protected function StartSession() {
		session_start();
	}
	
	protected function LogUserOut() {
		if(isset($_SESSION['status'])) {
			unset($_SESSION['status']);

			if(session_id() != "" ||isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-10000);
				session_destroy();
				header("location: index.php");
			}
		}
	}
}

?>