<?php //  ../models/classes/RequestDataHandling.php
/*
	---CHAIN OF COMMAND---
	This is the request that a client makes
	as part of the chain of command pattern.
	Used by the Sanitizer class to decide
	how to deal with the data.
	Can be extended for use with manipulation
	of data for output, too.
*/

class RequestDataHandling {
	
	private $dataType;
	
	public function __construct($data) {
		$this->dataType = $data;
	}
	
	public function getDataType() {
		return $this->dataType;
	}
	
}

?>