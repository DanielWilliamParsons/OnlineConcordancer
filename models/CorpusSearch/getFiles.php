<?php

class GetFiles {
	
	public $finalContent;
	public $filesWordCount; //number of words within selected files only
	public $totalNumberOfWords;
	public $filesTokenCount; //number of token in selected files only
	public $totalNumberOfTokens; //total number of token in all the files
	
	public function __construct() {
		$this->finalContent = array();
		
		$this->filesWordCount = array();
		$this->totalNumberOfWords = "";
		
		$this->filesTokenCount = array();
		$this->totalNumberOfTokens = "";
	}
	
	public function getAllFiles($directoryName="") {
		
		if($directoryName == "") {
			$dh = opendir('CORPUS/');
			$directory_array = array();
				while($directory= readdir($dh)) {
					if ($directory == "." || $directory == "..") {
						$doNothing = "";
					} else {
						$directory_array[] = 'CORPUS/' . $directory . "/";
						}
				}
		} else if(is_string($directoryName)) {
			$directory_array[] = 'CORPUS/' . $directoryName . "/";
		} else if(is_array($directoryName)) {
			foreach($directoryName as $name) {
				$directory_array[] = 'CORPUS/' . $name . "/";
			}
		}
		
		
		foreach($directory_array as $value) {
			$dh = opendir($value);
				while($file = readdir($dh)) {
					if($file == "." || $file == "..") {
						$doNothing = "";
						} else {
							$contents = file_get_contents($value . $file);
							$this->finalContent[$value . $file] = $contents;
							}
					}
		}
	}
	
	public function getFilesWordCount() {
		foreach($this->finalContent as $key=>$value) {
			$contentArray = explode(" ", $value);
			
			$this->filesWordCount[$key] = count($contentArray);
			
			$tokenArrayIndividualFiles = array_unique($contentArray);
			$this->filesTokenCount[$key] = count($tokenArrayIndividualFiles);
		}
		$count = 0;
		foreach($this->filesWordCount as $value) {
			$count += $value;
		}
		$this->totalNumberOfWords = $count;
	}
	
	//This works theoretically, but it runs out of memory on a large corpus!!!
	/*public function countEachWord() {
		$wholeCorpus = "";
		foreach($this->finalContent as $value) {
			$wholeCorpus .= $value;
		}
		$wholeCorpus = explode(" ", $wholeCorpus);
		$find = array("'", ".", "?", "!", ",");
		$replace = array("", "", "", "", "");
		$wholeCorpus = preg_replace($find, $replace, $wholeCorpus);
		natcasesort($wholeCorpus);
		$i=0;
		$index = array();
		foreach($wholeCorpus as $word) {
			$junk = preg_match('/[^a-zA-Z]/', $word);
			if($junk == 1) {
				$word = "";
			}
			if((!empty($word)) && ($word != "")) {
				if(!isset($index[$i]['word'])) {
					$index[$i]['word'] = $word;
					$index[$i]['count'] = 1;
				} elseif ($index[$i]['word'] == $word) {
					$index[$i]['count'] += 1;
				} else {
					$i++;
					$index[$i]['word'] = $word;
					$index[$i]['count'] = 1;
				}
			}
		}
		unset($wholeCorpus1);
	}*/
	
	public function printFiles() {
		foreach($this->filesWordCount as $key=>$value) {
			echo $key . ":  " . $value;
			echo "<br/><br/>";
		}
		
		foreach($this->filesTokenCount as $key->$value) {
			echo $key . ": " . $value;
			echo "<br/><br/>";
		}
		
		echo "Total number of words: " . $this->totalNumberOfWords . "<br/>";
		echo "Total number of tokens: " . $this->totalNumberOfTokens . "<br/>";
		
	}
	
}

$arrayOfFileNames = array("Fiction", "Non_fiction");
$singleFile = "GCSE_Bitesize";

$myCorpus = new GetFiles();
$myCorpus->getAllFiles();
$myCorpus->getFilesWordCount();
print_r($myCorpus->filesWordCount);
echo $myCorpus->totalNumberOfWords;
//$myCorpus->countEachWord();
//$myCorpus->printFiles();


?>