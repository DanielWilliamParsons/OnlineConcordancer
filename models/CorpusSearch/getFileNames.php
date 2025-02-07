<?php

class getFileNames {
	
	public function __construct() {
		$this->fileNames = array();
	}
	
	public function getFileNames() {
		return $this->fileNames;
	}
	
	public function findFileNames($directoryName="") {
		if($directoryName == "") {
			$dh = opendir('models/CorpusSearch/TAGGED CORPUS/');
			$directory_array = array();
				while($directory= readdir($dh)) {
					if ($directory == "." || $directory == "..") {
						$doNothing = "";
					} else {
						$directory_array[] = 'models/CorpusSearch/TAGGED CORPUS/' . $directory . "/";
						}
				}
		} else if(is_string($directoryName)) {
			$directory_array[] = 'models/CorpusSearch/TAGGED CORPUS/' . $directoryName . "/";
		} else if(is_array($directoryName)) {
			foreach($directoryName as $name) {
				$directory_array[] = 'models/CorpusSearch/TAGGED CORPUS/' . $name . "/";
			}
		}
		
		foreach($directory_array as $value) {
			$dh = opendir($value);
				while($file = readdir($dh)) {
					if($file == "." || $file == "..") {
						$doNothing = "";
						} else {
							$this->fileNames[] = $value . $file;
							}
					}
		}
		
	}
	
	public function printFileNames() {
		print_r($this->fileNames);
	}
	
}
/*
$corpus = new getFileNames();
$corpus->findFileNames(array("Fiction", "Non_fiction"));
$corpus->printFileNames();*/

?>