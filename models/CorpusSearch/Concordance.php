<?php
require_once "getFileNames.php";

class Concordance {
	
	public $concordanceLines;
	
	public function __construct() {
		$this->concordanceLines = array();
		$this->metaData = array();
		$this->fileData = "";
	}
	
	public function addConcordanceData($data) {
		$this->concordanceLines[] = $data;
	}
	
	public function addMetaData($data) {
		$this->metaData[] = $data;
	}
	
	public function getConcordanceDataAndMetaData() {
		$data = array("metadata"=>$this->metaData, "concordancelines"=>$this->concordanceLines);
		return $data;
	}
	
	
	
}

?>