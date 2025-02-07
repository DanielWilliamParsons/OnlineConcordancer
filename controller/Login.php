<?php

class Login extends BaseController{
	
	public function __construct($action, $urlvalues) {
		parent::__construct($action, $urlvalues);
		$this->post['username'] = $_POST['username'];
		$this->post['password'] = $_POST['password'];
		$this->post['usertype'] = $_POST['usertype'];
	}
	
	protected function index() {
		$this->StartSession(); //Start a session, but no need to confirm member since not yet confirmed.
		$model = new LoginModel($this->post);
		$data = $model->verify_un_and_pw();
		$_SESSION['username'] = $this->post['username'];
		$_SESSION['usertype'] = $this->post['usertype'];
		/*
			---Successful Validation and Verification---
			re-locate the teacher or student to their home page.
		*/
		if($data === null) {
			if($model->getPost()['usertype'] === "teacher") {
				$_SESSION['id'] = "teacher_id";
				header("location: index.php?controller=Corpus&action=index");
			}
			
			if($model->getPost()['usertype'] === "student") {
				$_SESSION['id'] = "student_id";
				header("location: index.php?controller=Corpus&action=index");
			}
		}
		
		/*
			---Unsuccessful Validation or verification---
			Build a view to explain what the problem was and have the user
			attempt to log in one more time.
		*/
		
		if($data !== null) {
			$view = new LoginView();
			if(is_array($data['message'])) {
				foreach($data['message'] as $message) {
					$view->sendMessage($message);
				}
			} else {
				$view->sendMessage($data['message']);
			}
			$this->ReturnView($view->createView());
		}
		
	}
	
}

?>