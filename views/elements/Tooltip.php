<?php

abstract class Tooltip {
	
	public function __construct() {
		//Tooltip properties
		$this->data_toggle = "data-toggle='tooltip'";
		$this->data_placement = "data-placement=";
		$this->tooltipTitle = "title=";
	}
	
	abstract protected function addTooltip($data_placement, $title);
	
	abstract protected function addPopover($contentID, $placement, $container, $delay, $popoverTitle, $popoverContent);
	
}

?>