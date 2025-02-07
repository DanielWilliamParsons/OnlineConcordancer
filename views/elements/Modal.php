<?php
require_once "HTMLElement.php";
class Modal {
	public function __construct($id, $modalTitle, $modalContent) {
		$this->view = View::instantiateView();
		$this->id = $id;
		$this->modalTitle = $modalTitle;
		$this->modalContent = $modalContent;
		$this->dialog = "class='modal-dialog'";
		$this->content ="class='modal-content'";
		$this->wrapper = "";
	}
	
	private function createHeader() {
		$headDiv = "<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
					<h5 class='modal-title' id='" . $this->id . "Label'>" . $this->modalTitle . "</h5></div>";
		
		return $headDiv;
	}
	
	private function createBody() {
		$bodyDiv = "<div class='modal-body'>" . $this->modalContent . 
					"</div>";
		
		return $bodyDiv;
	}
	
	private function createFooter() {
		$footerDiv = "<div class='modal-footer'>
						<button type='button' class='btn btn-default'
							data-dismiss='modal'>Close</button>
						</div>";
		return $footerDiv;
	}
	
	private function makeAttributesArray() {
		return array($this->content, $this->dialog, $this->makeWrapper());
	}
	
	private function makeWrapper() {
		return "class='modal fade' id='" . $this->id . 
				"' role='dialog' aria-labelledby='" . $this->id . "Label' 
				tabindex='-1' aria-hidden='true'";
	}
	
	public function createModal() {
		$innerHTML = $this->createHeader() .
						$this->createBody() . 
						$this->createFooter();
		$arrayOfAttributes = $this->makeAttributesArray();
		foreach($arrayOfAttributes as $attribute) {
			$innerHTML = $this->view->makeDiv($attribute, $innerHTML);
		}

		$this->view->pushHTMLtoScreenView($innerHTML);
	}
	
	public function getModal() {
		$innerHTML = $this->createHeader() .
						$this->createBody() . 
						$this->createFooter();
		$arrayOfAttributes = $this->makeAttributesArray();
		foreach($arrayOfAttributes as $attribute) {
			$innerHTML = $this->view->makeDiv($attribute, $innerHTML);
		}
		return $innerHTML;
	}
	
}

?>