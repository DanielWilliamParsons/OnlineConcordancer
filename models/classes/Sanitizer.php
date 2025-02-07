<?php // ../models/classes/Sanitizer.php

/*
	---Singleton Sanitizer Class---
	Prevents or allows HTML injections depending on
	method called
*/

require_once "RequestDataHandling.php";
require_once "DataHandlerClasses.php";

class Sanitizer{
	static $thisClass = false;
	private $howToSanitize;
	private $cleanData;
	
	public function __construct() {
		
		//Set up a chain of command here to handle the data
		$this->stringHandle = new StringHandle();
		$oneDimensionalArray = new OneDimensionalArray();
		$twoDimensionalArray = new TwoDimensionalArray();
		$threeDimensionalArray = new ThreeDimensionalArray();
		
		$this->stringHandle->setSuccessor($oneDimensionalArray);
		$oneDimensionalArray->setSuccessor($twoDimensionalArray);
		$twoDimensionalArray->setSuccessor($threeDimensionalArray);
		
		$this->howToSanitize = "handleString"; //default method for handling data
		
		$this->cleanData = "";
	}
	
	public static function instantiateSanitizer() {
		if(self::$thisClass == false) {
			return self::$thisClass = new Sanitizer();
		} else {
			return self::$thisClass;
		}
	}
	
	public function sanitizeData($data) {
		$requestDataHandling = new RequestDataHandling($data);
		$this->howToSanitize = $this->stringHandle->handleRequest($requestDataHandling);
		if(method_exists($this, $this->howToSanitize)) {
			return call_user_func(array($this, $this->howToSanitize), $data);
		}
	}
	
	private function handleString($data) {
		$data = nl2br($data);
		$data = htmlentities($data);
		return $data = htmlspecialchars($data);

	}
	
	private function handleOneDimensionalArray($data) {
		$cleanData = array();
		$redirect = "";
		if(array_key_exists('redirect', $data)) {
			$redirect = $data['redirect'];
		}
		foreach ($data as $key => $value) {
			$key = nl2br($key);
			$value = nl2br($value);
			$key = htmlentities($key);
			$value = htmlentities($value);
			$key = htmlspecialchars($key);
			$value = htmlspecialchars($value);
			$cleanData[$key] = $value;
		}
		if(array_key_exists('redirect', $cleanData)) {
			$cleanData['redirect'] = $redirect; //this will not be sanitized otherwise the redirect url gets corrupted!
		}
		return $cleanData;
	}
	
	public function wipeAllHTML($var, $nl2br=false) {
		
		if($nl2br == true) {
			$var = nl2br($var);
		}
		$var = htmlentities($var);
		$var = htmlspecialchars($var);
		return $var;
	}
	
	public function stripAllHTML($var, $nl2br=false) {
		
		if($nl2br == true) {
			$var = nl2br($var);
		}
		
		$var = strip_tags($var);
		return $var;
	}
	
	public function returnHTML($var) {
		$var = html_entity_decode($var);
		$var = htmlspecialchars_decode($var);
		$var = stripcslashes($var);
		return $var;
	}
	
	private function writeToAFile($message) {
		$fp = fopen('log.txt', 'r+');
			fseek($fp, 0, SEEK_END);
			fwrite($fp, time() . ": ");
			fwrite($fp, $message . '\n');
			fclose($fp);
	}
	
}

?>