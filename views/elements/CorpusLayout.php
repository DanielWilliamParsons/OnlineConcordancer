<?php   //   ../views/elements/CorpusLayout.php

class CorpusLayout {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_MAIN_TOP_LEFT = "class='col-sm-6 col-md-6 main-left' id='main-top-left'";
	const WRAP_MAIN_TOP_RIGHT = "class='col-sm-6 col-md-6 main-right' id='main-top-right'";
	const WRAP_MAIN_BOTTOM = "class='col-sm-12 col-md-12 main-bottom' id = 'main-bottom'";
	const WRAP_MAIN = "class='col-sm-12 col-md-12 main' id= 'main'";
	const HEADER = "class='corpus_interface'";
	
	public function __construct($topLeftContent, $topRightContent, $bottomContent, $mainHeader="") {
		$this->topLeftContent = $topLeftContent;
		$this->topRightContent = $topRightContent;
		$this->bottomContent = $bottomContent;
		$this->mainHeader = $mainHeader;
		$this->view = View::instantiateView();
	}
	
	public function makeCorpusLayout() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getCorpusLayout() {
		return $this->concatenate();
	}
	
	public function showCorpusLayout() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$topLeft = $this->view->makeDiv(self::WRAP_MAIN_TOP_LEFT, $this->topLeftContent);
		$topRight = $this->view->makeDiv(self::WRAP_MAIN_TOP_RIGHT, $this->topRightContent);
		$bottom = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM, $this->bottomContent);
		
		$main = $this->view->makeDiv(self::ROW, $topLeft.$topRight.$bottom);
		
		$header = $this->view->makeTextWrap("h4", self::HEADER, $this->mainHeader);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header.$main);
		
		return $this->view->makeDiv(self::CONTAINER, $main);
	}
		
}

?>