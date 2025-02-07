$(function() {
    $( "#startdate" ).datepicker();
  });
  
$(function() {
    $( "#finishdate" ).datepicker();
  });

tinymce.init( {
	selector: "textarea",
	theme: "modern",
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code",
        "insertdatetime table contextmenu paste emoticons template paste textcolor wordcount"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullest numlist outdent indent | link image"
});

function editClass(class_id) {
	request = new ajaxRequest()
	params = "class_id=" + class_id.value
	params += "&ajax_action=" + "editClass"
	params += "&ajax_controller=" + "ClassAdminAjax"
	request.open("POST", "ajax.php", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", params.length) // -- Turns out the browser sets these to prevent scripting attacks!
	//request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null)
					O('main').innerHTML = this.responseText
	}
	request.send(params)
}

/*
	---CREATE CLASS---
	create class validation and ajax functions begin here
*/
function validateForm() {
	var valid = true;
	var classname = document.getElementById("classname");
	valid = validateClassname(classname.value);
	valid = validateDate(document.getElementById("startdate").value)
	if(valid == true) {
		createClass();
	}
}

function validateClassname(classname) {
	switch (classname) {
		case "":
			$("<p class='text-danger'>Required Field: Please write a class name!</p>").insertAfter('#classname');
			$("#classname").addClass('error');
			return false;
			break;
		}
	return true;
}

function validateDate(startdate) {
	if(startdate=="") {
		$("<p class='text-danger'>Required Field: Please choose a start date!</p>").insertAfter('#startdate');
		$("#startdate").addClass('error');
		return false;
	} return true;
}

function createClass() {
	request = new ajaxRequest()
	var classname = document.getElementById("classname")
	var active = document.getElementById("active")
	var syllabus_data = document.getElementById("syllabus_data")
	var date_start = document.getElementById("startdate")
	var date_finish = document.getElementById("finishdate")
	var file_link = document.getElementById("file_link")
	params = "ajax_action=" + "createClass"
	params += "&ajax_controller=" + "ClassAdminAjax"
	params += "&classname=" + classname.value
	params += "&classDetails=" + tinymce.get("classDetails").getContent();
	params += "&active=" + active.checked
	params += "&syllabus_data=" + syllabus_data.value
	params += "&date_start=" + date_start.value
	params += "&date_finish=" + date_finish.value
	params += "&file_link=" + file_link.value
	request.open("POST", "ajax.php", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", params.length) // -- Turns out the browser sets these to prevent scripting attacks!
	//request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null)
					O('createClassForm').innerHTML = this.responseText
	}
	request.send(params)
}


/*
	---ADD STUDENTS---
	Add student validation and ajax calls begin here

*/
function validateAddStudent() {
	var valid = true;
	valid = validateName(document.getElementById("studentname").value);
	valid = validateUsername(document.getElementById("username").value);
	valid = validatePasswords(document.getElementById("studentpassword1").value, document.getElementById("studentpassword2").value);
	if(valid == true) {
		addStudent();
	}
}


function validateName(name) {

$(function() {
	$("#studentname").change(function() {
		$("#form-message").hide(1000);
		$("#studentname").removeClass('error');
	});
});
	
	if(name.length > 6 && name.length < 30) {
		if(name.match(/[^a-zA-Z ]/) == null) {
			return true;
		} else {
			$("<p class='text-danger' id='form-message'>Name should contain only a-z and A-Z letters, no numbers.</p>").insertAfter('#studentname');
			$("#studentname").addClass('error');
			return false;
		} 
	} else {
		$("<p class='text-danger' id='form-message'>Name should be longer than 6 characters and shorter than 30.</p>").insertAfter('#studentname');
		$("#studentname").addClass('error');
		return false;
	}
}

