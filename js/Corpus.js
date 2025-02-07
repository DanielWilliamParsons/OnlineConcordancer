function corpusUploadScience() {
	$("#corpusUpload").remove();
	corpusUploadForm('scienceCorpus');
}

function corpusUploadGradedReader() {
	$("#corpusUpload").remove();
	corpusUploadForm('gradedReader');
}

function corpusUploadStudentWriting() {
	$("#corpusUpload").remove();
	corpusUploadForm('studentWriting');
}

function corpusUploadForm(idAndName) {
	
	var form = document.createElement("form");
	form.setAttribute('method', "POST");
	form.setAttribute('action', "formHandler.php");
	form.setAttribute('class', "form-horizontal");
	form.setAttribute('id', "corpusUpload");
	form.setAttribute('name', idAndName);
	form.setAttribute('role', "form");
	
	//Form Title
	var formTitle = document.createElement("h3");
	if(idAndName=='scienceCorpus') {
		formTitleNode = document.createTextNode("Add Files to the Science Corpus");
		formTitle.setAttribute('class', "text-primary");
	} else if (idAndName=='gradedReader') {
		formTitleNode = document.createTextNode("Add Files to the Graded Reader Corpus");
		formTitle.setAttribute('class', "text-success");
	} else if (idAndName=='studentWriting') {
		formTitleNode = document.createTextNode("Add Files to the Student Writing Corpus");
		formTitle.setAttribute('class', "text-danger");
	}
	formTitle.appendChild(formTitleNode);
	
	
	//Title of the corpus file
	var titleInput = document.createElement("input");
	titleInput.setAttribute('type', "text");
	titleInput.setAttribute('name', "title");
	titleInput.setAttribute('placeholder', "Title of your corpus file");
	titleInput.setAttribute('maxlength', "75");
	titleInput.setAttribute('class', "form-control");
	titleInput.setAttribute('id', "corpusFileTitle");
	titleInput.setAttribute('onkeyup', "checkForm()");
	
	var titleDiv = document.createElement("div");
	titleDiv.setAttribute('class', "col-sm-10");
	titleDiv.appendChild(titleInput);
	
	var formGroupTitle = document.createElement("div");
	formGroupTitle.setAttribute('class', "form-group");
	formGroupTitle.appendChild(titleDiv);
	
	//Author of the corpus
	var authorInput = document.createElement("input");
	authorInput.setAttribute('type', "text");
	authorInput.setAttribute('name', "author");
	authorInput.setAttribute('placeholder', "Author of your corpus file");
	authorInput.setAttribute('maxlength', "75");
	authorInput.setAttribute('class', "form-control");
	authorInput.setAttribute('id', "corpusFileAuthor");
	authorInput.setAttribute('onkeyup', "checkForm()");
	
	var authorDiv = document.createElement("div");
	authorDiv.setAttribute('class', "col-sm-10");
	authorDiv.appendChild(authorInput);
	
	var formGroupAuthor = document.createElement("div");
	formGroupAuthor.setAttribute('class', "form-group");
	formGroupAuthor.appendChild(authorDiv);
	
	//Subject of the corpus file
	var subjectInput = document.createElement("input");
	subjectInput.setAttribute('type', "text");
	subjectInput.setAttribute('name', "subject");
	subjectInput.setAttribute('placeholder', "Subject of your corpus file");
	subjectInput.setAttribute('maxlength', "75");
	subjectInput.setAttribute('class', "form-control");
	subjectInput.setAttribute('id', "corpusFileSubject");
	subjectInput.setAttribute('onkeyup', "checkForm()");
	
	var subjectDiv = document.createElement("div");
	subjectDiv.setAttribute('class', "col-sm-10");
	subjectDiv.appendChild(subjectInput);
	
	var formGroupSubject = document.createElement("div");
	formGroupSubject.setAttribute('class', "form-group");
	formGroupSubject.appendChild(subjectDiv);
	
	//Dewey Decimal Number
	var deweyInput = document.createElement("input");
	deweyInput.setAttribute('type', "number");
	deweyInput.setAttribute('name', "dewey");
	deweyInput.setAttribute('placeholder', "Dewey decimal number of your corpus file");
	deweyInput.setAttribute('maxlength', "75");
	deweyInput.setAttribute('class', "form-control");
	deweyInput.setAttribute('id', "corpusFileDewey");
	deweyInput.setAttribute('onkeyup', "checkForm()");
	
	var deweyDiv = document.createElement("div");
	deweyDiv.setAttribute('class', "col-sm-10");
	deweyDiv.appendChild(deweyInput);
	
	var formGroupDewey = document.createElement("div");
	formGroupDewey.setAttribute('class', "form-group");
	formGroupDewey.appendChild(deweyDiv);
	
	//Publication Year
	var pubyearInput = document.createElement("input");
	pubyearInput.setAttribute('type', "number");
	pubyearInput.setAttribute('name', "pubyear");
	pubyearInput.setAttribute('placeholder', "Publication Year of the file");
	pubyearInput.setAttribute('maxlength', "75");
	pubyearInput.setAttribute('class', "form-control");
	pubyearInput.setAttribute('id', "corpusFilePubyear");
	pubyearInput.setAttribute('onkeyup', "checkForm()");
	
	var pubyearDiv = document.createElement("div");
	pubyearDiv.setAttribute('class', "col-sm-10");
	pubyearDiv.appendChild(pubyearInput);
	
	var formGroupPubyear = document.createElement("div");
	formGroupPubyear.setAttribute('class', "form-group");
	formGroupPubyear.appendChild(pubyearDiv);
	
	//Genre
	var genreInput = document.createElement("input");
	genreInput.setAttribute('type', "text");
	genreInput.setAttribute('name', "genre");
	genreInput.setAttribute('placeholder', "Genre of the file");
	genreInput.setAttribute('maxlength', "75");
	genreInput.setAttribute('class', "form-control");
	genreInput.setAttribute('id', "corpusFileGenre");
	genreInput.setAttribute('onkeyup', "checkForm()");
	
	var genreDiv = document.createElement("div");
	genreDiv.setAttribute('class', "col-sm-10");
	genreDiv.appendChild(genreInput);
	
	var formGroupGenre = document.createElement("div");
	formGroupGenre.setAttribute('class', "form-group");
	formGroupGenre.appendChild(genreDiv);
	
	//Clean file
	var cleanFileInput = document.createElement("input");
	cleanFileInput.setAttribute('type', "file");
	cleanFileInput.setAttribute('name', "cleanfile");
	cleanFileInput.setAttribute('id', "corpusFileClean");
	
	var cleanFileDiv = document.createElement("div");
	cleanFileDiv.setAttribute('class', "col-sm-10");
	cleanFileDiv.appendChild(cleanFileInput);
	
	var labelCleanFile = document.createElement("label");
	labelCleanFile.setAttribute('for', "corpusFileClean");
	labelCleanFile.setAttribute('class', "col-sm-2 control-label");
	labelCleanFileNode = document.createTextNode("Clean File");
	labelCleanFile.appendChild(labelCleanFileNode);
	
	var formGroupCleanFile = document.createElement("div");
	formGroupCleanFile.setAttribute('class', "form-group");
	formGroupCleanFile.appendChild(labelCleanFile);
	formGroupCleanFile.appendChild(cleanFileDiv);
	
	//Tagged file
	var taggedFileInput = document.createElement("input");
	taggedFileInput.setAttribute('type', "file");
	taggedFileInput.setAttribute('name', "taggedfile");
	taggedFileInput.setAttribute('id', "corpusFileTagged");
	
	var taggedFileDiv = document.createElement("div");
	taggedFileDiv.setAttribute('class', "col-sm-10");
	taggedFileDiv.appendChild(taggedFileInput);
	
	var labelTaggedFile = document.createElement("label");
	labelTaggedFile.setAttribute('for', "corpusFileTagged");
	labelTaggedFile.setAttribute('class', "col-sm-2 control-label");
	labelTaggedFileNode = document.createTextNode("Tagged File");
	labelTaggedFile.appendChild(labelTaggedFileNode);
	
	var formGroupTaggedFile = document.createElement("div");
	formGroupTaggedFile.setAttribute('class', "form-group");
	formGroupTaggedFile.appendChild(labelTaggedFile);
	formGroupTaggedFile.appendChild(taggedFileDiv);
	
	//Submit button
	var submitButton = document.createElement("button");
	submitButton.setAttribute('type', "submit");
	submitButton.setAttribute('class', "btn btn-primary pull-right");
	submitButtonNode = document.createTextNode("Submit");
	submitButton.appendChild(submitButtonNode);
	
	var submitDiv = document.createElement("div");
	submitDiv.setAttribute('class', "col-sm-10");
	submitDiv.appendChild(submitButton);
	
	var formGroupSubmit = document.createElement("div");
	formGroupSubmit.setAttribute('class', "form-group");
	formGroupSubmit.appendChild(submitDiv);
	
	form.appendChild(formTitle);
	form.appendChild(formGroupTitle);
	form.appendChild(formGroupAuthor);
	form.appendChild(formGroupSubject);
	form.appendChild(formGroupDewey);
	form.appendChild(formGroupPubyear);
	form.appendChild(formGroupGenre);
	form.appendChild(formGroupCleanFile);
	form.appendChild(formGroupTaggedFile);
	form.appendChild(formGroupSubmit);
	document.getElementById("main-top-right").appendChild(form);
	
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