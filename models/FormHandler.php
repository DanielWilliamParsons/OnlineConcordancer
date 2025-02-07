<?php //  ../models/FormHandler.php

require_once "classes/Query.php";
require_once "classes/Sanitizer.php";
require_once "classes/Validator.php";
require_once "defines/dbdefines.php";
require_once "classes/Observer.php";
require_once "classes/ISanitizer.php";

class FormHandlerModel extends BaseModel implements ISanitizer{
	
	//Edit type constants here
	//Used to decide which query to call in the Query() object
	const DELETE = 'deleteAnnouncement';
	const UPDATE = 'updateAnnouncement';
	const ADD = "addStudentToClass";
	const REMOVE = "removeStudentFromClass";
	
	public function construct() {
		parent::__construct();
	}
	
	public function editModel($announcement_data, $t_id, $editType) {
		//Initiate validator and query objects
		$query = new Query();
		$validator = Validator::instantiateValidator();
		
		//Add the name of the query method to the data so the validator can send a message to this method.
		$announcement_data['queryMethodName'] = $editType;
		$announcement_data['t_id'] = $t_id;
		
		//Query instance subscribes to the validator to decide what to do
		$validator->subscribe($query);
		
		//If validated, query method getAnnouncements() will begin, if not, query cannot begin.
		//Data necessary for the query will have been set through the Validator class AFTER validation
		//Then the data is passed to MySQL object where it is processed and the results fed back to
		//the $query object right here!
		$validator->validateClassId($announcement_data);
		
		$results['query_success'] = $query->getQuerySuccess();
		$results['data'] = $query->getData();
		return $results;

	}
	
	public function sanitizeData() {
		$sanitizer = Sanitizer::instantiateSanitizer();
		$this->modelData = $sanitizer->sanitizeData($this->getModelData());
		$observers = $this->getObservers(); //observer is the controller
			foreach($observers as $observer) {
				$observer->setData($this->modelData); //pass back the sanitized data to the model
			}
			$this->setState('dataSuccessfullySanitized');
	}
	
	public function sanitizeOutput($data) {
		$sanitizer = Sanitizer::instantiateSanitizer();
		return $sanitizer->returnHTML($data);
	}
	
	public function sanitizeInput($data) {
		$sanitizer = Sanitizer::instantiateSanitizer();
		return $sanitizer->wipeAllHTML($data);
	}
	
}
?>