<?php   //  ../views/TeacherNavigation.php

/*
	---NON-GENERIC NAVBAR---
	This contents of this navbar are fixed and can only be alterred by re-coding
	The button which is highlighted can be chosen when calling a method to concatenate
	the navbar.
		Enter as a string either 'home', 'lessons', or 'activities' to highlight the relevant button.

*/

require_once "elements/Navigation.php";

class TeacherNavigation {
	const CORPUS_BUTTON = "<span class='glyphicon glyphicon-book'></span>";
	const LEARNERCORPUS_BUTTON = "<span class='glyphicon glyphicon-pencil'></span>";
	const LOGOUT = "<span class='glyphicon glyphicon-log-out'></span>";
	
	public function __construct($brandName = "") {
		$this->brandName = $brandName;
		$this->buttonsRight['corpus'] = "index.php?controller=Corpus&action=index"; //corpus home
		$this->buttonsRight['learnercorpus'] = "index.php?controller=Corpus&action=learner"; //learner corpus
		$this->buttonsRight['logout'] = "index.php?controller=Logout&action=index"; //corpus home
	}
	
	//Sends the teacherNavigation to the HTMLElement's ScreenView property
	public function makeTeacherNavigation($activeLink="") {
		$nav = $this->concatenate($activeLink);
		$nav->makeNavbar(); //navbar is sent to the screenView property of HTMLElement class
	}
	
	//Returns the TeacherNavigation to the caller
	public function getTeacherNavigation($activeLink="") {
		$nav = $this->concatenate($activeLink);
		return $nav->getNavbar();
	}
	
	//Outputs the TeacherNavigation's raw HTML
	public function showTeacherNavigation($activeLink="") {
		$nav = $this->concatenate($activeLink);
		$nav->showNavbar();
	}
	
	private function concatenate($activeLink = "") {
		
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