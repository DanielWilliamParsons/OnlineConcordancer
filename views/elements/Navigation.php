<?php // ../views/Navigation.php

/*
	---NAVIGATION---
	
	navbarButtons and navbarButtonsRightButtons data should look like this:
		array navbarButtons['home'] = 'www.index.php';
		array navbarButtons['other'] = array('active', 'other.php');
			- the array key should be the name of the button
			- the array value should be the href

*/

class Navigation {

	const NAVBAR_HEADER_CLASS = "class='navbar_header'";
	const CONTAINER_CLASS = "class='container-fluid'";
	const BUTTON_CLASS = "class='nav navbar-nav'";
	const BUTTONS_RIGHT_CLASS = "class='nav navbar-nav navbar-right'";
	const NAVBAR_COLLAPSE_CLASS = "class='navbar-collapse collapse'";
	const NAVBAR_CLASS = "class='navbar navbar-fixed-top' role='navigation'";
	
	public function __construct($brandName="", $brandNameLink="", $navbarButtons = "", $navbarButtonsRightButtons = "") {
		
		$this->brandName = $brandName;
		$this->brandNameLink = $brandNameLink;
		$this->navbarButtons = $navbarButtons;
		$this->navbarButtonsRightButtons = $navbarButtonsRightButtons;
		$this->view = View::instantiateView();
		
	}
	
	//Sends the navbar to the HTMLElement's ScreenView property
	public function makeNavbar() {
		$navbar = $this->view->makeDiv(self::CONTAINER_CLASS, $this->navbarHeader().$this->navbarCollapse());
		$navbar = $this->view->makeDiv(self::NAVBAR_CLASS, $navbar);
		$this->view->pushHTMLtoScreenView($navbar);
	}
	
	//Sends the navbar to the caller
	public function getNavbar() {
		$navbar = $this->view->makeDiv(self::CONTAINER_CLASS, $this->navbarHeader().$this->navbarCollapse());
		return $this->view->makeDiv(self::NAVBAR_CLASS, $navbar);
	}
	
	//Outputs the navbar's raw HTML
	public function showNavbar() {
		$navbar = $this->view->makeDiv(self::CONTAINER_CLASS, $this->navbarHeader().$this->navbarCollapse());
		echo $this->view->makeDiv(self::NAVBAR_CLASS, $navbar);
	}
	
	private function navbarHeader() {
		$button = "<button type='button'
							class='navbar-toggle' data-toggle='collapse'
							data-target='.navbar-collapse'>
					<span class='sr-only'>Toggle Navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					</button>";
		$a = "<a class='navbar-brand href='" . $this->brandNameLink . "'>" . $this->brandName . "</a>";
		return $this->view->makeDiv(self::NAVBAR_HEADER_CLASS, $button.$a);
	}
	
	private function navbarCollapse() {
		return $this->view->makeDiv(self::NAVBAR_COLLAPSE_CLASS, $this->navbarButtons() . $this->navbarButtonsRight());
	}
	
	private function navbarButtons() {
		if(is_string($this->navbarButtons)) {
			return;
		}
		
		if(empty($this->navbarButtons)) {
			return;
		}
		
		$buttons = "";
		foreach($this->navbarButtons as $buttonName => $href) {
			
			if(is_array($href)) {
				$buttons .= "<li class='" . $href[0] . "'><a href='" . $href[1] . "'>" . $buttonName . "</a></li>";
			} else {
				$buttons .= "<li><a href='" . $href . "'>" . $buttonName . "</a></li>";
			}
		}
		
		return "<ul " . self::BUTTON_CLASS . ">" . $buttons . "</ul>";
	}
	
	private function navbarButtonsRight() {
		if(is_string($this->navbarButtonsRightButtons)) {
			return;
		}
		
		if(empty($this->navbarButtonsRightButtons)) {
			return;
		}
		
		$buttons = "";
		foreach($this->navbarButtonsRightButtons as $buttonName => $href) {
			
			if(is_array($href)) {
				$buttons .= "<li class='" . $href[0] . "'><a href='" . $href[1] . "'>" . $buttonName . "</a></li>";
				} else {
					$buttons .= "<li><a href='" . $href . "'>" . $buttonName . "</a></li>";
				}
			}

		
		return "<ul " . self::BUTTONS_RIGHT_CLASS . ">" . $buttons . "</ul>";
	}
}

?>