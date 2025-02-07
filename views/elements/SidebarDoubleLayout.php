<?php  // ../views/elements/SidebarDoubleLayout.php

class SidebarDoubleLayout {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_SIDEBAR = "class='col-sm-3 col-md-2 sidebar'";
	const WRAP_MAIN_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-left'";
	const WRAP_MAIN_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-right'";
	const WRAP_MAIN = "class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main' id='main'";
	const HEADER = "class='page-header'";
	
	public function __construct($sidebarContent, $mainLeftContent, $mainRightContent, $mainHeader="") {
		$this->sidebarContent = $sidebarContent;
		$this->mainLeftContent = $mainLeftContent;
		$this->mainRightContent = $mainRightContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeSidebarDoubleLayout() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getSidebarDoubleLayout() {
		return $this->concatenate();
	}
	
	public function showSidebarDoubleLayout() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$sidebar = $this->view->makeDiv(self::WRAP_SIDEBAR, $this->sidebarContent);
		$header = ($this->view->makeTextWrap("h1", self::HEADER, $this->mainHeader));
		$mainLeft = $this->view->makeDiv(self::WRAP_MAIN_LEFT, $this->mainLeftContent);
		$mainRight = $this->view->makeDiv(self::WRAP_MAIN_RIGHT, $this->mainRightContent);
		
		$main = $this->view->makeDiv(self::ROW, $mainLeft.$mainRight);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header . $main);
		
		return $this->view->makeDiv(self::CONTAINER, $this->view->makeDiv(self::ROW, $sidebar . $main));
	}	
}

?>