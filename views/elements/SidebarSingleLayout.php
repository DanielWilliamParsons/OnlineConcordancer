<?php  // ../views/elements/SidebarSingleLayout.php

class SidebarSingleLayout {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_SIDEBAR = "class='col-sm-3 col-md-2 sidebar'";
	const WRAP_MAIN = "class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main' id='main'";
	const HEADER = "class='page-header'";
	
	public function __construct($sidebarContent, $mainContent, $mainHeader="") {
		$this->sidebarContent = $sidebarContent;
		$this->mainContent = $mainContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeSidebarSingleLayout() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getSidebarSingleLayout() {
		return $this->concatenate();
	}
	
	public function showSidebarSingleLayout() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$sidebar = $this->view->makeDiv(self::WRAP_SIDEBAR, $this->sidebarContent);
		$this->mainContent = ($this->view->makeTextWrap("h1", self::HEADER, $this->mainHeader)) . $this->mainContent;
		$main = $this->view->makeDiv(self::WRAP_MAIN, $this->mainContent);
		return $this->view->makeDiv(self::CONTAINER, $this->view->makeDiv(self::ROW, $sidebar . $main));
	}
	
}

?>