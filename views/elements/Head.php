<?php

class Head {
	
	public function __construct($header="") {
		$this->header = $header;
		$this->view = View::instantiateView();
	}
	
	public function addJavascript($source, $type="") {
		if(is_array($source)) {
			foreach($source as $src) {
				$attributes = "";
				if($type == "") {
					$attributes .= "src='" . $src . "'";
				} else {
					$attributes .= "type='" . $type . "' src='" . $scr . "'";
				}
		
				$javascript = $this->view->makeTextWrap("script", $attributes, "");
				$this->addToHeader($javascript);
			} //end of foreach
		} //end of if so now assume string
		if(is_string($source)) {
			$attributes = "";
			if($type == "") {
				$attributes .= "src='" . $source . "'";
			} else {
				$attributes .= "type='" . $type . "' src='" . $source . "'";
				}	
			$javascript = $this->view->makeTextWrap("script", $attributes, "");
			$this->addToHeader($javascript);
		}
	}
	
	public function addFonts($link, $rel="", $type="") {
		if(is_array($link)) {
			foreach($link as $href) {
				$attributes = "href='" . $href . "' ";
				if($rel !== "") {
					$attributes .= "rel='" . $rel . "' ";
				}
				if($type !== "") {
					$attributes .= "type='" . $type . "' ";
				}
				$fonts = $this->view->makeLinkWrap("link", $attributes, "");
				$this->addToHeader($fonts);
			}
		}
		
		if(is_string($link)) {
			$attributes = "href='" . $link . "' ";
			if($rel !== "") {
				$attributes .= "rel='" . $rel . "' ";
			}
			if($type !== "") {
				$attributes .= "type='" . $type . "' ";
			}
			$fonts = $this->view->makeLinkWrap("link", $attributes, "");
			$this->addToHeader($fonts);
		}
		
	}
	
	public function addStylesheet($link) {
		if(is_array($link)) {
			foreach($link as $href) {
				$attributes = "rel='stylesheet' href='" . $href . "'";
				$stylesheet = $this->view->makeLinkWrap("link", $attributes);
				$this->addToHeader($stylesheet);
			}
		}
		
		if(is_string($link)) {
			$attributes = "rel='stylesheet' href='" . $link . "'";
			$stylesheet = $this->view->makeLinkWrap("link", $attributes);
			$this->addToHeader($stylesheet);
		}
		
	}
	
	public function compileHeader() {
		$this->view->pushHTMLtoScreenView($this->header . "</head><body>");
	}
	
	public function setHeader($header) {
		$this->header = $header;
	}
	
	private function addToHeader($headerElements) {
		$this->header = $this->header . $headerElements;
	}
	
}

?>