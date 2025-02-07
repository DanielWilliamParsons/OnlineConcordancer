<?php //   ../views/elements/corpusTemplates/ManagerView.php

class ManagerView {

	public function __construct() {
		$this->view = View::instantiateView();
	}
	
	public function makeManagerView() {
		$this->view->pushHTMLtoScreenView($this->concatenate());
	}
	
	public function getManagerView() {
		return $this->concatenate();
	}
	
	public function showManagerView() {
		echo $this->concatenate();
	}
	
	private function concatenate() {
		$science = "science";
		$graded_reader = "graded_reader";
		$studentWriting = "studentWriting";
		$manager = "<div class='btn-group-vertical'>
					<h4>Uploads</h4>
					<hr>
					<button class='btn btn-primary btn-md' onclick='corpusUploadScience()'>Upload Science Corpus File</button>
					<button class='btn btn-success btn-md' onclick='corpusUploadGradedReader()'>Upload Graded Reader Corpus File</button>
					<button class='btn btn-warning btn-md' onclick='corpusUploadStudentWriting()'>Upload Student Writing Corpus File</button>
					</div>
					<h4>My saved work</h4>
					<hr>
						";
		return $manager;
	}
	
}

?>