function validateUsername(username) {

$(function() {
	$("#username").change(function() {
		$("#form-message2").hide(1000);
		$("#username").removeClass('error');
	});
});
	
	if(username.length > 6 && username.length < 30) {
		if(username.match(/[^a-zA-Z0-9]/) == null) {
			return true;
		} else {
			$("<p class='text-danger' id='form-message2'>Username should contain only letters and numbers</p>").insertAfter('#username');
			$("#username").addClass('error');
			return false;
		} 
	} else {
		$("<p class='text-danger' id='form-message2'>Username should be longer than 6 characters and shorter than 30.</p>").insertAfter('#username');
		$("#username").addClass('error');
		return false;
	}
}

function validatePasswords(pwd1, pwd2) {
	
$(function() {
	$("#studentpassword1").change(function() {
		$("#form-message3").hide(1000);
		$("#studentpassword1").removeClass('error');
	});
	
	$("#studentpassword2").change(function() {
		$("#form-message3").hide(1000);
		$("#studentpassword2").removeClass('error');
	});
});
	if(pwd1 !== pwd2) {
		$("<p class='text-danger' id='form-message3'>Please re-type your password. They don't match!</p>").insertAfter('#studentpassword2');
		$("#studentpassword2").addClass('error');
		return false;
	} 
	
	if(pwd1.length > 6 && pwd1.length < 30) {
			if(pwd1.match(/[a-z]/) !== null && pwd1.match(/[A-Z]/) !== null && pwd1.match(/[0-9]/) !== null) {
				return true;
				} else {
					$("<p class='text-danger' id='form-message3'>For security, please mix numbers with upper and lower case letters in the password</p>").insertAfter('#studentpassword2');
					$("#studentpassword2").addClass('error');
					return false;
				} 
			} else {
				$("<p class='text-danger' id='form-message3'>Passwords should be longer than 6 characters and shorter than 30.</p>").insertAfter('#studentpassword2');
				$("#studentpassword2").addClass('error');
				return false;
			}
}

function checkUsername(username) {

$(function() {
	$("#username").change(function() {
		$("#form-message4").hide(1000);
		$("#username").removeClass('error');
	});
});

	if (username.value == '') {
		$("<p class='text-danger' id='form-message4'>Username required!</p>").insertAfter('#username');
		$("#username").addClass('error');
		return
	}
	params = "ajax_action=" + "checkUsername"
	params += "&ajax_controller=" + "ClassAdminAjax"
	params += "&username=" + username.value
	request = new ajaxRequest()
	request.open("POST", "ajax.php", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", params.length)
	//request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null) {
					$(this.responseText).insertAfter('#username');
					$("#username").addClass('success');
				}
	}
	request.send(params)
}

var i = 1; //This is for below, so on a single session a teacher can see how many entries they have made
			//It just makes the form a little more user friendly.

function addStudent() {
	
	var output = "<p>Insert number " + i.toString() + ":</p>";
	params = "ajax_action=" + "addStudent"
	params += "&ajax_controller=" + "ClassAdminAjax"
	params += "&username=" + (document.getElementById("username").value)
	params += "&studentname=" + (document.getElementById("studentname").value)
	params += "&studentpassword1=" + (document.getElementById("studentpassword1").value)
	request = new ajaxRequest()
	request.open("POST", "ajax.php", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", params.length)
	//request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null) {
					$(output + this.responseText + "<hr>").insertAfter('#go');
					++i;
				}
	}
	request.send(params)
}


/*
	---AJAX REQUESTS---
	
*/
function ajaxRequest() {
	try {
		var request = new XMLHttpRequest()
	}
	catch(e1) {
		try {
			request = new ActiveXObject("Msxm12.XMLHTTP")
		}
		catch(e2) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP")
			}
			catch(e3) {
				request = false
			}
		}
	}
	return request
}

function O(obj) {
	if (typeof obj == 'object') return obj
	else return document.getElementById(obj)
}

function S(obj) {
	return O(obj).style
}

function C(name) {
	var elements = document.getElementsByTagName('*')
	var objects = [ ]
	
	for (var i = 0; i< elements.length; ++i) {
		if (elements[i].className == name) {
			objects.push(elements[i])
		}
	}
	return objects
}