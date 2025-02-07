<?php  // ../views/elements/AssignmentWrapper.php
require_once 'AssignmentsMain.php';
/*
	---DATA---
	The data supplied on construction should look like this:
	$dataArray[0]['topTitle'] = "Title";
	$dataArray[0]['content'] = "This is some content";
	$dataArray[0]['bottom'] = "This is yet to be decided what will go in here - stats about performance and links probably";
	$dataArray[1]['topTitle'] = "Another Title";
	
*/
class AssignmentsWrapper implements LinkedList{
	
	public function __construct($dataArray) {
		$this->view = View::instantiateView();
		$this->panelWrap[0]['class'] = 'leftInfoPanel';
		$this->panelWrap[1]['class'] = 'col-xs-12 col-sm-6 col-md-4 col-lg-3';
		
		$this->panelTop = "class='infoTitle'";
		$this->panelMain = "class='infoIntro'";
		$this->panelBottom = "class='infoOptions'";
		
		$this->dataArray = $dataArray;
		$this->assignment = ""; //This will be created in makeContent()
	}
	
	public function makeContent($toolbox) {
		$assignment = "";
		$i = 1;
		foreach($this->dataArray as $value) {
			if($this->checkForOdd($i) == true) { //Here we are making the colors alternate for the wrapping around the text
				$this->panelWrap[0]['class'] = 'leftInfoPanel';
			} else {
				$this->panelWrap[0]['class'] = 'rightInfoPanel';
			}
			$top = $this->view->makeDiv($this->panelTop, $this->view->makeTextWrap("p", "", $value['topTitle']));
			$content = $this->view->makeDiv($this->panelMain, $this->view->makeTextWrap("p", "", $value['content']));
			$bottom = $this->view->makeDiv($this->panelBottom, $this->view->makeTextWrap("p", "", $value['bottom']));
			$assignment = $top . $content . $bottom;
			
			foreach($this->panelWrap as $attribute) {
			$divAttribute="";
				foreach($attribute as $key=>$value) {
					$divAttribute .= $key . "='" . $value . "'";
				}
				$assignment = $this->view->makeDiv($divAttribute, $assignment);
			}
			$this->assignment .= $assignment;	
			++$i;
		}	
	}
	
	public function nextContent() {
		return new AssignmentsMain($this->assignment);
	}
	
	private function checkForOdd($i) {
		$j = $i/2;
		if(is_integer($j)) {
			return false;
		} else return true;
	}
	
}

?>