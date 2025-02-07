<?php
require_once "BaseSubject.php";
abstract class BaseModel extends BaseSubject{
	
	public function __construct() {
		parent::__construct();
		$this->modelData = "";
	}
	
	public function confirm_member() {
		if(!isset($_SESSION) || $_SESSION['status'] != 'authorised') {
			header("location: index.php");
		} else {
			return true;
		}
	}
	
	public function confirm_member_ajax() {
		if(!isset($_SESSION) || $_SESSION['status'] != 'authorised') {
			return false;
		} else {
			return true;
		}
	}
	
	public function getModelData() {
		return $this->modelData;
	}
	
	public function setModelData($data) {
		$this->modelData = $data;
	}
	
}

?>