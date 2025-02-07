<?php  //   ../models/classes/DataHandlerClasses.php

/*
	---CHAIN OF COMMAND---
	A set of handler classes, each extending the DataHandler
	abstract class.
*/
require_once "DataHandler.php";

class StringHandle extends DataHandler {
	
	private $successor;
	
	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	
	public function handleRequest($request) {
		if(is_string($request->getDataType())) {
			return "handleString";
		} else if($this->successor != NULL) {
			return $this->successor->handleRequest($request);
		}
	}
	
	private function writeToAFile($message) {
		$fp = fopen('log.txt', 'r+');
			fseek($fp, 0, SEEK_END);
			fwrite($fp, time() . ": ");
			fwrite($fp, $message . '\r\n');
			fclose($fp);
	}
}

class OneDimensionalArray extends DataHandler {
	
	private $successor;
	private $singleArray;
	
	public function setSuccessor($nextService) {
		$this->successor = $nextService;
		$this->singleArray = false;
	}
	
	private function setSingleArray() {
		$this->singleArray = true;
	}
	
	private function getSingleArray() {
		return $this->singleArray;
	}
	
	public function handleRequest($request) {
		$requestData = $request->getDataType();
		$dataForFile = "";
		foreach($requestData as $value) {
			if(is_string($value) || is_integer($value)) {
				$this->setSingleArray();
			}
		}
		
		if($this->getSingleArray() == true) {
			return "handleOneDimensionalArray";
		} else if($this->successor != NULL) {
			return $this->successor->handleRequest($request);
		}
	}
	
	private function writeToAFile($message) {
		$fp = fopen('log.txt', 'r+');
			fseek($fp, 0, SEEK_END);
			fwrite($fp, time() . ": ");
			fwrite($fp, $message . '\r\n');
			fclose($fp);
	}
}

class TwoDimensionalArray extends DataHandler {
	
	private $successor;
	private $doubleArray = false;
	
	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	
	private function setDoubleArray() {
		$this->doubleArray = true;
	}
	
	public function handleRequest($request) {
		$requestData = $request->getDataType();
		foreach($requestData as $array) {
			foreach($array as $value) {
				if(is_string($value)) {
					$this->setDoubleArray();
				}
			}
		}
		
		if($this->doubleArray == true) {
			return "handleTwoDimensionalArray";
		} else if($this->successor != NULL) {
			return $this->successor->handleRequest($request);
		}
	}
	
	private function writeToAFile($message) {
		$fp = fopen('log.txt', 'r+');
			fseek($fp, 0, SEEK_END);
			fwrite($fp, time() . ": ");
			fwrite($fp, $message . '\r\n');
			fclose($fp);
	}
}

class ThreeDimensionalArray extends DataHandler {
	
	private $successor;
	private $tripleArray = false;
	
	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	
	private function setTripleArray() {
		$this->tripleArray=true;
	}

	public function handleRequest($request) {
		$requestData = $request->getDataType();
		foreach ($requestData as $value) {
			foreach($value as $array) {
				foreach ($array as $string) {
					if(is_string($string)) {
						$this->setTripleArray();
					}
				}
			}
		}
		
		if($this->tripleArray == true) {
			return "handleThreeDimensionalArray";
		} else if($this->successor != NULL) {
			return $this->successor->handleRequest($request);
		}
	}
	
	private function writeToAFile($message) {
		$fp = fopen('log.txt', 'r+');
			fseek($fp, 0, SEEK_END);
			fwrite($fp, time() . ": ");
			fwrite($fp, $message . '\r\n');
			fclose($fp);
	}
}







?>

