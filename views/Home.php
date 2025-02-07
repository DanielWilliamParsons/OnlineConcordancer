
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Corpus</title>
	<meta name="description" content="Manage your English Class, teachers and students alike">
	<meta name="viewport" content="width=device-width">
	<style>
		body {
			padding-top: 00px;
			padding-bottom: 0px;
			}
	</style>
	
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,500' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lustria' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/home.css">
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <?php
require_once "views/elements/Form.php";
require_once "views/elements/ButtonBlockPanel.php";
$teacherForm = new Form("POST", "index.php?controller=Login&action=index", false);
$teacherForm->addTextInput(false, "username", "", "Username", 20, "teacher", "form-control", "", "");
$teacherForm->addPasswordInput(false, "password", "", "Password", 100, "teacher", "form-control", "", "");
$teacherForm->addHiddenInput("usertype", "", "teacher");
$teacherForm->addSubmitButton("Login", "btn btn-success", "", "", "");

$studentForm = new Form("POST", "index.php?controller=Login&action=index", false);
$studentForm->addTextInput(false, "username", "", "Username", 20, "student", "form-control", "", "");
$studentForm->addPasswordInput(false, "password", "", "Password", 100, "student", "form-control", "", "");
$studentForm->addHiddenInput("usertype", "", "student");
$studentForm->addSubmitButton("Login", "btn btn-success", "", "", "");
?>
    <body>
    
        	<div class="modal fade" id="teacherModal" role="dialog" aria-labelledby="teacherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="teacherModalLabel">Teacher Login</h5>
      </div>
      
      <div class="modal-body">
        <?php $teacherForm->showForm();?>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>		
			
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="studentModalLabel">Student Login</h5>
      </div>
      <div class="modal-body">
      	<?php $studentForm->showForm();?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
    
    	<div class="container-fluid">
    		<h4 id="title">Corpus</h4>
    		
    		<div class="row">
    			
    			
    			
    			<div class="col-sm-6 col-xs-6 col-lg-6 col-sm-offset-3 col-xs-offset-3 col-lg-offset-3">
    				<div id="buttonPanel">
    					<div id="button_block">
    						<h3>Log in</h3>
	    					<button class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#teacherModal">Teacher</button>
						<button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#studentModal">Student</button>
    					</div>
    				</div>
    			</div>
    			
    			
    		</div>
    	</div>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="js/modal.js"></script>
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>