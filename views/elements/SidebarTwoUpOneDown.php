<?php  // ../views/elements/SidebarTwoUpOneDown.php

class SidebarTwoUpOneDown {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_SIDEBAR = "class='col-sm-3 col-md-2 sidebar'";
	const WRAP_MAIN_TOP_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-top-left'";
	const WRAP_MAIN_TOP_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-top-right'";
	const WRAP_MAIN_BOTTOM = "class='col-sm-12 col-md-12 main-left' id='main-bottom'";
	const WRAP_MAIN = "class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main' id='main'";
	const HEADER = "class='page-header'";
	
	public function __construct($sidebarContent, $topLeftContent, $topRightContent, $bottomContent, $mainHeader="") {
		$this->sidebarContent = $sidebarContent;
		$this->topLeftContent = $topLeftContent;
		$this->topRightContent = $topRightContent;
		$this->bottomContent = $bottomContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeSidebarTwoUpOneDown() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getSidebarTwoUpOneDown() {
		return $this->concatenate();
	}
	
	public function showSidebarTwoUpOneDown() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$sidebar = $this->view->makeDiv(self::WRAP_SIDEBAR, $this->sidebarContent);
		
		$topLeft = $this->view->makeDiv(self::WRAP_MAIN_TOP_LEFT, $this->topLeftContent);
		$topRight = $this->view->makeDiv(self::WRAP_MAIN_TOP_RIGHT, $this->topRightContent);
		$bottom = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM, $this->bottomContent);
		
		$main = $this->view->makeDiv(self::ROW, $topLeft.$topRight.$bottom);
		
		$header = $this->view->makeTextWrap("h1", self::HEADER, $this->mainHeader);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header . $main);
		


		return $this->view->makeDiv(self::CONTAINER, $this->view->makeDiv(self::ROW, $sidebar . $main));
	}
	
}

?>