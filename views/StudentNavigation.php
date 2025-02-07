<?php   //   ../views/StudentNavigation.php

require_once "elements/Navigation.php";

class StudentNavigation {
	
	const CORPUS_BUTTON = "<span class='glyphicon glyphicon-book'></span>";
	const LEARNERCORPUS_BUTTON = "<span class='glyphicon glyphicon-pencil'></span>";
	const LOGOUT = "<span class='glyphicon glyphicon-log-out'></span>";
	
	public function __construct($brandName = "") {
		$this->brandName = $brandName;
		$this->buttonsRight['corpus'] = "index.php?controller=Corpus&action=index"; //corpus home
		$this->buttonsRight['learnercorpus'] = "index.php?controller=Corpus&action=learner"; //learner corpus
		$this->buttonsRight['logout'] = "index.php?controller=Logout&action=index"; //corpus home
	}
	
	public function makeStudentNavigation($activeLink = "") {
		$nav = $this->concatenate($activeLink);
		$nav->makeNavbar();
	}
	
	public function getStudentNavigation($activeLink = "") {
		$nav = $this->concatenate($activeLink);
		return $nav->getNavbar();
	}
	
	public function showStudentNavigation($activeLink = "") {
		$nav = $this->concatenate($activeLink);
		$nav->showNavbar();
	}
	
	private function concatenate($activeLink = "") {
		$homelink = "studentHome.php?controller=StudentHome&action=index";
		
		//Make the button clicked active.
		if(array_key_exists($activeLink, $this->buttonsRight)) {
			$this->buttonsRight["$activeLink"] = array('active', $this->buttonsRight["$activeLink"]);
		} else {
			$this->buttonsRight['corpus'] = array('active', $this->buttonsRight['corpus']);
		}
		
		//Make the buttons have glyphicons
		$buttons[self::CORPUS_BUTTON] = $this->buttonsRight['corpus'];
		$buttons[self::LEARNERCORPUS_BUTTON] = $this->buttonsRight['learnercorpus'];
		$buttons[self::LOGOUT] = $this->buttonsRight['logout'];
		
		if($this->brandName == "") {
			$this->brandName = "Corpus";
		}
		
		return new Navigation($this->brandName, "", "", $buttons);
		
	}
	
}

?>