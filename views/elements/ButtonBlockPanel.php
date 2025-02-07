<?php  // ../views/elements/ButtonBlockPanel.php
require_once "Button.php";

/*

	---BUTTONPANEL---
	The data, $buttons, passed to construct ButtonPanel should look like this:
		array $buttons['title'] = array('class'=>'someclass', 'id'=>'someid', 'href'=>'somehref');
	To add a tooltip to a button write like this:
		array $buttons['title'] = array('class'=>'someclass', 'id'=>'someid', 'href'=>'somehref', 'tooltip'=>array('placement', 'title'))
		//Note, if adding a tooltip, a modal cannot be added with a different data-toggle as part of the attributes - maybe...

*/

class ButtonBlockPanel {
	
	public function __construct($panelTitle = "", array $buttons, $appendedText = "") {
		$this->panelTitle = "<h3>" . $panelTitle . "</h3>";
		$this->buttons = $buttons;
		$this->appendedText = $appendedText;
		//Styling for the panel
		$this->buttonBlockStyle = "id='button_block'";
		$this->buttonPanelStyle = "id='buttonPanel'";
		
		$this->view = View::instantiateView();
	}
	
	//pushes the button block to the HTMLElement's ScreenView property
	public function makeButtonPanel() {
		$this->view->pushHTMLtoScreenView($this->concatenateButtonBlock());
	}
	
	//Returns the button block to the caller
	public function getButtonPanel() {
		return $this->concatenateButtonBlock();
	}
	
	//Outputs the raw button block HTML code
	public function showButtonPanel() {
		echo $this->concatenateButtonBlock();
	}
	
	private function concatenateButtonBlock() {
		$buttonBlock = "";
		foreach($this->buttons as $title=>$attributes) {
			$button = new Button($title, $attributes['href'], $attributes['class'], $attributes['id']);
			
			if(array_key_exists('tooltip', $attributes)) {
				$button->addTooltip($attributes['tooltip'][0], $attributes['tooltip'][1]);
			}
			
			if(array_key_exists('otherAttributes', $attributes)) {
				$button->addOtherAttributes($attributes['otherAttributes']);
			}
			$buttonBlock .= $button->getButton();
		}
		$buttonBlock .= $this->appendedText;
		$buttonBlock = $this->view->makeDiv($this->buttonBlockStyle, $this->panelTitle . $buttonBlock);
		return $this->view->makeDiv($this->buttonPanelStyle, $buttonBlock);
	}
}

?>