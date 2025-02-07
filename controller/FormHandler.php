<?php

require_once "SanitizeAndClean.php";

class FormHandler extends BaseController {
	private $data;
	public function __construct($urlvalues, $action, $data) {
		parent::__construct($urlvalues, $action);
		//$this->data = $data;
		//$this->redirect = $data['redirect'];
		$this->username = $_SESSION['username'];
		$this->userID = $_SESSION['t_id'];
		$this->model = new FormHandlerModel();
		$this->model->subscribe($this);
		$this->sanitizer = new SanitizeAndClean($this->model); //Use an adapter pattern to handle sanitizing inputted user data
		$this->sanitizer->setModelData($data); //sets up to fire sanitizing at the data
		$this->dataIsSanitized = false;
		$this->data = ""; //will be sanitized before being set
	}
	
	public function setData($data) {
		$this->data = $data;
	}
	
	protected function dataSuccessfullySanitized() {
		$this->dataIsSanitized = true;
	}
	
	public function deleteAnnouncement() {
		//Edit announcement database with a delete method
		$this->editModel(FormHandlerModel::DELETE);
	}
	
	public function updateAnnouncement() {
		//Edit the announcement database with an update method
		$this->editModel(FormHandlerModel::UPDATE);
	}
	
	public function addStudentToClass() {
		$this->editModel(FormHandlerModel::ADD);
	}
	
	public function removeStudentFromClass() {
		$this->editModel(FormHandlerModel::REMOVE);
	}
	
	private function editModel($methodName) {
		$this->sanitizer->passBackData(); //this fires the data to be sanitized
		
		if($this->dataIsSanitized == true) {
			$results = $this->model->editModel($this->data, $this->userID, $methodName);
		} else {
			$results['data'] = "Your input data was not properly sanitized and could not be entered into the database for security reasons!";
			$results['query_success'] = false;
		}
		
		
		if($results['query_success'] == true) {
			header('location:' . $this->data['redirect']);
		}
		
		//If there is no re-direct, then there was an error in processing the query in the database.
		$this->dealWithError($results);
	}
	
	private function editStudentsInClass($methodName) {
		
	}
	
	private function sanitizeIncomingData() {
		$cleanData;
		foreach($this->data as $key=>$value) {
			$key = $this->model->sanitizeInput($key);
			$value = $this->model->sanitizeInput($value);
			$cleanData[$key] = $value;
		}
		$this->data = $cleanData;
	}
	
	private function dealWithError($results) {
		$message = "Tooooo bad, there was an error. The error message is as follows: ";
		if(is_string($results)) {
			$message .= $results;
		} else if(is_array($results['data'])) {
					foreach($results['data'] as $key => $value) {
						$message .= $key . ": " . $value . ".<br/>";
					}
				} else {
					$message .= $results['data'];
				}
		
		$message .= "<br/> Click to go back.";
		$view = new FormHandlerView($this->username, $this->userID, $message, $this->data['redirect']);
		$view->formHandleError();
		$this->getView();
	}
		
	private function getView() {
		$view = View::instantiateView();
		$this->ReturnView($view->getScreenViewAsHTML()); //Sends the view to the base controller, who then renders it for the user.
	}
	
}

?>