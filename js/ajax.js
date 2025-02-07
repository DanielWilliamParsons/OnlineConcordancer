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