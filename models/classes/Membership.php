<?php //  ../models/classes/Membership.php

class Membership {

	public function __construct() {
		
	}
	
	static $thisClass = false;
	
	public static function instantiateMembership() {
		if(self::$thisClass == false) {
			return self::$thisClass = new Membership();
		} else {
			return self::$thisClass;
		}
	}
	
	public function confirm_member() {
		if($_SESSION['status'] != 'authorised') {
			header("location: index.php");
		} else {
			return true;
		}
	}
	
}

?>