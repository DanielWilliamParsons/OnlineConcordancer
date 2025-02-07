<?php   //   ../models/classes/DataHandler.php

/*
	---CHAIN OF COMMAND---
	Used as part of the chain of command
	Used by the Sanitizer to decide how to clean the data
	Can be extended for use with manipulating data
	ready for output to user.
*/

abstract class DataHandler {
	
	abstract public function handleRequest($request);
	abstract public function setSuccessor($nextService);
	
}

?>