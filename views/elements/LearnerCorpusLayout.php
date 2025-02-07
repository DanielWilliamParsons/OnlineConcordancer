<?php   //   ../views/elements/CorpusLayout.php

class LearnerCorpusLayout {
	
	const CONTAINER = "class='container-fluid'";
	const ROW = "class='row'";
	const WRAP_MAIN_LEFT = "class='col-sm-12 col-md-12 col-lg-6 main-left' id='main-top-left-learner'";
	const WRAP_MAIN_RIGHT = "class='col-sm-12 col-md-12  col-lg-6 main-right' id='main-top-right-learner'";
	const WRAP_MAIN_BOTTOM = "class='col-sm-12 col-md-12 col-lg-12 main-bottom' id='main-bottom-learner'";
	const WRAP_MAIN = "class='col-sm-12 col-md-12 main' id= 'main'";
	const HEADER = "class='corpus_interface'";
	
	public function __construct($topLeftContent, $topRightContent, $bottomContent, $mainHeader="") {
		$this->leftContent = $topLeftContent;
		$this->rightContent = $topRightContent;
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
		$topLeft = $this->view->makeDiv(self::WRAP_MAIN_LEFT, $this->leftContent);
		$topRight = $this->view->makeDiv(self::WRAP_MAIN_RIGHT, $this->rightContent);
		$bottom = $this->view->makeDiv(self::WRAP_MAIN_BOTTOM, $this->bottomContent);
		
		$main = $this->view->makeDiv(self::ROW, $topLeft.$topRight.$bottom);
		
		$header = $this->view->makeTextWrap("h4", self::HEADER, $this->mainHeader);
		$main = $this->view->makeDiv(self::WRAP_MAIN, $header.$main);
		
		return $this->view->makeDiv(self::CONTAINER, $main);
	}
		
}

?>