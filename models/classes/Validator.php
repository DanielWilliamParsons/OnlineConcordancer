<?php  //  ../models/classes/Validator.php

/*
	---VALIDATES USER INPUT---
	This can be used for both signup and validating forms
	This class is observable under the publish-subscribe (observer) pattern
	It can be used to validate username and password
	It does NOT cross reference with a database.
	That is left to the MySQL class.

*/

require_once "Subject.php";

class Validator extends Subject {
	static $thisClass = false;
	
	public function __construct() {
		parent::__construct();
		$this->validatorMessage['invalid'] = false;
		$this->validatorMessage['message'] = array();
	}
	
	public static function instantiateValidator() {
		if(self::$thisClass == false) {
			return self::$thisClass = new Validator();
		} else {
			return self::$thisClass;
		}
	}
	
	public function getValidatorMessage() {
		return $this->validatorMessage;
	}
	
	public function validateLogin(array $post) {
		if(!array_key_exists('username', $post)
			|| !array_key_exists('password', $post)
			|| !array_key_exists('usertype', $post)) {
				
				$this->validatorMessage['invalid'] = true;
				$this->validatorMessage['message'][0] = "Invalid username and password";
				$this->setState("invalid");
			}
		else {
			$this->validateUsernameAndPassword($post['username'], $post['password']);
		}
	}
	
	private function validateUsernameAndPassword($username, $password) {
		switch ($username) {
			case "":
				$this->validatorMessage['invalid'] = true;
				array_push($this->validatorMessage['message'], "Please fill in your username");
				$this->setState("invalid");
				break;
			case strlen($username) < 6:
				$this->validatorMessage['invalid'] = true;
				array_push($this->validatorMessage['message'], "Username must be more than 5 characters");
				$this->setState("invalid");
				break;
			case preg_match("/[a-zA-Z0-9_-]/", $username):
				$this->validatorMessage['invalid'] = true;
				array_push($this->validatorMessage['message'], "Your username should only consist of numbers and letters");
				$this->setState("invalid");
				break;
		}
		
		switch ($password) {
			case "":
				$this->validatorMessage['invalid'] = true;
				array_push($this->validatorMessage['message'], "Please enter your password");
				$this->setState("invalid");
				break;
			case strlen($password) < 6:
				$this->validatorMessage['invalid'] = true;
				array_push($this->validatorMessage['message'], "Username must be more than 5 characters");
				$this->setState("invalid");
				break;
		}
		
		if($this->validatorMessage['invalid'] === false) {
			$this->setState("valid");
		}
	}
	
	public function validateClassId($classDetails) {
		if(empty($classDetails['class_id']) || $classDetails['class_id'] != $_SESSION['class_id']) {
			$this->setState('invalidClassId');
		} else {
			$observers = $this->getObservers();
			foreach($observers as $observer) {
				$observer->setData($classDetails);
			}
			$this->setState($classDetails['queryMethodName']);
		}
	}
	
	public function validateTeacherID($data) {
		if(empty($data['t_id']) || $data['t_id'] != $_SESSION['t_id']) {
			$this->setState('idIssues');
		} else {
			$observers = $this->getObservers();
			foreach($observers as $observer) {
				$observer->setData($data);
			}
			$this->setState($data['queryMethodName']);
		}
	}
	
	public function validateTeacherIDAndClassID($data) {
		if(empty($data['t_id']) || $data['t_id'] != $_SESSION['t_id']) {
			$this->setState('idIssues');
		} else if(empty($data['class_id']) || $data['class_id'] != $_SESSION['class_id']) {
			$this->setState('invalidClassId');
		} else {
			$observers = $this->getObservers();
			foreach($observers as $observer) {
				$observer->setData($data);
			}
			$this->setState($data['queryMethodName']);
		}
	}
	
	
}

?>