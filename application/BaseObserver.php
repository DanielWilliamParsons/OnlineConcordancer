<?php
require_once "BaseSubject.php";
abstract class BaseObserver {
	public function __construct($subject=null) {
		if(is_object($subject) && $subject instanceof BaseSubject) {
			$subject -> attach($this);
		}
	}
	
	public function update($subject) {
		if(method_exists($this, $subject->getState())) {
			call_user_func_array(array($this, $subject->getState()), array($subject));
		}
	}
}

?>