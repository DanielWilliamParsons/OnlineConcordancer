<?php

require_once "Validator.php";

class ValidatorAjax extends Validator {
	
	static $thisclass = false;
	
	public function __construct() {
		parent::__construct();
	}
	
	public static function instantiateValidatorAjax() {
		if(self::$thisclass == false) {
			return self::$thisclass = new ValidatorAjax();
		} else {
			return self::$thisclass;
		}
	}
	
	public function validateCreateClassFields(array $dataFields) {
		switch($dataFields['classname']) {
			case "":
				$this->validatorMessage['invalid'] = true;
				$this->validatorMessage['message'][] = "You didn't enter a name for your class";
				break;
			case preg_match("/[a-zA-Z0-9_-]/", $dataFields['classname']):
				$this->validatorMessage['invalid'] = true;
				$this->validatorMessage['message'][] = "Only numbers and letters allowed for the class name";
				break;
		}
		
		if (strpos(stripslashes($dataFields['classname']), "'") !== false) {
			$this->validatorMessage['invalid'] = true;
			$this->validatorMessage['message'][] = "You cannot use apostrophes in the class name. For database reasons! They get backslashed away and so cut off everything after it.";
		}
		
		if(empty($dataFields['syllabus_data']) || !isset($dataFields['syllabus_data'])) {
			$this->validatorMessage['invalid'] = true;
			$this->validatorMessage['message'][] = "There has been a problem with the syllabus attachment, so no data was created.";
		}
		
		switch($dataFields['date_finish']) {
			case "":
				$this->validatorMessage['invalid'] = true;
				$this->validatorMessage['message'][] = "You need to choose a finish date";
				break;
		}
		
		switch($dataFields['date_start']) {
			case "":
				$this->validatorMessage['invalid'] = true;
				$this->validatorMessage['message'][] = "You need to choose a start date";
				break;
		}
		
		if($this->dateCheck($dataFields['date_finish']) == false || $this->dateCheck($dataFields['date_start'] == false)) {
			$this->validatorMessage['invalid'] = true;
			$this->validatorMessage['message'][] = "Please check your date formatting. Use the date panel widget to help you.";
		}
		
		//The data in the QueryAjax class (the observer) is set
		//If validated, beginQuery method in the QueryAjax class can then use the data
		$observers = $this->getObservers();
		foreach($observers as $observer) {
			$observer->setData($dataFields);
		}
		
		if($this->validatorMessage['invalid'] === true) {
			$this->setState("noQuery");
		} else {
			$this->setState("beginClassCreationQuery");
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
	
	private function dateCheck($date) {
		$date_array = explode('/', $date);
		if (count($date_array) == 3) {
			if(checkdate($date_array[0], $date_array[1], $date_array[2])) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
}