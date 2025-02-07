<?php

class TrackUsers {
	
	public function __construct($data) {
		$this->data = $data;
		$this->errorLog = "";
	}
	
	public function saveInteraction() {
		$path = "models/CorpusSearch/Interaction/" . $this->data['username'] . ".txt";
		if(!file_exists($path)) {
			$handle = fopen($path, "a");
			$text = "User Name \t Date \t Time \t Search Term \t Input Type \t Corpus Name \t Output Type \t Sort Terms \t Wider Context File \t Concordance Line Looked Up \t Collocate KWIC Lookup\n";
			fwrite($handle, $text);
			fclose($handle);
		}
		date_default_timezone_set("Asia/Tokyo");
		$today = getdate();
		$minutes = $today['minutes'];
		$seconds = $today['seconds'];
		if(strlen($minutes) == 1) {
			$minutes = "0" . $minutes;
		}
		
		if(strlen($seconds) == 1) {
			$seconds = "0" . $seconds;
		}
		$date = $today['mon'] . "/" . $today['mday'] . "/" . $today['year'];
		$time = $today['hours'] . ":" . $minutes . ":" . $seconds;
		
		if(array_key_exists('corpusName', $this->data)) {
			$text = $this->data['username'] . "\t" . $date . "\t" . $time . "\t" . 
					$this->data['searchTerm'] . "\t" . $this->data['inputType'] . "\t" . 
					$this->data['corpusName'] . "\t" . $this->data['outputType'] . "\t" . 
					$this->data['sort1'] . $this->data['sort2'] . $this->data['sort3'] . "\t" . "\t" . "\t" . "\n";
		} else {
			$text = $this->data['username'] . "\t" . $date . "\t" . $time . "\t" . 
					$this->data['searchTerm'] . "\t" . $this->data['inputType'] . "\t" . 
					"All + Learner" . "\t" . $this->data['outputType'] . "\t" . 
					$this->data['sort1'] . $this->data['sort2'] . $this->data['sort3'] . "\t" . "\t" . "\t" . "\n";
		}
					
		
		$handle = fopen($path, "a");
		if(fwrite($handle, $text) === FALSE) {
			$this->errorLog = "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	
	public function saveWiderContextLookup() {
		$path = "models/CorpusSearch/Interaction/" . $this->data['username'] . ".txt";
		if(!file_exists($path)) {
			$handle = fopen($path, "a");
			$text = "User Name \t Date \t Time \t Search Term \t Input Type \t Corpus Name \t Output Type \t Sort Terms \t Wider Context File \t Concordance Line Looked Up \t Collocate KWIC Lookup\n";
			fwrite($handle, $text);
			fclose($handle);
		}
		date_default_timezone_set("Asia/Tokyo");
		$today = getdate();
		$minutes = $today['minutes'];
		$seconds = $today['seconds'];
		if(strlen($minutes) == 1) {
			$minutes = "0" . $minutes;
		}
		
		if(strlen($seconds) == 1) {
			$seconds = "0" . $seconds;
		}
		$date = $today['mon'] . "/" . $today['mday'] . "/" . $today['year'];
		$time = $today['hours'] . ":" . $minutes . ":" . $seconds;
		
		$text = $this->data['username'] . "\t" . $date . "\t" . $time . "\t" . 
					"" . "\t" . $this->data['inputType'] . "\t" . 
					"" . "\t" . "" . "\t" . 
					"" . "\t" . $this->data['filename'] . "\t" . $this->data['searchString'] . "\t" . "\n";
					
		
		$handle = fopen($path, "a");
		if(fwrite($handle, $text) === FALSE) {
			$this->errorLog = "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	
	public function saveCollocateInteraction() {
		$path = "models/CorpusSearch/Interaction/" . $this->data['username'] . ".txt";
		if(!file_exists($path)) {
			$handle = fopen($path, "a");
			$text = "User Name \t Date \t Time \t Search Term \t Input Type \t Corpus Name \t Output Type \t Sort Terms \t Wider Context File \t Concordance Line Looked Up \t Collocate KWIC Lookup\n";
			fwrite($handle, $text);
			fclose($handle);
		}
		date_default_timezone_set("Asia/Tokyo");
		$today = getdate();
		$minutes = $today['minutes'];
		$seconds = $today['seconds'];
		if(strlen($minutes) == 1) {
			$minutes = "0" . $minutes;
		}
		
		if(strlen($seconds) == 1) {
			$seconds = "0" . $seconds;
		}
		$date = $today['mon'] . "/" . $today['mday'] . "/" . $today['year'];
		$time = $today['hours'] . ":" . $minutes . ":" . $seconds;
		
		$text = $this->data['username'] . "\t" . $date . "\t" . $time . "\t" . 
					"" . "\t" . $this->data['inputType'] . "\t" . 
					$this->data['corpusName'] . "\t" . $this->data['outputType'] . "\t" . 
					$this->data['sort1'] . $this->data['sort2'] . $this->data['sort3'] . "\t" . "". "\t" . "" . "\t" . $this->data['searchTerm'] . " and " . $this->data['collocate'] . "\n";
					
		
		$handle = fopen($path, "a");
		if(fwrite($handle, $text) === FALSE) {
			$this->errorLog = "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	
}

?>