<?php

/***********
ALGORITHM

Step1: searchFiles($filename) - put in the directories that you want to search
	Step2: get the contents of the files 
		Step2.1: enter firstSearchTerm() function - this function preg_replaces each word for wildcards, word boundaries
						and sets up an array for each word in the search term, called searchTermArray.
	Step3: With arrayify() turn the files into an array of words
	Step4: For just the FIRST SEARCH TERM from the search string, find the keys in the array of the corpus
Step5: enter concordance() function
Step6: make sure there is space either side of the array so we don't go out of bounds when searching
Step7: using the size of the searchTermArray (made in step2.1), check each word that follows the FIRST SEARCH TERM
	Step8: If there is no match, discard this concordance line
	Step9: If all the search terms in the searchTermArray match okay, then return the concordance line
Step10: Each concordance line is set up as a JSON data ready to be dispatched to javascript.
Step11: Put into array.
Step12: JSON encode for javascript

************/

require_once "getFileNames.php";
require_once "getStudentFilenames.php";
class Search {
	
	public function __construct($searchTerm="", $sortArray="", $learner="") {
		$this->filesToSearch = new getFileNames();
		$this->learnerFilesToSearch = new getStudentFileNames();
		$this->arrayOfAllConcordanceLines = array();
		$this->arrayOfAllLearnerConcordanceLines = array();
		$this->searchTerm = $searchTerm;
		$this->firstSearchTerm = "";
		$this->firstSearchTermCompare = "";
		$this->searchTermArray = array();
		$this->learner = $learner;
		$this->searchTermArrayCompare = array();
		$this->punctuation = array(".", ",", ";", ":", "\"", "!", "?", "(", ")", "-", "'", "{", "}");
		$this->POS_tags = array("IN", "NNP", ",", "CC", "NN", ":", "VBZ", ".", "DT", "JJ",
							"NNS", "TO", "VB", "CD", "VBN", "MD", "VBG", "RB", "-NON",
							"JJR", "VBD", "PRP$", "NNPS", "PRP", "VBP", "WDT", "WP",
							"RBR", "RBS", "JJS", "EX");
		$this->sortArray = $sortArray;
		if($this->learner === "yes") {
			$this->width = 6;
		} else {
			$this->width = 15;
		}
		$this->foundArray = array(); //for lists
		$this->foundArrayWithFile = array(); //for lists and associated filenames
	}
	
	public function processSort() {
		$sortArray = array();
		$sort1 = $this->sortArray[0];
		foreach($this->sortArray as $sort) {
			if(stristr($sort, 'R') === FALSE) {
				$array1 = substr($sort, 0);
				$array1 = intval($array1);
				$array2 = 0;
			} else {
				$array1 = substr($sort, 0);
				$array1 = intval($array1)-1;
				$array2 = 2;
			}
			$sortArray[] = array($array2, $array1);
		}
		$this->sortArray = $sortArray;
	}
	
	public function processPunctuation($text) {
		for ($i = 0; $i < sizeof($this->punctuation); $i++) {
			$text = str_replace($this->punctuation[$i], " " . $this->punctuation[$i] . " ", $text);
		}
		return $text;
	}
	
	//Step3
	public function arrayifyPOS($text) {
		//$text = $this->processPunctuation($text);
		$text = strtolower($text);
		return explode(" ", $text);
		//return (str_word_count($text, 1));

	}
	
