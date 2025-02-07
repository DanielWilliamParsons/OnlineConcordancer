<?php  // ../views/elements/SidebarOneUpTwoDown.php

class SidebarOneUpTwoDown {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_SIDEBAR = "class='col-sm-3 col-md-2 sidebar'";
	const WRAP_MAIN_BOTTOM_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-bottom-left'";
	const WRAP_MAIN_BOTTOM_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-bottom-right'";
	const WRAP_MAIN_TOP = "class='col-sm-12 col-md-12 main-top' id='main-top'";
	const WRAP_MAIN = "class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main' id='main'";
	const HEADER = "class='page-header'";
	
	public function __construct($sidebarContent, $topContent, $bottomLeftContent, $bottomRightContent, $mainHeader="") {
		$this->sidebarContent = $sidebarContent;
		$this->bottomLeftContent = $bottomLeftContent;
		$this->bottomRightContent = $bottomRightContent;
		$this->topContent = $topContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeSidebarOneUpTwoDown() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getSidebarOneUpTwoDown() {
		return $this->concatenate();
	}
	
	public function showSidebarOneUpTwoDown() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$sidebar = $this->view->makeDiv(self::WRAP_SIDEBAR, $this->sidebarContent);
		
		$bottomLeft = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM_LEFT, $this->bottomLeftContent);
		$bottomRight = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM_RIGHT, $this->bottomRightContent);
		$top = $this->view->makeDiv(self::WRAP_MAIN_TOP, $this->topContent);
		
		$main = $this->view->makeDiv(self::ROW, $top.$bottomLeft.$bottomRight);
		
		$header = $this->view->makeTextWrap("h1", self::HEADER, $this->mainHeader);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header . $main);
		


		return $this->view->makeDiv(self::CONTAINER, $this->view->makeDiv(self::ROW, $sidebar . $main));
	}
	
}

?>