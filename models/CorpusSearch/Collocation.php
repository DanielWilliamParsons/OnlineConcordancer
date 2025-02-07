<?php
require_once "getFileNames.php";

class Collocation {

	public function __construct($searchTerm) {
		$this->POS_tags = array("IN", "NNP", ",", "CC", "NN", ":", "VBZ", ".", "DT", "JJ",
							"NNS", "TO", "VB", "CD", "VBN", "MD", "VBG", "RB", "-NON",
							"JJR", "VBD", "PRP$", "NNPS", "PRP", "VBP", "WDT", "WP",
							"RBR", "RBS", "JJS", "EX");
		$this->stopWords = array("poo", "poo2");
		$this->punctuation = array(".", ",", ";", ":", "\"", "!", "?", "(", ")", "-", "'", "{", "}");
		$this->filesToSearch = new getFileNames();
		$this->searchTerm = $searchTerm;
		$this->arrayOfWords = array();
		$this->wordCount = array();
		$this->no_occ = 0; //number of occurrences of the searchTerm.
		$this->n11 = array();
		$this->n12 = array();
		$this->n21 = array();
		$this->n22 = array();
		$this->npp = 0;
		$this->N = 0;
		$this->expn11 = array();
		$this->expn12 = array();
		$this->expn21 = array();
		$this->expn22 = array();
		$this->logLikelihoodScore = array();
	}
	
	public function searchFilesPOS($files="") {
		$this->searchTerm = $this->makeSearchTerm($this->searchTerm);
		$this->filesToSearch->findFileNames($files);
		$fileNames = $this->filesToSearch->getFileNames();
		foreach($fileNames as $filename) {
			$text = $this->processPunctuation(file_get_contents($filename));
			$this->arrayifyPOS($text);
			$keysArray = $this->recursive_array_searchPOS($this->arrayOfWords);
			$this->no_occ += count($keysArray);
			$this->occurrences($keysArray);
		}
		
		foreach($this->n11 as $word=>$frequency) {
			$this->n12[$word] = $this->no_occ - $frequency; //number of times the node word occurs by itself without the occurring word
															//total number of occurrences of node word - frequency of occuring word
			$this->n21[$word] = $this->wordCount[$word] - $this->n11[$word]; //number of times the occuring word is by itself without the node word
																				//total number of times co-occurring word occurs - the number of times they co-occur
			$this->n22[$word] = $this->N - ($this->wordCount[$word] + $this->no_occ); //number of times neither words co-occur
		}
		
		$this->expectedFrequencies();
		$this->logLikelihoodScore();
		arsort($this->logLikelihoodScore);
		$returnValues = array("collocates"=>$this->logLikelihoodScore, "searchTerm"=>$this->searchTerm);
		return json_encode($returnValues);
	}
	
	private function processPunctuation($text) {
		for ($i = 0; $i < sizeof($this->punctuation); $i++) {
			$text = str_replace($this->punctuation[$i], " ", $text);
		}
		$text = str_replace(" _ ", "", $text);
		return $text;
	}
	
	private function arrayifyPOS($text) {
		if($this->arrayOfWords !== null) {
			unset($this->arrayOfWords);
		}
		$array = explode(" ", $text);
		$this->N += count($array);
		$this->arrayOfWords = $array;

		foreach($this->arrayOfWords as $word) {
			$word = strtolower($word);
			$word = substr($word, 0, strpos($word, "_"));
			if(is_string($word) || is_integer($word)) {
				if(array_key_exists($word, $this->wordCount)) {
				$this->wordCount[$word] += 1;
				} else {
					$this->wordCount[$word] = 1;
				}
			}
		}
	}
	
	private function makeSearchTerm($term) {
		if(substr($term, 0, 1) === "_") {
			//This case looks at when only the POS has been entered
			$term = $term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
			$term = "/\b[a-zA-Z0-9]*" . $term . "\b/";
		} else if(strpos($term, "_") === FALSE) {
			//This case looks at when only a word has been entered with a possible wildcard.
			$term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
			$term =  "/\b" . $term . "_[a-zA-Z0-9]*" . "\b/";
		} else {
			//This case looks at when both a word with a possible wildcard and a POS has been entered.
			$term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
			$term = "/\b" . $term . "\b/";
		}
		return $term;
	}
	
	private function recursive_array_searchPOS($arrayOfWords) {
		$keysArray = array();
		foreach($arrayOfWords as $key=>$word) {
			if(preg_match($this->searchTerm, $word)) {
				$keysArray[] = $key;
			}
		}
		return $keysArray;
	}
	
	private function occurrences($keysArray) {
		$count = count($this->arrayOfWords);
		foreach($keysArray as $key) {
			$L3 = $key - 3;
			$R3 = $key + 3;
			//set up the concordance
			if($key-3<0) {
				$L3 = 0;
			}
			if($key+3>$count) {
				$R3 = $count-1;
			}
			//count the occurring words to the left
			for($i=$L3; $i<$key; ++$i) {
				$word = strtolower($this->arrayOfWords[$i]);
				$word = substr($word, 0, strpos($word, "_"));
				if(is_string($word) || is_integer($word)) {
					if(!in_array($word, $this->stopWords)) {
						if(array_key_exists($word, $this->n11)) {
							$this->n11[$word] += 1;
						} else {
							$this->n11[$word] = 1;
						}
					}
				}
			}
			//count the occurring words to the right
			for($i = $key; $i<$R3; ++$i) {
				$word = strtolower($this->arrayOfWords[$i]);
				$word = substr($word, 0, strpos($word, "_"));
				if(is_string($word) || is_integer($word)) {
					if(!in_array($word, $this->stopWords)) {
						if(array_key_exists($word, $this->n11)) {
							$this->n11[$word] += 1;
						} else {
							$this->n11[$word] = 1;
						}
					}
				}
			}
		}
	}
	
	private function expectedFrequencies() {
		foreach($this->n11 as $word=>$frequency11) {
			$frequency12 = $this->n12[$word];
			$frequency21 = $this->n21[$word];
			$frequency22 = $this->n22[$word];
			
			$expfreq11 = (($frequency11 + $frequency12) * ($frequency11 + $frequency21))/(($this->N)-1);
			$expfreq12 = (($frequency11 + $frequency12) * ($frequency12 + $frequency22))/(($this->N)-1);
			$expfreq21 = (($frequency21 + $frequency22) * ($frequency11 + $frequency21))/(($this->N)-1);
			$expfreq22 = (($frequency21 + $frequency22) * ($frequency12 + $frequency22))/(($this->N)-1);
			
			$this->expn11[$word] = $expfreq11;
			$this->expn12[$word] = $expfreq12;
			$this->expn21[$word] = $expfreq21;
			$this->expn22[$word] = $expfreq22;
		}
	}
	
	private function logLikelihoodScore() {
		foreach($this->n11 as $word=>$frequency11) {
			$frequency12 = $this->n12[$word];
			$frequency21 = $this->n21[$word];
			$frequency22 = $this->n22[$word];
			$expfreq11 = $this->expn11[$word];
			$expfreq12 = $this->expn12[$word];
			$expfreq21 = $this->expn21[$word];
			$expfreq22 = $this->expn22[$word];

			$score = 2 * (($frequency11*log($frequency11/$expfreq11)) +
														($frequency12*log($frequency12/$expfreq12)) +
														($frequency21*log($frequency21/$expfreq21)) +
														($frequency22*log($frequency22/$expfreq22)));
			if(is_nan($score)) {
				$score = 0;
			}
			if($score >= 6) {
				$this->logLikelihoodScore[$word] = round($score, 3);
			}
			
		}
	}
	
}

?>