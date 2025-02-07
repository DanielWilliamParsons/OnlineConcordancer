<?php

require_once "IModelData.php";
class SanitizeAndClean implements IModelData {
	
	public function __construct(ISanitizer $sanitizer) {
		$this->sanitizer = $sanitizer; //This will be a model instance
	}
	
	public function setModelData($data) {
		$this->sanitizer->setModelData($data); //This method exists in the model's parent, BaseModel, instance
		$this->writeToAFile("Called Set Model Data in SanitizeAndClean class");
	}
	
	public function passBackData() {
		$this->sanitizer->sanitizeData(); //This is where sanitizing will take place.
		$this->writeToAFile("called passBackData in SanitizeAndClean class");
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