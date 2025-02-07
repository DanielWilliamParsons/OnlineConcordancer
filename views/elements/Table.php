<?php

/*
	---TABLE---
	Data for the table should be provided such that headers and body rows have the same length, i.e.
	$header[0] = array("header1", "header2", "header3", "header4");
	$header[1] = array("headersecond1", "headersecond2", "headersecond3", "headersecond4"); //Two rows of headers
	$rowData[0] = array("data1", "data2", "data3", "data4");
	$rowData[1] = array("data5", "data6", "data7", "data8"); //Two rows of data
	$rowData[2] = array(array("data9", "data10", "data11", "data12"), $rowStyle1);  //style the row
*/
require_once "HTMLElement.php";

class Table {
	
	//Table styles
	const ClassTable = "table";
	const ClassTableStriped = "table-striped";
	const ClassTableBordered = "table-bordered";
	const ClassTabledStriped = "table-striped";
	const ClassTableHover = "table-hover";
	const ClassTableCondensed = "table-condensed";
	
	//Add responsive features
	const ClassTableResponsive = "table-responsive";
	
	//Style rows or cells
	const StyleActive = "active";
	const StyleSuccess = "success";
	const StyleWarning = "warning";
	const StyleDanger = "danger";
	const StyleInfo = "info";
	
	public function __construct(array $rowData, array $headers=array(), array $tableType, $tableResponsive=false) {
		$this->headers = $headers;
		$this->rowData = $rowData;
		$this->tableType = $tableType;
		$this->tableResponsive = $tableResponsive;
	}
	
	public function makeTable() {
		$view = View::instantiateView();
		$view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getTable() {
		return $this->concatenate();
	}
	
	public function showTable() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		
		//check there are headers
		$tableHead = "";
		if(empty($this->headers)) {
			$tableHead = "";
		} else {
			//build the headers
			$headCount = count($this->headers);
			$rowCount = count($this->rowData);
			
			/*Build the head of the table*/
			$headCount = count($this->headers);
			$tableHead = "<thead>";
			for($i=0; $i<$headCount; $i++) {
				$tableHead .= "<tr>";
				foreach($this->headers[$i] as $header) {
					$tableHead .= "<th>" . $header . "</th>";
				}
				$tableHead .= "</tr>";
			}
			$tableHead .= "</thead>"	;
		}
		
		//build the table rows
		$rowCount = count($this->rowData);
		$rowBody = "<tbody>";
		
		for($i=0; $i<$rowCount; $i++) {
		
			//Consider the case the row has styling, data looks like this:
			//$rowData[2] = (array("data9", "data10", "data11", "data12"), $rowStyle);
			if(is_array($this->rowData[$i][0])) {
				$rowBody .= "<tr class='" . $this->rowData[$i][1] . "' id='" . $i . "'>";
				$j = 1;
				foreach($this->rowData[$i][0] as $data) {
					$rowBody .="<td id='" . $i . $j . "'>" . $data . "</td>";
					++$j;
				}
			}
			
			//Consider the case the row has no styline then the data looks like this:
			//$rowData[2] = ("data9", "data10", "data11", "data12")
			if(is_string($this->rowData[$i][0])) {
				$rowBody .= "<tr id='" . $i . "'>";
					$j = 1;
					foreach($this->rowData[$i] as $data) {
						$rowBody .="<td id='" . $i . $j . "'>" . $data . "</td>";
						++$j;
					}	
				}
			$rowBody .= "</tr>";
		}
		
		$rowBody .= "</tbody>";
		
		//build the table type wrapper
		$class = "class='";
		foreach($this->tableType as $type) {
			$class .= $type . " ";
		}
		$class .= "'";
		$table = "<table " . $class . ">" . $tableHead . $rowBody . "</table>";
		
		//Add responsive features if requested
		if($this->tableResponsive == true) {
			$table = "<div class='" . self::ClassTableResponsive . "'>" . $table . "</div>";
		}
		return $table;
	}
	
	private function buffer($bigDataCount, $smallDataCount) {
		
	}
	
}

?>