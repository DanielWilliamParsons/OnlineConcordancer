<?php  //  ../models/Corpus.php

require_once "classes/Sanitizer.php";
require_once "classes/Validator.php";
require_once "classes/Observer.php";
require_once "CorpusSearch/Search.php";
require_once "CorpusSearch/Collocation.php";
require_once "CorpusSearch/TrackUsers.php";

class CorpusModel extends BaseModel {
	
	public function construct() {
		parent::__construct();
	}
	
	public function search($data) {
		$searchTerm = $this->sanitize($data['searchTerm']);
		$corpusName = $this->sanitize($data['corpusName']);
		$outputType = $this->sanitize($data['outputType']);
		$inputType = $this->sanitize($data['inputType']);
		
		$sortTerms = array();
		$sortTerms[] = $data['sort1'];
		$sortTerms[] = $data['sort2'];
		$sortTerms[] = $data['sort3'];
		
		$username = $data['username'];
		
		$tracking = new TrackUsers($data);
		$tracking->saveInteraction();
		if($outputType === "KWIC") {
			$search = new Search($searchTerm, $sortTerms);
			switch($corpusName) {
				case "Search All":
					$data = $search->searchFilesPOS();
					break;
				case "Science Texts":
					$data = $search->searchFilesPOS("Sci_Study");
					break;
				case "Essay Texts":
					$data = $search->searchFilesPOS(array("Non_fiction", "Sci_News"));
					break;
				case "Science and Essay Texts":
					$data = $search->searchFilesPOS(array("Non_fiction", "Sci_News", "Sci_Study"));
					break;
				case "Fiction Texts":
					$data = $search->searchFilesPOS("Fiction");
					break;
				default:
					$data = $search->searchFilesPOS();
			}
		$data = json_encode($data);
		return $data;
		} else if ($outputType === "List") {
			$search = new Search($searchTerm);
			switch($corpusName) {
				case "Search All":
					$data = $search->getListOfWords();
					break;
				case "Science Texts":
					$data = $search->getListOfWords("Sci_Study");
					break;
				case "Essay Texts":
					$data = $search->getListOfWords(array("Non_fiction", "Sci_News"));
					break;
				case "Science and Essay Texts":
					$data = $search->getListOfWords(array("Non_fiction", "Sci_News", "Sci_Study"));
					break;
				case "Fiction Texts":
					$data = $search->getListOfWords("Fiction");
					break;
				default:
					$data = $search->getListOfWords();
			}
		return $data;
		} else if ($outputType ==="Collocations") {
			$collocation = new Collocation($searchTerm);
			switch($corpusName) {
				case "Search All":
					$data = $collocation->searchFilesPOS();
					break;
				case "Science Texts":
					$data = $collocation->searchFilesPOS("Sci_Study");
					break;
				case "Essay Texts":
					$data = $collocation->searchFilesPOS(array("Non_fiction", "Sci_News"));
					break;
				case "Science and Essay Texts":
					$data = $collocation->searchFilesPOS(array("Non_fiction", "Sci_News", "Sci_Study"));
					break;
				case "Fiction Texts":
					$data = $collocation->searchFilesPOS("Fiction");
					break;
				default:
					$data = $collocation->searchFilesPOS();
			}
		return $data;
		}	
	}
	
	public function collocateSearch($data) {
		$searchTerm = $this->sanitize($data['searchTerm']);
		$corpusName = $this->sanitize($data['corpusName']);
		$outputType = $this->sanitize($data['outputType']);
		$inputType = $this->sanitize($data['inputType']);
		$collocate = $this->sanitize($data['collocate']);
		
		$sortTerms = array();
		$sortTerms[] = $data['sort1'];
		$sortTerms[] = $data['sort2'];
		$sortTerms[] = $data['sort3'];
		
		$username = $data['username'];
		
		$tracking = new TrackUsers($data);
		$tracking->saveCollocateInteraction();
		$search = new Search($searchTerm, $sortTerms);
		$data = $search->collocateSearchPOS($collocate);
		return $data;
	}
	
	public function getSource($data) {
		$searchString = $data['searchString'];
		$filename = $data['filename'];
		$keyValue = $data['keyValue'];
		
		$tracking = new TrackUsers($data);
		$tracking->saveWiderContextLookup();
		
		$search = new Search($searchString);
		return $search->getSource($filename, $keyValue);
	}
	
	public function searchCompare($data) {
		$searchTerm = $this->sanitize($data['searchTerm']);
		$outputType = $this->sanitize($data['outputType']);
		$inputType = $this->sanitize($data['inputType']);
		
		$sortTerms = array();
		$sortTerms[] = $data['sort1'];
		$sortTerms[] = $data['sort2'];
		$sortTerms[] = $data['sort3'];
		
		$username = $data['username'];
		
		$tracking = new TrackUsers($data);
		$tracking->saveInteraction();
		$search = new Search($searchTerm, $sortTerms, "yes");
		$KWICData['original'] = $search->searchFilesPOS();
		/*
		$data['List'] = $search->getListOfWords();
		$numberOfWordsInSearch = explode(' ', $searchTerm);
		$numberOfWordsInSearch = count($numberOfWordsInSearch);
		if($numberOfWordsInSearch === 1) {
			$collocations = new Collocation($searchTerm);
			$data['Collocations'] = $collocations->searchFilesPOS();
		} else {
			$data['Collocations'] = "Sorry, collocations cannot be calculated for your search term as yet.";
		}*/
		$KWICData['learner'] = $search->searchFilesPOSCompare();
		$KWICData = json_encode($KWICData);

		switch (json_last_error()) {
        case JSON_ERROR_NONE:
            file_put_contents('jsonErrorFile.txt', ' - No errors');
        break;
        case JSON_ERROR_DEPTH:
             file_put_contents('jsonErrorFile.txt',' - Maximum stack depth exceeded');
        break;
        case JSON_ERROR_STATE_MISMATCH:
            file_put_contents('jsonErrorFile.txt', ' - Underflow or the modes mismatch');
        break;
        case JSON_ERROR_CTRL_CHAR:
            file_put_contents('jsonErrorFile.txt', ' - Unexpected control character found');
        break;
        case JSON_ERROR_SYNTAX:
            file_put_contents('jsonErrorFile.txt', ' - Syntax error, malformed JSON');
        break;
        case JSON_ERROR_UTF8:
            file_put_contents('jsonErrorFile.txt', ' - Malformed UTF-8 characters, possibly incorrectly encoded');
        break;
        default:
            file_put_contents('jsonErrorFile.txt', ' - Unknown error');
        break;
    }
		file_put_contents('returnData.txt', print_r($KWICData, true));
		return $KWICData;
	}
	
	private function sanitize($data) {
		$sanitizer = Sanitizer::instantiateSanitizer();
		return $sanitizer->wipeAllHTML($data);
	}
	
	
}