<?php     //    ../controllers/Corpus.php

class Corpus extends BaseController {
	
	public function __construct($action, $urlvalues) {
		$this->StartSession();
		if($_SESSION['status'] != 'authorised') {
			header("location: index.php");
		}
		parent::__construct($action, $urlvalues);
		$this->username = $_SESSION['username'];
		$this->userID = $_SESSION['id'];
		$this->model = new CorpusModel();
	}
	
	public function index() {
		
		/***
		At this point, put into session variable
		all info associated with username and id
		***/
		
		$viewData = ""; //later, associate with user data.
		
		$indexView = new CorpusView($this->username, $this->userID, $viewData);
		$indexView->index();
		$this->getView();
	}
	
	public function learner() {
		
		$viewData = "";
		$learnerView = new CorpusView($this->username, $this->userID, $viewData);
		$learnerView->learner();
		$this->getView();
		
	}
	
	public function search() {
		$data = array("corpusName"=>$_POST['corpusName'],
						"searchTerm"=>strtolower(trim($_POST['searchTerm'])),
						"outputType"=>$_POST['outputType'],
						"inputType"=>$_POST['inputType'],
						"sort1"=>$_POST['sort1'],
						"sort2"=>$_POST['sort2'],
						"sort3"=>$_POST['sort3'],
						"username"=>$this->username);
		$concordanceData = $this->model->search($data);
		echo $concordanceData;
	}
	
	public function getSource() {
		$data = array("searchString"=>strtolower(trim($_POST['searchString'])),
						"filename"=>$_POST['filename'],
						"keyValue"=>$_POST['keyValue'],
						"inputType"=>"getSource",
						"username"=>$this->username);
		$sourceData = $this->model->getSource($data);
		echo $sourceData;
	}
	
	public function listOfWords() {
		$data = array("corpusName"=>$_POST['corpusName'],
						"searchTerm"=>strtolower(trim($_POST['searchTerm'])),
						"outputType"=>$_POST['outputType'],
						"inputType"=>$_POST['inputType'],
						"sort1"=>$_POST['sort1'],
						"sort2"=>$_POST['sort2'],
						"sort3"=>$_POST['sort3'],
						"username"=>$this->username);
		$listOfWords = $this->model->search($data);
		echo $listOfWords;
	}
	
	public function collocations() {
		$searchTerm = $this->checkSearchTerm(strtolower(trim($_POST['searchTerm'])));
		$data = array("corpusName"=>$_POST['corpusName'],
						"searchTerm"=>$searchTerm,
						"outputType"=>$_POST['outputType'],
						"inputType"=>$_POST['inputType'],
						"sort1"=>$_POST['sort1'],
						"sort2"=>$_POST['sort2'],
						"sort3"=>$_POST['sort3'],
						"username"=>$this->username);
		$listOfCollocations = $this->model->search($data);
		echo $listOfCollocations;
	}
	
	public function collocateSearch() {
		$searchTerm = $_POST['searchTerm'];
		$searchTerm = str_replace("/\b", "", $searchTerm);
		$searchTerm = str_replace("_[a-zA-Z0-9]*\b/", "", $searchTerm);
		$searchTerm = str_replace("[a-zA-Z0-9]", "", $searchTerm);
		$data = array("corpusName"=>$_POST['corpusName'],
						"searchTerm"=>trim($searchTerm),
						"outputType"=>$_POST['outputType'],
						"inputType"=>$_POST['inputType'],
						"collocate"=>$_POST['collocate'],
						"sort1"=>$_POST['sort1'],
						"sort2"=>$_POST['sort2'],
						"sort3"=>$_POST['sort3'],
						"username"=>$this->username);
		$concordanceData = $this->model->collocateSearch($data);
		echo $concordanceData;
	}
	
	public function searchCompare() {
		$data = array("searchTerm"=>strtolower(trim($_POST['searchTerm'])),
						"outputType"=>$_POST['outputType'],
						"inputType"=>$_POST['inputType'],
						"sort1"=>$_POST['sort1'],
						"sort2"=>$_POST['sort2'],
						"sort3"=>$_POST['sort3'],
						"username"=>$this->username);
		$concordanceData = $this->model->searchCompare($data);
		$concordanceData = json_encode($concordanceData);
		echo $concordanceData;
	}
	
	private function checkSearchTerm($searchTerm) {
			$searchTerm = explode(" ", $searchTerm);
			$searchTerm = $searchTerm[0];
		return $searchTerm;
	}
	
	public function manage() {
		
		/***
		At this point, put into session variable
		all info associated with username and id
		***/
		
		$viewData = ""; //later, associate with user data.
		
		$manageView = new CorpusView($this->username, $this->userID, $viewData);
		$manageView->manage();
		$this->getView();
	}
	
	public function myCorpus() {
		
		/***
		At this point, put into session variable
		all info associated with username and id
		***/
		
		$viewData = ""; //later, associate with user data.
		
		$myCorpusView = new CorpusView($this->username, $this->userID, $viewData);
		$myCorpusView->myCorpus();
		$this->getView();
	}
	
	private function getView() {
		$view = View::instantiateView();
		$this->ReturnView($view->getScreenViewAsHTML()); //Sends the view to the base controller, who then renders it for the user.
	}
	
}