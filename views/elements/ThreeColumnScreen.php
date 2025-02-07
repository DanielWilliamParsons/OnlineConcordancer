<?php

class ThreeColumnScreen {
	
	public function __construct() {
		$this->view = View::instantiateView();
		$this->title = "";
		$this->leftContent = "";
		$this->middleContent = "";
		$this->rightContent = "";
		$this->ratio = array(4, 4, 4);
	}
	
	public function setLeftContent($content) {
		$colWidth = $this->ratio[0];
		$class = "class='col-xs-" . $colWidth . " col-md-" . $colWidth . "' ";
		$this->leftContent = $this->view->makeDiv($class, $content);
	}
	
	public function setMiddleContent($content) {
		$colWidth = $this->ratio[1];
		$class = "class='col-xs-" . $colWidth . " col-md-" . $colWidth . "' ";
		$this->middleContent = $this->view->makeDiv($class, $content);
	}
	
	public function setRightContent($content) {
		$colWidth = $this->ratio[2];
		$class = "class='col-xs-" . $colWidth . " col-md-" . $colWidth . "' ";
		$this->rightContent = $this->view->makeDiv($class, $content);
	}
	
	public function setMiddleContentFromOffset($content, $width, $offset) {
		$class = "class='col-sm-" . $width . " col-xs-" . $width . " col-lg-" . $width . 
					" col-sm-offset-" . $offset . " col-xs-offset-" . $offset . " col-lg-offset-" . $offset . "' ";
		$this->middleContent = $this->view->makeDiv($class, $content);
	}
	
	public function setTitle($title, $hSize="") {
		if($hSize=="") {
			$h = "h4";
		} else {
			$h = "h" . $hSize;
		}
		$this->title = $this->view->makeTextWrap($h, "", $title);
	}
	
	public function setRatio($left, $middle, $right) {
		if($left+$middle+$right <= 12) {
			$this->ratio = array($left, $middle, $right);
		} else {
			if($left+$middle <= 12) {
				$this->ratio = array($left, $middle, 12-($left+$middle));
			} else {
				$this->ratio = array($left, (12-$left), 0);
			}
		}
	}
	
	public function compileScreen($containerType="") {
		if($containerType == "") {
			$containerType = "class='container-fluid'";
		}
		$row = $this->view->makeDiv("class='row'", $this->leftContent . $this->middleContent . $this->rightContent);
		$row = $this->title . $row;
		$container = $this->view->makeDiv($containerType, $row);
		$this->view->pushHTMLtoScreenView($container);
	}
}



?>