<?php  // ../views/elements/SidebarQuadPanelLayout.php

class SidebarQuadPanelLayout {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const ROW_TOP = "class='row'";
	const ROW_BOTTOM = "class='row'";
	const WRAP_SIDEBAR = "class='col-sm-3 col-md-2 sidebar'";
	const WRAP_MAIN_TOP_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-top-left'";
	const WRAP_MAIN_TOP_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-top-right'";
	const WRAP_MAIN_BOTTOM_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-bottom-left'";
	const WRAP_MAIN_BOTTOM_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-bottom-right'";
	const WRAP_MAIN = "class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main' id='main'";
	const HEADER = "class='page-header'";
	
	public function __construct($sidebarContent, $topLeftContent, $topRightContent, $bottomLeftContent, $bottomRightContent, $mainHeader="") {
		$this->sidebarContent = $sidebarContent;
		$this->topLeftContent = $topLeftContent;
		$this->topRightContent = $topRightContent;
		$this->bottomLeftContent = $bottomLeftContent;
		$this->bottomRightContent = $bottomRightContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeSidebarQuadPanelLayout() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getSidebarQuadPanelLayout() {
		return $this->concatenate();
	}
	
	public function showSidebarQuadPanelLayout() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$sidebar = $this->view->makeDiv(self::WRAP_SIDEBAR, $this->sidebarContent);
		
		$topLeft = $this->view->makeDiv(self::WRAP_MAIN_TOP_LEFT, $this->topLeftContent);
		$topRight = $this->view->makeDiv(self::WRAP_MAIN_TOP_RIGHT, $this->topRightContent);
		$top = $this->view->makeDiv(self::ROW_TOP, $topLeft.$topRight);
		
		$bottomLeft = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM_LEFT, $this->bottomLeftContent);
		$bottomRight = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM_RIGHT, $this->bottomRightContent);
		
		$main = $this->view->makeDiv(self::ROW_BOTTOM, $topLeft.$topRight.$bottomLeft.$bottomRight);
		
		$header = $this->view->makeTextWrap("h1", self::HEADER, $this->mainHeader);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header . $main);
		


		return $this->view->makeDiv(self::CONTAINER, $this->view->makeDiv(self::ROW, $sidebar . $main));
	}
	
}

?>