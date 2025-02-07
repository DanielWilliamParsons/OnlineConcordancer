/*
	---ADD ANNOUNCEMENT---
*/

function validateAddAnnouncement() {
	valid = true;
	valid = validateTitle(document.getElementById("announcement_title").value);
	valid = validateAnnouncement(document.getElementById("announcement").value);
	if(valid == true) {
		addAnnouncement();
	}
}

function validateTitle(title) {
$(function() {
	$("#announcement_title").change(function() {
		$("#form-message").hide(1000);
		$("#announcement_title").removeClass('error');
	});
});

	if(title=="") {
		$("<p class='text-danger' id='form-message'>There is nothing here! Cannot be empty.</p>").insertAfter('#announcement_title');
		$("#announcement_title").addClass('error');
		return false;
	} else {
		return true;
	}
}

function validateAnnouncement(announcement) {

$(function() {
	$("#announcement").change(function() {
		$("#form-message2").hide(1000);
		$("#announcement").removeClass('error');
	});
});

	if(announcement=="") {
		$("<p class='text-danger' id='form-message2'>There is nothing here! Cannot be empty.</p>").insertAfter('#announcement');
		$("#announcement").addClass('error');
		return false;
	} else {
		return true;
	}
}

function addAnnouncement() {
	request = new ajaxRequest()
	class_id = document.getElementById("class_id");
	t_id = document.getElementById("t_id");
	title = document.getElementById("announcement_title");
	announcement = document.getElementById("announcement");
	
	params = "class_id=" + class_id.value
	params += "&t_id=" + t_id.value
	params += "&title=" + title.value
	params += "&announcement=" + announcement.value
	
	params += "&ajax_action=" + "addAnnouncement";
	params += "&ajax_controller=" + "ClassAdminAjax";
	
	request.open("POST", "ajax.php", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", params.length) // -- Turns out the browser sets these to prevent scripting attacks!
	//request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null) {
					$(this.responseText).insertAfter('#go');
					$("#go").addClass('success');
					title.value = "";
					announcement.value = "";
				}
	}
	request.send(params)
}

/*
	---EDIT ANNOUNCEMENT---
	TO LINE 300
*/

function editAnnouncement(sender) {	
	
	if(document.getElementById("EditingInProgress") !== null) {
		$("#EditingInProgress").hide(500, function() {
			$("#createClassForm").remove();
			makeNewForm(sender);
		});
	} else {
		makeNewForm(sender);
	}
}

