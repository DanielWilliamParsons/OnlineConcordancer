<?php  // ../views/elements/SidebarNav.php

/*
	---SIDEBAR NAVIGATION---
	This provides buttons for navigation
	The data passed to this should be for the list, and look like this:
		array $buttons['title1'] = array('active', 'index.php');
		array $buttons['title2'] = 'index2.php';

*/

class SidebarNav {
	
	const NAV_CLASS = "class='nav nav-sidebar'";
	const NAV_CLASS_EXTRA = "class='nav nav-sidebar nav-extra'";
	
	public function __construct(array $buttons) {
		
		$this->buttons = $buttons;
		$this->view = View::instantiateView();
		$this->extraButtons = "";
		$this->frontElements = "";
		$this->backElements = "";
	}
	
	public function addNavButtons(array $buttons) {
		$link = "";
		foreach($buttons as $title=>$href) {
			if(is_array($href)) {
				$link .= "<li class='" . $href[0] . "'><a href='" . $href[1] . "'>" . $title . "</a></li>";
			} else {
				$link .= "<li><a href='" . $href . "'>" . $title . "</a></li>";
			}
		}
		$link = $this->view->makeTextWrap("ul", self::NAV_CLASS_EXTRA, $link);
		$this->extraButtons .= $link;
	}
	
	public function addFrontElements($elementHTML) {
		$this->frontElements = $elementHTML;
	}
	
	public function addBackElements($elementHTML) {
		$this->backElements = $elementHTML;
	}
	
	//Push the nav to the HTMLElement's ScreenView. Should never need to do this!
	public function makeSidebarNav() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	//Return the nav to the caller - most likely used since this is content, not just layout
	public function getSidebarNav() {
		return $this->concatenate();
	}
	
	//Outputs the nav's raw HTML
	public function showSidebarNav() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$link = "";
		foreach($this->buttons as $title => $href) {
			if(is_array($href)) {
				$link .= "<li class='" . $href[0] . "'><a href='" . $href[1] . "'>" . $title . "</a></li>";
			} else {
				$link .= "<li><a href='" . $href . "'>" . $title . "</a></li>";
			}
		}
		return $this->frontElements . $this->view->makeTextWrap("ul", self::NAV_CLASS, $link) . $this->extraButtons . $this->backElements;
	}
	
}

?>