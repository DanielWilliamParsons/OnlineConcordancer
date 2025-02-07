<?php    //  ../views/elements/corpusTemplates/CorpusInterface.php

class CorpusInterface {
	
	public function __construct($user) {
		$this->view = View::instantiateView();
		$this->user = $user;
	}
	
	public function makeCorpusInterface() {
		if(substr($this->user, 0, 8) == "teacher_") {
			$this->view->pushHTMLtoScreenView($this->concatenateTeacher());
		} else if (substr($this->user, 0, 8) == "student_") {
			$this->view->pushHTMLtoScreenView($this->concatenateStudent());
		}
	}
	
	public function getCorpusInterface() {
		if(substr($this->user, 0, 8) == "teacher_") {
			return $this->concatenateTeacher();
		} else if (substr($this->user, 0, 8) == "student_") {
			return $this->concatenateStudent();
		}
	}
	
	public function showCorpusInterface() {
		if(substr($this->user, 0, 8) == "teacher_") {
			echo $this->concatenateTeacher();
		} else if (substr($this->user, 0, 8) == "student_") {
			echo $this->concatenateStudent();
		}
	}
	
	private function concatenateTeacher() {
		$searchInterface = $this->concatenate();
		//$searchInterface .= "&nbsp;<a href='index.php?controller=Corpus&action=manage'>Manage</a></form>";
		return $searchInterface;
	}
	
	private function concatenateStudent() {
		$searchInterface = $this->concatenate();
		//$searchInterface .= "&nbsp;<a href='index.php?controller=Corpus&action=myCorpus'>My Corpus</a></form>";
		return $searchInterface;
	}
	
	private function concatenate() {

		$searchInterface = "<form class='form-inline' id='corpus_form'>
					<div class='form-group form-inline'>
						<select id='which_corpus' class='form-control'>
							<option>Search All</option>
							<option>Science Texts</option>
							<option>Essay Texts</option>
							<option>Science and Essay Texts</option>
							<option>Fiction Texts</option>
						</select>
						<a id='CorpusChoicetool' href='#' data-container='body' data-placement='bottom' data-toggle='popover' title='Choose which corpus to use.'
															data-content='There are many files you can search. You can look at easy science texts, or easy essay texts, or graded reader fiction texts'>?</a>
						<script>
							$('#CorpusChoicetool').popover()
						</script>
					</div>
					<div class='form-group form-inline'>
						<input type='text' id='searchForm' class='form-control' name='corpus_search' placeholder='Type your search term.'>
					</div>
					<div class='form-group form-inline'>
						<select id='what_output' class='form-control'>
							<option>KWIC</option>
							<option>List</option>
							<option>Collocations</option>
						</select>
						<a id='Typetool' href='#' data-container='body' data-placement='bottom' data-toggle='popover' title='Choose your output.'
															data-content='On searching, you can have different kinds of output. A list will give you a list of all the words you searched for and their frequencies in the corpus.
																			KWIC means Key Word In Context, so you will see examples of your search term in different situations.'>?</a>
						<script>
							$('#Typetool').popover()
						</script>
					</div>
					<button type='button' class='btn btn-md btn-success form-inline' onclick='sendSearch()'>Search</button>
					<div class='form-group form-inline'>
						<select id='sort1' class='form-control'>
							<option>3L</option>
							<option>2L</option>
							<option>1L</option>
							<option selected>1R</option>
							<option>2R</option>
							<option>3R</option>
						</select>
						<select id='sort2' class='form-control'>
							<option>3L</option>
							<option>2L</option>
							<option>1L</option>
							<option>1R</option>
							<option selected>2R</option>
							<option>3R</option>
						</select>
						<select id='sort3' class='form-control'>
							<option>3L</option>
							<option>2L</option>
							<option>1L</option>
							<option>1R</option>
							<option>2R</option>
							<option selected>3R</option>
						</select>
						<a id='Sort' href='#' data-container='body' data-placement='bottom' data-toggle='popover' title='Choose your output.'
															data-content='You can choose how your search is sorted. The sort is alphabetical.'>?</a>
						<script>
							$('#Sort').popover()
						</script>
					</div>
					<div class='form-group form-inline'>
						<a id='collocation' onclick='collocation()'>Collocation Check</a>
					</div>
					</form>
					<script>
					$('form :input').on('keypress', function(e) {
						return e.keyCode != 13;
						});
					</script>";
		return $searchInterface;
	}
	
}

?>