function makeNewForm(sender) {
	//Not sure why I called this button
	//It is, in fact, the <td> that the button is in
	//When we know the id of the <td>, we can also work out
	//the id of the hidden elements since we know they start with
	//announcement and class_id and the row of the table they are in
	//is appended to them, i.e. announcement1 and class_id1
	var button = sender.parentNode;
	var button_id = button.getAttribute('id');
	
	var rowIndex;
	var messageIndex;
	var titleIndex;
	
	var classHiddenID; //Hidden variable describes which class the message belongs to, class meaning classroom class
	var announcementHiddenID; //Hidden variable describes which announcement_id the message belongs to in the database
	
	if(button_id.length == 2) {
		rowIndex = button_id.substr(1,1); 
		rowNumber = button_id.substr(0,1);  //now we know the row number, it's possible to get the message text
											//title text, and theoretically, the id and values of the
											//hidden inputs on the form
		announcementHiddenID = document.getElementById("announcement" + rowNumber.toString());
		classHiddenID = document.getElementById("class_id" + rowNumber.toString());
		redirectID = document.getElementById("redirect" + rowNumber.toString());
		messageIndex = rowIndex - 2;
		titleIndex = rowIndex - 3;
		rowIndex = button_id.substr(0,1);
		messageIndex = rowIndex.concat(messageIndex);
		titleIndex = rowIndex.concat(titleIndex);
		
	} else if (button_id.length == 3) {
		rowIndex = button_id.substr(2);
		rowNumber = button_id.substr(0,2);  //now we know the row number, it's possible to get the message text
											//title text, and theoretically, the id and values of the
											//hidden inputs on the form
		announcementHiddenID = document.getElementById("announcement" + rowNumber.toString());
		classHiddenID = document.getElementById("class_id" + rowNumber.toString());
		redirectID = document.getElementById("redirect" + rowNumber.toString());
		messageIndex = rowIndex - 2;
		titleIndex = rowIndex - 3;
		rowIndex = button_id.substr(0,2);
		messageIndex = rowIndex.concat(messageIndex);
		titleIndex = rowIndex.concat(titleIndex);
	} else {
		rowIndex = button_id.substr(3);
		rowNumber = button_id.substr(0,3);  //now we know the row number, it's possible to get the message text
											//title text, and theoretically, the id and values of the
											//hidden inputs on the form
		announcementHiddenID = document.getElementById("announcement" + rowNumber.toString());
		classHiddenID = document.getElementById("class_id" + rowNumber.toString());
		redirectID = document.getElementById("redirect" + rowNumber.toString());
		messageIndex = rowIndex - 2;
		titleIndex = rowIndex - 3;
		rowIndex = button_id.substr(0,3);
		messageIndex = rowIndex.concat(messageIndex);
		titleIndex = rowIndex.concat(titleIndex);
	}
	
	whitespace = /^\s*$/;
	var messageText = document.getElementById(messageIndex);
	var count = messageText.childNodes.length;
	var messageTextValue;
	for(var i=0; i<count; i++) {
		var node = messageText.childNodes[i];
		if(node.nodeName === "#text" && !(whitespace.test(node.nodeValue))) {
			messageTextValue += node.nodeValue;
		}
	}
	
	var titleText = document.getElementById(titleIndex);
	var count = titleText.childNodes.length;
	var titleTextValue;
	for(var i=0; i<count; i++) {
		var node = titleText.childNodes[i];
		if(node.nodeName === "#text" && !(whitespace.test(node.nodeValue))) {
			titleTextValue += node.nodeValue;
		}
	}
	
	if(messageTextValue == undefined) {
			messageTextValue="";
		} else {
			if(messageTextValue.substr(0,9) == "undefined") {
				messageTextValue = messageTextValue.substr(9);
			}
	}
	
	if(titleTextValue == undefined) {
		titleTextValue = "";
	} else {
		if(titleTextValue.substr(0,9) == "undefined") {
			titleTextValue = titleTextValue.substr(9);
		}
	}
	


//Build the form from here.
	
	var form = document.createElement("form");
	form.setAttribute('method', "POST");
	form.setAttribute('action', "formHandler.php");
	form.setAttribute('class', "form-horizontal");
	form.setAttribute('id', "EditingInProgress");
	form.setAttribute('name', "editingForm");
	form.setAttribute('role', "form");
	
	//Title with a label in a form group
	var titleInput = document.createElement("input");
	titleInput.setAttribute('type', "text");
	titleInput.setAttribute('name', "title");
	titleInput.setAttribute('placeholder', "Write the title of the announcement here");
	titleInput.setAttribute('maxlength', "30");
	titleInput.setAttribute('class', "form-control");
	titleInput.setAttribute('id', "editAnnouncement");
	titleInput.setAttribute('onkeyup', "checkForm()");
	titleInput.setAttribute('value', titleTextValue);
	
	var titleDiv = document.createElement("div");
	titleDiv.setAttribute('class', "col-sm-10");
	titleDiv.appendChild(titleInput);
	
	var label = document.createElement("label");
	label.setAttribute('for', "editAnnouncement");
	label.setAttribute('class', "col-sm-2 control-label");
	labelNode = document.createTextNode("Title");
	label.appendChild(labelNode);
	
	var formGroupTitle = document.createElement("div");
	formGroupTitle.setAttribute('class', "form-group");
	
	formGroupTitle.appendChild(label);
	formGroupTitle.appendChild(titleDiv);
	
	//Message with a label in a form group
	var messageInput = document.createElement("textarea");
	messageInput.setAttribute('name', "announcement");
	messageInput.setAttribute('class', "form-control");
	messageInput.setAttribute('placeholder', "Write the content of the announcement here");
	messageInput.setAttribute('maxlength', "1000");
	messageInput.setAttribute('id', "editMessage");
	messageInput.setAttribute('onkeyup', "checkForm()");
	textNode = document.createTextNode(messageTextValue);
	messageInput.appendChild(textNode);
	
	var messageDiv = document.createElement("div");
	messageDiv.setAttribute('class', "col-sm-10");
	messageDiv.appendChild(messageInput);
	
	var labelAnnounce = document.createElement("label");
	labelAnnounce.setAttribute('for', "editMessage");
	labelAnnounce.setAttribute('class', "col-sm-2 control-label");
	labelAnnounceNode = document.createTextNode("Announcement");
	labelAnnounce.appendChild(labelAnnounceNode);
	
	var formGroupAnnounce = document.createElement("div");
	formGroupAnnounce.setAttribute('class', "form-group");
	
	formGroupAnnounce.appendChild(labelAnnounce);
	formGroupAnnounce.appendChild(messageDiv);
	
	var hiddenAnnouncementId = document.createElement("input");
	hiddenAnnouncementId.setAttribute('type', "hidden");
	hiddenAnnouncementId.setAttribute('name', "announcement_id");
	hiddenAnnouncementId.setAttribute('value', announcementHiddenID.value); //calculated above
	
	var hiddenClassId = document.createElement("input");
	hiddenClassId.setAttribute('type', "hidden");
	hiddenClassId.setAttribute('name', "class_id");
	hiddenClassId.setAttribute('value', classHiddenID.value);
	
	var hiddenRedirect = document.createElement("input");
	hiddenRedirect.setAttribute('type', "hidden");
	hiddenRedirect.setAttribute('name', "redirect");
	hiddenRedirect.setAttribute('value', redirectID.value);
	
	var controller = document.createElement("input");
	controller.setAttribute('type', "hidden");
	controller.setAttribute('name', "controller");
	controller.setAttribute('value', "FormHandler");
	
	var action = document.createElement("input");
	action.setAttribute('type', "hidden");
	action.setAttribute('name', "action");
	action.setAttribute('value', "updateAnnouncement");

	var button = document.createElement("button");
	button.setAttribute('class', "btn btn-sm btn-warning");
	button.setAttribute('type', "submit");
	button.setAttribute('id', "editSubmit");
	textNode = document.createTextNode("Update");
	button.appendChild(textNode);
	
	form.appendChild(formGroupTitle);
	form.appendChild(formGroupAnnounce);
	form.appendChild(hiddenAnnouncementId);
	form.appendChild(hiddenClassId);
	form.appendChild(hiddenRedirect);
	form.appendChild(controller);
	form.appendChild(action);
	form.appendChild(button);
	
	var div = document.createElement("div");
	div.setAttribute('id', "createClassForm");
	div.setAttribute('class', "col-lg-8 col-md-10 col-sm-12 thumbnail");
	div.appendChild(form);
	
	document.getElementById("popEditForm").appendChild(div);
	//checkForm();
}

//END EDIT ANNOUNCEMENT

function checkForm() {
	var cansubmit = true;
	var titleInput = document.getElementById("editAnnouncement").value;

		if(titleInput == 0) {
			cansubmit=false;
		}

	if (cansubmit) {
		document.getElementById('editSubmit').disabled = false;
	} else {
		document.getElementById('editSubmit').disabled = true;
	}
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