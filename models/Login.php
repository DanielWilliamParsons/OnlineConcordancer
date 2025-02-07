<?php // ../models/Login.php

/*

	---LOGIN MODEL---
	This class extends the Observer class (using the Observer pattern)
	It subscribes to the Singleton Validator class
	and observes changes in state, e.g. if Validator state becomes "invalid"
	this calls the invalid() method in this class, which in turn gets the
	message from the Validator class

*/

require_once "classes/Sanitizer.php";
require_once "classes/Validator.php";
require_once "classes/Observer.php";

class LoginModel extends Observer{
	
	public function __construct(array $post) {
		parent::__construct();
		$this->post = $post;
		$this->data = null; //This is data which will be sent back to the controller.
	}
	
	public function verify_un_and_pw() {
		foreach($this->post as &$postValue) {
			$sanitizer = Sanitizer::instantiateSanitizer();
			$postValue = $sanitizer->wipeAllHTML($postValue);
		}
		$validator = Validator::instantiateValidator($this->post);
		$validator->subscribe($this); //subscribe this instance as an observer of the validator
		$validator->validateLogin($this->post);
		return $this->data;
	}
	
	/*
		---invalid()---
		This means the Validator class couldn't accept the inputted username and password
		The data for this Login class is set to the message from the validator.
	*/
	protected function invalid($validatorSubject) {
		if(($validatorSubject->getValidatorMessage()) !== null) {
			$this->data = $validatorSubject->getValidatorMessage();
		}
	}
	
	/*
		---valid()---
		This means the Validator class accepted the inputted username and password.
		Next task is to cross reference them with the database which begins here.
	*/
	protected function valid() {
		//Access the file with username and password and log the user in
		
		$un_pw = $this->post['username'] . "_" . $this->post['password'] . "_" . $this->post['usertype'];
		$users = file_get_contents('models/un_pw.txt');
		if(stristr($users, $un_pw) === FALSE) {
			$this->notVerified();
		} else {
			$this->verified();
		}
	}
	
	/*
		---notVerified()---
		This means that the MySQL class could not verify the name
		and password provided with the data in the database
	*/
	protected function notVerified() {
		//After accessing the file, send a message back to the user.
		$this->data['message'] = "There is a problem with your username or password.";
		$_SESSION['status'] = "not_authorized";
	}
	
	/*
		---verified()---
		This means that the MySQL class verified the provided username
		and password with the data in the database.
	*/
	protected function verified() {
		$_SESSION['status'] = "authorised";
	}
	
	public function getPost() {
		return $this->post;
	}
	
}

?>