	//step2.1
	public function firstSearchTermPOS() {
		$searchArray = explode(" ", $this->searchTerm);
		$firstSearchTerm = $searchArray[0];
		$this->firstSearchTerm = $this->makeSearchTerm($firstSearchTerm);
		$searchArray[0] = $this->firstSearchTerm;
		
		for($i=1; $i<count($searchArray); $i++) {

				$searchArray[$i] = $this->makeSearchTerm($searchArray[$i]);
		}
		$this->searchTermArray = $searchArray;
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
	
	//Step4
	public function recursive_array_searchPOS($arrayOfWords) {
		$keysArray = array();
		foreach($arrayOfWords as $key=>$word) {
			$firstSearchTerm = $this->firstSearchTerm;
			if(preg_match($firstSearchTerm, $word)) {
				$keysArray[] = $key;
			}
		}
		return $keysArray;
	}
	
	public function recursive_array_searchPOSCompare($arrayOfWords) {
		
		$keysArray = array();
		foreach($arrayOfWords as $key=>$word) {
			$firstSearchTerm = $this->firstSearchTermCompare;
			if(preg_match($firstSearchTerm, $word)) {
				$keysArray[] = $key;
			}
		}
		return $keysArray;
	}
	
		//Step1
	public function searchFilesPOS($files="") {
		$this->processSort();
		$this->filesToSearch->findFileNames($files);
		//Step2
		$fileNames = $this->filesToSearch->getFileNames();
		//Step2.1
		$this->firstSearchTermPOS();
		
		foreach($fileNames as $fileName) {
			$text = file_get_contents($fileName);
			$arrayOfWords = $this->arrayifyPOS($text);
			//Step4
			$keysArray = $this->recursive_array_searchPOS($arrayOfWords);
			$this->concordancePOS($arrayOfWords, $keysArray, $fileName);
			unset($arrayOfWords);
		}
		
		$this->sortLines();
		$count = count($this->arrayOfAllConcordanceLines);
		$processedConcordances = array();
		for($i=0; $i<$count; ++$i) {
			$left = implode(" ", array_reverse($this->arrayOfAllConcordanceLines[$i][0]));
			$left = str_replace("~", " ", $left);
			$node = "<strong>" . implode(" ", $this->arrayOfAllConcordanceLines[$i][1]) . "</strong>";
			$keyValue = array_pop($this->arrayOfAllConcordanceLines[$i][2]);
			$fileName = array_pop($this->arrayOfAllConcordanceLines[$i][2]);
			$shortFileName = str_replace("models/CorpusSearch/TAGGED CORPUS/", "", $fileName);
			$shortFileName = substr(strstr($shortFileName, "/", true), 0);
			$right = implode(" ", $this->arrayOfAllConcordanceLines[$i][2]);
			$right = str_replace("~", "", $right);
			$processedConcordances[$i] = array("file"=>$fileName, "left"=>$left, "node"=>$node, "right"=>$right, "folder"=>$shortFileName, "keyValue"=>$keyValue);
		}
		$this->arrayOfAllConcordanceLines = $processedConcordances;
		return $this->arrayOfAllConcordanceLines;
	}
	
	//step2.1
	public function firstSearchTermPOSCompare() {
		$searchArray = explode(" ", $this->searchTerm);
		$firstSearchTerm = $searchArray[0];
		$this->firstSearchTermCompare = $this->makeSearchTermCompare($firstSearchTerm);
		$searchArray[0] = $this->firstSearchTermCompare;
		
		for($i=1; $i<count($searchArray); $i++) {

				$searchArray[$i] = $this->makeSearchTermCompare($searchArray[$i]);
		}
		$this->searchTermArrayCompare = $searchArray;
	}
	
	private function makeSearchTermCompare($term) {
		
	//	if(substr($term, 0, 1) === "_") {
	//		//This case looks at when only the POS has been entered
	//		$term = $term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
	//		$term = "/\b[a-zA-Z0-9]*" . $term . "\b/";
	//	} else if(strpos($term, "_") === FALSE) {
	//		//This case looks at when only a word has been entered with a possible wildcard.
	//		$term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
	//		$term =  "/\b" . $term . "_[a-zA-Z0-9]*" . "\b/";
	//	} else {
	//		//This case looks at when both a word with a possible wildcard and a POS has been entered.
	//		$term = preg_replace("/\*/", "[a-zA-Z0-9]*", $term);
	//		$term = "/\b" . $term . "\b/";
	//	}
		$term = "/\b" . $term . "\b/";
		return $term;
	}
	
	
	public function searchFilesPOSCompare($files="") {
		$this->learnerFilesToSearch->findFileNames($files);
		//Step2
		$fileNames = $this->learnerFilesToSearch->getFileNames();
		//Step2.1
		$this->firstSearchTermPOSCompare();
		
		foreach($fileNames as $fileName) {
			$text = file_get_contents($fileName);
			$text = str_replace(array("\r", "\n"), ' ', $text);
			$arrayOfWords = $this->arrayifyPOS($text);
			//Step4
			$keysArray = $this->recursive_array_searchPOSCompare($arrayOfWords);
			$this->concordancePOSCompare($arrayOfWords, $keysArray, $fileName);
			unset($arrayOfWords);
		}
		
		$this->sortLinesCompare();
		$count = count($this->arrayOfAllLearnerConcordanceLines);
		$processedConcordances = array();
		for($i=0; $i<$count; ++$i) {
			$left = implode(" ", array_reverse($this->arrayOfAllLearnerConcordanceLines[$i][0]));
			$left = str_replace("~", " ", $left);
			$node = "<strong>" . implode(" ", $this->arrayOfAllLearnerConcordanceLines[$i][1]) . "</strong>";
			$keyValue = array_pop($this->arrayOfAllLearnerConcordanceLines[$i][2]);
			$fileName = array_pop($this->arrayOfAllLearnerConcordanceLines[$i][2]);
			$shortFileName = str_replace("models/CorpusSearch/LEARNER CORPUS/", "", $fileName);
			$shortFileName = substr(strstr($shortFileName, "/", true), 0);
			$right = implode(" ", $this->arrayOfAllLearnerConcordanceLines[$i][2]);
			$right = str_replace("~", "", $right);
			$processedConcordances[$i] = array("file"=>$fileName, "left"=>$left, "node"=>$node, "right"=>$right, "folder"=>$shortFileName, "keyValue"=>$keyValue);
		}
		$this->arrayOfAllLearnerConcordanceLines = $processedConcordances;
		return $this->arrayOfAllLearnerConcordanceLines;
	}
	
	//Step5
	public function concordancePOS($arrayOfWords, $keysArray, $fileName) {
		$searchTermArraySize = count($this->searchTermArray);
		foreach($keysArray as $value) {
			$concordance = "";
			$left = "";
			$node = "";
			$right = "";
			//Step6
			if($value-($this->width) >= 0 && $value+($this->width) <= count($arrayOfWords)) {
				//Step7
				for($j=0; $j<$searchTermArraySize; ++$j) {
					$arrayOfFirstWords[$j] = $arrayOfWords[$value+$j];
				}

				if($this->checkArrayMatchesSearchTermArrayPOS($arrayOfFirstWords) == true) {
					//Steps9 & 10
					for($i=-($this->width); $i<0; ++$i) {
						//tags get removed here in preparation for output
						//Later might want to store the tags for later retrieval.
						$position = strpos($arrayOfWords[$value+$i], "_");
						$word = substr($arrayOfWords[$value+$i], 0, $position);
						$left .= $word . " ";
					}
					$leftArray = explode(" ", $left);
					$leftArray = array_reverse($leftArray);
					//tags get removed here
					$position = strpos($arrayOfWords[$value], "_");
					$word = substr($arrayOfWords[$value], 0, $position);
					$node .= $word . " ";
					$nodeArray = explode(" ", $node);
					for($i=1; $i<($this->width); ++$i) {
						//tags get removed here.
						$position = strpos($arrayOfWords[$value+$i], "_");
						$word = substr($arrayOfWords[$value+$i], 0, $position);
						$right .= $word . " ";
					}
					$rightArray = explode(" ", $right);
					$rightArray[] = $fileName;
					$rightArray[] = $value;
					//Step11
					$concordanceLines = array();
					$concordanceLines[] = $leftArray;
					$concordanceLines[] = $nodeArray;
					$concordanceLines[] = $rightArray;
					if(!empty($concordanceLines)) {
						$this->arrayOfAllConcordanceLines[] = $concordanceLines;
					}
					unset($arrayOfFirstWords);
				} else {
					//Step8
					unset($arrayOfFirstWords);
				}
			}
		}
		//Step12
		
	}
	
	public function concordancePOSCompare($arrayOfWords, $keysArray, $fileName) {
		$searchTermArraySize = count($this->searchTermArrayCompare);
		foreach($keysArray as $value) {
			$concordance = "";
			$left = "";
			$node = "";
			$right = "";
			//Step6
			if($value-($this->width) >= 0 && $value+($this->width) <= count($arrayOfWords)) {
				//Step7
				for($j=0; $j<$searchTermArraySize; ++$j) {
					$arrayOfFirstWords[$j] = $arrayOfWords[$value+$j];
				}
				if($this->checkArrayMatchesSearchTermArrayPOSCompare($arrayOfFirstWords) == true) {
					//Steps9 & 10
					for($i=-($this->width); $i<0; ++$i) {
						$left .= $arrayOfWords[$value+$i] . " ";
					}
					$leftArray = explode(" ", $left);
					$leftArray = array_reverse($leftArray);
					$node .= $arrayOfWords[$value] . " ";
					$nodeArray = explode(" ", $node);
					for($i=1; $i<($this->width); ++$i) {
						$right .= $arrayOfWords[$value+$i] . " ";
					}
					$rightArray = explode(" ", $right);
					$rightArray[] = $fileName;
					$rightArray[] = $value;
					//Step11
					$concordanceLines = array();
					$concordanceLines[] = $leftArray;
					$concordanceLines[] = $nodeArray;
					$concordanceLines[] = $rightArray;
					if(!empty($concordanceLines)) {
						$this->arrayOfAllLearnerConcordanceLines[] = $concordanceLines;
					}
					unset($arrayOfFirstWords);
				} else {
					//Step8
					unset($arrayOfFirstWords);
				}
			}
		}
		//Step12
	}
	
	//Step7
	public function checkArrayMatchesSearchTermArrayPOS($arrayOfFirstWords) {
		$value = true;
		$count = count($arrayOfFirstWords);
		for($i=0; $i<$count; ++$i) {
			$searchTerm = $this->searchTermArray[$i];
			if(strpos($searchTerm, "_") == 0) {
				$position = strpos($arrayOfFirstWords[$i], "_");
				$POS = substr($arrayOfFirstWords[$i], $position);
				if(strcmp($searchTerm, $POS) == 0) {
					$value = true;
				} else {
					$value = false;
				}
			} else if (preg_match($this->searchTermArray[$i], $arrayOfFirstWords[$i]) === 0) {
				$value = false;
			}
		}
		return $value;
	}
	
	public function checkArrayMatchesSearchTermArrayPOSCompare($arrayOfFirstWords) {
				/*$fp = fopen('test4.txt', 'a');
				fwrite($fp, $arrayOfFirstWords);
				fclose($fp);*/
				
		$value = true;
		$count = count($arrayOfFirstWords);
		for($i=0; $i<$count; ++$i) {
			$searchTerm = $this->searchTermArrayCompare[$i];
			if (preg_match($this->searchTermArrayCompare[$i], $arrayOfFirstWords[$i]) === 0) {
				$value = false;
			}
		}
		//file_put_contents('text3.txt', print_r($value, true));
		return $value;
	}
	
	public function sortLines(){
		$sortArray1 = $this->sortArray[0];
		$sortArray2 = $this->sortArray[1];
		$sortArray3 = $this->sortArray[2];
		$array = $this->arrayOfAllConcordanceLines;
		usort($array, $this->sortMe($sortArray1, $sortArray2, $sortArray3));
		$this->colourTheWords($array, $sortArray1, $sortArray2, $sortArray3);
		$this->arrayOfAllConcordanceLines = $array;
		unset($array);
	}
	
	public function sortLinesCompare(){
		$sortArray1 = $this->sortArray[0];
		$sortArray2 = $this->sortArray[1];
		$sortArray3 = $this->sortArray[2];
		$array = $this->arrayOfAllLearnerConcordanceLines;
		usort($array, $this->sortMe($sortArray1, $sortArray2, $sortArray3));
		$this->colourTheWords($array, $sortArray1, $sortArray2, $sortArray3);
		$this->arrayOfAllLearnerConcordanceLines = $array;
		unset($array);
	}
	
	private function sortMe($sortArray1, $sortArray2, $sortArray3) {
		return function ($array1, $array2) use ($sortArray1, $sortArray2, $sortArray3) {
			$key1 = $sortArray1[0];
			$key2 = $sortArray1[1];
			if(strcasecmp($array1[$key1][$key2], $array2[$key1][$key2]) == 0) {
				$key1 = $sortArray2[0];
				$key3 = $sortArray2[1];
				if(strcasecmp($array1[$key1][$key3], $array2[$key1][$key3]) == 0) {
					$key1 = $sortArray3[0];
					$key4 = $sortArray3[1];
					return strcasecmp($array1[$key1][$key4], $array2[$key1][$key4]);
				} else return strcasecmp($array1[$key1][$key3], $array2[$key1][$key3]);
			} else return strcasecmp($array1[$key1][$key2], $array2[$key1][$key2]);
		};
	}
	
	private function colourTheWords(&$array, $sortarray1, $sortarray2, $sortarray3) {
			$firstWordPosition = &$sortarray1[1];
			$secondWordPosition = &$sortarray2[1];
			$thirdWordPosition = &$sortarray3[1];
			$leftOrRightOne = &$sortarray1[0];
			$leftOrRightTwo = &$sortarray2[0];
			$leftOrRightThree = &$sortarray3[0];
			
			for($i=0; $i<count($array); $i++) {
				$wordOne = &$array[$i][$leftOrRightOne][$firstWordPosition];
				$wordOne = "<span style=\"border:1px dotted black; color:blue\"><em>" . $wordOne . "</em></span>";
				$wordOneArray = array($firstWordPosition => $wordOne);
				$array[$i][$leftOrRightOne] = array_replace($array[$i][$leftOrRightOne], $wordOneArray);
				
				$wordTwo = &$array[$i][$leftOrRightTwo][$secondWordPosition];
				$wordTwo = "<span style=\"border:1px dotted black; color:red\"><em>" . $wordTwo . "</em></span>";
				$wordTwoArray = array($secondWordPosition => $wordTwo);
				$array[$i][$leftOrRightTwo] = array_replace($array[$i][$leftOrRightTwo], $wordTwoArray);
				
				$wordThree = &$array[$i][$leftOrRightThree][$thirdWordPosition];
				$wordThree = "<span style=\"border:1px dotted black; color:green\"><em>" . $wordThree . "</em></span>";
				$wordThreeArray = array($thirdWordPosition => $wordThree);
				$array[$i][$leftOrRightThree] = array_replace($array[$i][$leftOrRightThree], $wordThreeArray);
			}
	}
	
	public function getSource($filename, $keyValue) {
		
		$text = file_get_contents($filename);
		$text = $this->arrayifyPOS($text);
		$count = count($text);
		for($i=0; $i<$count; ++$i) {
			$position = strpos($text[$i], "_");
			$word = substr($text[$i], 0, $position);
			$text[$i] = $word;
		}
		$keyValue = intval($keyValue);
		$keyValueStart;
		$keyValueEnd;
		if($keyValue-80 < 0) {
			$keyValueStart = 0;
		} else {
			$keyValueStart = $keyValue-80;
		}
		
		if($keyValue+50 > $count) {
			$keyValueEnd = $count;
		} else {
			$keyValueEnd = $keyValue+80;
		}
		$source = "";
		for($i=$keyValueStart; $i<$keyValueEnd; ++$i) {
			if($i >= $keyValue-($this->width) && $i < $keyValue+($this->width)) {
				if($i == $keyValue) {
					$source .= "<span style=\"color:red\"><strong>" . $text[$i] . " " . "</strong></span>";
				} else {
					$source .= "<strong>" . $text[$i] . " " . "</strong>";
				}
			} else {
				$source .= $text[$i] . " ";
			}
		}
		
		return "<strong><span style=\"color:blue\">Source: " . $filename . "</br>" . "</strong></span>" . $source;
	}
	
	public function getListOfWords($files="") {
		$this->filesToSearch->findFileNames($files);

		$fileNames = $this->filesToSearch->getFileNames();

		$this->firstSearchTermPOS();
		
		foreach($fileNames as $fileName) {
			$text = file_get_contents($fileName);
			$arrayOfWords = $this->arrayifyPOS($text);
			$keysArray = $this->recursive_array_searchPOS($arrayOfWords);
			$this->listPOS($arrayOfWords, $keysArray, $fileName);
			unset($arrayOfWords);
		}
		arsort($this->foundArray);
		
		$dataToReturn = array("list"=>$this->foundArray, "listWithFiles"=>$this->foundArrayWithFile);
		return json_encode($dataToReturn);
		
	}
	
	private function listPOS($arrayOfWords, $keysArray, $filename) {
		$shortFilename = str_replace("models/CorpusSearch/TAGGED CORPUS/", "", $filename);
		$position = strpos($shortFilename, "/");
		$shortFilename = substr_replace($shortFilename, "", $position);
		$searchTermArraySize = count($this->searchTermArray);
		foreach($keysArray as $value) {
			$foundTerm = "";
			for($j=0; $j<$searchTermArraySize; ++$j) {
					$arrayOfFirstWords[$j] = $arrayOfWords[$value+$j];
				}
			
			if($this->checkArrayMatchesSearchTermArrayPOS($arrayOfFirstWords) == true) {
				
				for($i=0; $i<$searchTermArraySize; ++$i) {
						//tags get removed here in preparation for output
						//Later might want to store the tags for later retrieval.
						$position = strpos($arrayOfWords[$value+$i], "_");
						$word = substr($arrayOfWords[$value+$i], 0, $position);
						$foundTerm .= $word . " ";
					}
				if(array_key_exists($foundTerm, $this->foundArray)) {
					$this->foundArray[$foundTerm] += 1;
					if(array_key_exists($shortFilename, $this->foundArrayWithFile[$foundTerm])) {
						$this->foundArrayWithFile[$foundTerm][$shortFilename] += 1;
					} else {
						$this->foundArrayWithFile[$foundTerm][$shortFilename] = 1;
					}
				} else {
					$this->foundArray[$foundTerm] = 1;
					$this->foundArrayWithFile[$foundTerm][$shortFilename] = 1;
				}
				
				
			}
			unset($arrayOfFirstWords);
		}
	}
	
	public function collocateSearchPOS($collocate, $files="") {
		$this->processSort();
		$this->filesToSearch->findFileNames($files);
		$fileNames = $this->filesToSearch->getFileNames();
		$collocateSearch = $this->makeSearchTerm($collocate);
		$this->searchTerm = $this->makeSearchTerm($this->searchTerm);
		$this->searchTermArray = array($this->searchTerm);
		
		foreach($fileNames as $fileName) {
			$text = file_get_contents($fileName);
			$arrayOfWords = $this->arrayifyPOS($text);
			$keysArray = $this->collocate_array_searchPOS($arrayOfWords, $collocateSearch);
			$this->concordancePOS($arrayOfWords, $keysArray, $fileName);
			unset($arrayOfWords);
		}
		$this->sortLinesCollocates();
		$count = count($this->arrayOfAllConcordanceLines);
		$processedConcordances = array();
		for($i=0; $i<$count; ++$i) {
			$left = implode(" ", array_reverse($this->arrayOfAllConcordanceLines[$i][0]));
			$left = preg_replace("/\b". $collocate . "\b/", "<strong><span style=\"color:blue\">" . $collocate . "</span></strong>", $left);
			$left = str_replace("~", "", $left);
			$node = "<strong>" . implode(" ", $this->arrayOfAllConcordanceLines[$i][1]) . "</strong>";
			$keyValue = array_pop($this->arrayOfAllConcordanceLines[$i][2]);
			$fileName = array_pop($this->arrayOfAllConcordanceLines[$i][2]);
			$shortFileName = str_replace("models/CorpusSearch/TAGGED CORPUS/", "", $fileName);
			$shortFileName = substr(strstr($shortFileName, "/", true), 0);
			$right = implode(" ", $this->arrayOfAllConcordanceLines[$i][2]);
			$right = preg_replace("/\b" . $collocate . "\b/", "<strong><span style=\"color:blue\">" . $collocate . "</span></strong>", $right);
			$right = str_replace("~", "", $right);
			$processedConcordances[$i] = array("file"=>$fileName, "left"=>$left, "node"=>$node, "right"=>$right, "folder"=>$shortFileName, "keyValue"=>$keyValue);
		}
		$this->arrayOfAllConcordanceLines = $processedConcordances;
		return json_encode($this->arrayOfAllConcordanceLines);
	}
	
	private function collocate_array_searchPOS($arrayOfWords, $collocate) {
		$keysArray = array();
		$count = count($arrayOfWords);
		foreach($arrayOfWords as $key=>$word) {
			if(preg_match($this->searchTerm, $word)) {
				$leftCollocate=$key-3;
				$rightCollocate=$key+3;
				if($leftCollocate<0) $leftCollocate = 0;
				if($rightCollocate>$count) $rightCollocate = $count-1;
				for($i=$leftCollocate; $i<=$rightCollocate; ++$i) {
					if(preg_match($collocate, $arrayOfWords[$i])) {
						$keysArray[] = $key;
					}
				}
			}
		}
		return $keysArray;
	}
	
	public function sortLinesCollocates(){
		$sortArray1 = $this->sortArray[0];
		$sortArray2 = $this->sortArray[1];
		$sortArray3 = $this->sortArray[2];
		$array = $this->arrayOfAllConcordanceLines;
		usort($array, $this->sortMe($sortArray1, $sortArray2, $sortArray3));
		$this->arrayOfAllConcordanceLines = $array;
		unset($array);
	}
}

?>