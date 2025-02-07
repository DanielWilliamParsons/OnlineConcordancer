var oneRTable;
var twoRTable;
var oneLTable;
var twoLTable;

function oneR() {
	O('tableData').innerHTML = oneRTable;
}

function twoR() {
	O('tableData').innerHTML = twoRTable;
}

function oneL() {
	O('tableData').innerHTML = oneLTable;
}

function twoL() {
	O('tableData').innerHTML = twoLTable;
}

function sendComparison() {
	var output = document.getElementById("what_output");
	var outputType = output.options[output.selectedIndex].text;
	
	var searchTerm = document.getElementById("searchForm").value;
	
	var sort1 = document.getElementById("sort1");
	var sort1 = sort1.options[sort1.selectedIndex].text;
	
	var sort2 = document.getElementById("sort2");
	var sort2 = sort2.options[sort2.selectedIndex].text;
	
	var sort3 = document.getElementById("sort3");
	var sort3 = sort3.options[sort3.selectedIndex].text;

	dataString = "outputType="+outputType+"&inputType=searchbar"+"&searchTerm="+searchTerm+"&sort1="+sort1+"&sort2="+sort2+"&sort3="+sort3;

	request = new ajaxRequest()
	if(outputType == "KWIC") {
		request.open("POST", "index.php?controller=Corpus&action=searchCompare", true)
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var obj = JSON.parse(this.responseText);
						var obj = JSON.parse(obj);
						var length = obj.original.length;
						var table = '<div class="table-responsive"><table class="table table-striped"><th colspan="3">Professional Writers Corpus</th>';
						
						var arrayOfCombinations = {};
						var arrayOfCombinations2R = {};
						var arrayOfCombinations1L = {};
						var arrayOfCombinations2L = {};
						
						for(var i=0; i<length; ++i) {
							var filename = obj.original[i].file;
							var left = obj.original[i].left;
							var leftText = document.createElement("div");
							leftText.innerHTML = left;
							leftText = leftText.textContent;
							leftText = leftText.split(" ");
							var nodeLine = obj.original[i].node;
							var nodeLineText = document.createElement("div");
							nodeLineText.innerHTML = nodeLine;
							nodeLineText = nodeLineText.textContent;
							var right = obj.original[i].right;
							var rightText = document.createElement("div");
							rightText.innerHTML = right;
							rightText = rightText.textContent;
							rightText = rightText.split(" ");
							var data = obj.original[i].folder;
							var keyValue = obj.original[i].keyValue;
						
							table += "<tr><td id='left_" + i + "' align='right'>" + left + "</td>" + 
											"<td id='node_" + i + "'>" + nodeLine + "</td>" + 
											"<td id='right_" + i + "'>" + right + "</td>" +
											"</tr>";
											
							var OneR = nodeLineText + rightText[0];
							if(arrayOfCombinations[OneR] === undefined) {
								arrayOfCombinations[OneR] = 1;
							} else {
								arrayOfCombinations[OneR] += 1;
							}
							
							
							var TwoR = nodeLineText + " ~ " + rightText[1];
							if(arrayOfCombinations2R[TwoR] === undefined) {
								arrayOfCombinations2R[TwoR] = 1;
							} else {
								arrayOfCombinations2R[TwoR] += 1;
							}
							
							leftLength = leftText.length;
							var OneL = leftText[leftLength-2] + " " + nodeLineText;
							if(arrayOfCombinations1L[OneL] === undefined) {
								arrayOfCombinations1L[OneL] = 1;
							} else {
								arrayOfCombinations1L[OneL] += 1;
							}
							
							
							var TwoL = leftText[leftLength-3] + " ~ " + nodeLineText;
							if(arrayOfCombinations2L[TwoL] === undefined) {
								arrayOfCombinations2L[TwoL] = 1;
							} else {
								arrayOfCombinations2L[TwoL] += 1;
							}
							
						}
					
					table += '</table></div>';
					
					var lengthLearner = obj.learner.length;
						var learnerTable = '<div class="table-responsive"><table class="table table-striped"><th colspan="3">Student Writers Corpus</th>';
						var arrayOfCombinationsLearner = {};
						var arrayOfCombinationsLearner2R = {};
						var arrayOfCombinationsLearner1L = {};
						var arrayOfCombinationsLearner2L = {};
					
						for(var i=0; i<lengthLearner; ++i) {
							var filename = obj.learner[i].file;
							var left = obj.learner[i].left;
							var leftTextLearner = document.createElement("div");
							leftTextLearner.innerHTML = left;
							leftTextLearner = leftTextLearner.textContent;
							leftTextLearner = leftTextLearner.split(" ");
							var nodeLine = obj.learner[i].node;
							var nodeLineText = document.createElement("div");
							nodeLineText.innerHTML = nodeLine;
							nodeLineText = nodeLineText.textContent;
							var right = obj.learner[i].right;
							var rightTextLearner = document.createElement("div");
							rightTextLearner.innerHTML = right;
							rightTextLearner = rightTextLearner.textContent;
							rightTextLearner = rightTextLearner.split(" ");
							var data = obj.learner[i].folder;
							var keyValue = obj.learner[i].keyValue;
						
							learnerTable += "<tr><td id='left_" + i + "' align='right'>" + left + "</td>" + 
											"<td id='node_" + i + "'>" + nodeLine + "</td>" + 
											"<td id='right_" + i + "'>" + right + "</td>" +
											"</tr>";
											
							
							var OneR = nodeLineText + rightTextLearner[0];
							if(arrayOfCombinationsLearner[OneR] === undefined) {
								arrayOfCombinationsLearner[OneR] = 1;
							} else {
								arrayOfCombinationsLearner[OneR] += 1;
							}
							
							var TwoR = nodeLineText + " ~ " + rightTextLearner[1];
							if(arrayOfCombinationsLearner2R[TwoR] === undefined) {
								arrayOfCombinationsLearner2R[TwoR] = 1;
							} else {
								arrayOfCombinationsLearner2R[TwoR] += 1;
							}
							
							leftLength = leftTextLearner.length;
							var OneL = leftTextLearner[leftLength-2] + " " + nodeLineText;
							if(arrayOfCombinationsLearner1L[OneL] === undefined) {
								arrayOfCombinationsLearner1L[OneL] = 1;
							} else {
								arrayOfCombinationsLearner1L[OneL] += 1;
							}
							
							var TwoL = leftTextLearner[leftLength-3] + " ~ " + nodeLineText;
							if(arrayOfCombinationsLearner2L[TwoL] === undefined) {
								arrayOfCombinationsLearner2L[TwoL] = 1;
							} else {
								arrayOfCombinationsLearner2L[TwoL] += 1;
							}
							
						}
					
					learnerTable += '</table></div>';
					
					oneRTable = "<table class='table table-striped'><tr><th colspan='6'>Search + 1R Combination</th><tr><td colspan='3'><strong>Professional Corpus</strong></td><td colspan='3'><strong>Student Corpus</strong></td></tr>";
					var oneRTableLength = Object.keys(arrayOfCombinations).length >= Object.keys(arrayOfCombinationsLearner).length ? Object.keys(arrayOfCombinations).length : Object.keys(arrayOfCombinationsLearner).length;
					
					var OtherLength = Object.keys(arrayOfCombinations).length < Object.keys(arrayOfCombinationsLearner).length ? Object.keys(arrayOfCombinations).length : Object.keys(arrayOfCombinationsLearner).length;

					var combinations = Object.keys(arrayOfCombinations);
					var combinationsLearner = Object.keys(arrayOfCombinationsLearner);
					for(var j = 0; j<oneRTableLength; ++j) {
						var combinationCount = arrayOfCombinations[combinations[j]] === undefined ? "~" : arrayOfCombinations[combinations[j]];
						var combinationPercent = arrayOfCombinations[combinations[j]] === undefined ? "~" : (arrayOfCombinations[combinations[j]] / length)*100;
						if(combinationPercent !== "~") {
							combinationPercent = combinationPercent.toFixed(2) + "%";	
						}
						
						var combinationLearnerCount = arrayOfCombinationsLearner[combinationsLearner[j]] === undefined ? "~" : arrayOfCombinationsLearner[combinationsLearner[j]];
						var combinationLearnerPercent = arrayOfCombinationsLearner[combinationsLearner[j]] === undefined ? "~" :(arrayOfCombinationsLearner[combinationsLearner[j]] / lengthLearner)*100;
						if(combinationLearnerPercent !== "~") {
							combinationLearnerPercent = combinationLearnerPercent.toFixed(2) + "%";
						}
						
						var combi = combinations[j] === undefined ? "~" : combinations[j];
						var combiLearner = combinationsLearner[j] === undefined ? "~" : combinationsLearner[j];
						
						oneRTable += "<tr><td>" + combi + "</td><td>" + combinationCount + "</td><td>" + combinationPercent + "</td><td>" + combiLearner + "</td><td>" + combinationLearnerCount + "</td><td>" + combinationLearnerPercent + "</td></tr>";
					}
					
					oneRTable += "</table>";
					
					
					oneLTable = "<table class='table table-striped'><tr><th colspan='6'>1L + Search Combination</th><tr><td colspan='3'><strong>Professional Corpus</strong></td><td colspan='3'><strong>Student Corpus</strong></td></tr>";
					var oneLTableLength = Object.keys(arrayOfCombinations1L).length >= Object.keys(arrayOfCombinationsLearner1L).length ? Object.keys(arrayOfCombinations1L).length : Object.keys(arrayOfCombinationsLearner1L).length;
					

					var combinations = Object.keys(arrayOfCombinations1L);
					var combinationsLearner = Object.keys(arrayOfCombinationsLearner1L);
					for(var j = 0; j<oneLTableLength; ++j) {
						var combinationCount = arrayOfCombinations1L[combinations[j]] === undefined ? "~" : arrayOfCombinations1L[combinations[j]];
						var combinationPercent = arrayOfCombinations1L[combinations[j]] === undefined ? "~" : (arrayOfCombinations1L[combinations[j]] / length)*100;
						if(combinationPercent !== "~") {
							combinationPercent = combinationPercent.toFixed(2) + "%";	
						}
						
						var combinationLearnerCount = arrayOfCombinationsLearner1L[combinationsLearner[j]] === undefined ? "~" : arrayOfCombinationsLearner1L[combinationsLearner[j]];
						var combinationLearnerPercent = arrayOfCombinationsLearner1L[combinationsLearner[j]] === undefined ? "~" :(arrayOfCombinationsLearner1L[combinationsLearner[j]] / lengthLearner)*100;
						if(combinationLearnerPercent !== "~") {
							combinationLearnerPercent = combinationLearnerPercent.toFixed(2) + "%";
						}
						
						var combi = combinations[j] === undefined ? "~" : combinations[j];
						var combiLearner = combinationsLearner[j] === undefined ? "~" : combinationsLearner[j];
						
						oneLTable += "<tr><td>" + combi + "</td><td>" + combinationCount + "</td><td>" + combinationPercent + "</td><td>" + combiLearner + "</td><td>" + combinationLearnerCount + "</td><td>" + combinationLearnerPercent + "</td></tr>";
					}
					
					oneLTable += "</table>";
					
					
					twoLTable = "<table class='table table-striped'><tr><th colspan='6'>2L + Search Combination</th><tr><td colspan='3'><strong>Professional Corpus</strong></td><td colspan='3'><strong>Student Corpus</strong></td></tr>";
					var twoLTableLength = Object.keys(arrayOfCombinations2L).length >= Object.keys(arrayOfCombinationsLearner2L).length ? Object.keys(arrayOfCombinations2L).length : Object.keys(arrayOfCombinationsLearner2L).length;
					

					var combinations = Object.keys(arrayOfCombinations2L);
					var combinationsLearner = Object.keys(arrayOfCombinationsLearner2L);
					for(var j = 0; j<twoLTableLength; ++j) {
						var combinationCount = arrayOfCombinations2L[combinations[j]] === undefined ? "~" : arrayOfCombinations2L[combinations[j]];
						var combinationPercent = arrayOfCombinations2L[combinations[j]] === undefined ? "~" : (arrayOfCombinations2L[combinations[j]] / length)*100;
						if(combinationPercent !== "~") {
							combinationPercent = combinationPercent.toFixed(2) + "%";	
						}
						
						var combinationLearnerCount = arrayOfCombinationsLearner2L[combinationsLearner[j]] === undefined ? "~" : arrayOfCombinationsLearner2L[combinationsLearner[j]];
						var combinationLearnerPercent = arrayOfCombinationsLearner2L[combinationsLearner[j]] === undefined ? "~" :(arrayOfCombinationsLearner2L[combinationsLearner[j]] / lengthLearner)*100;
						if(combinationLearnerPercent !== "~") {
							combinationLearnerPercent = combinationLearnerPercent.toFixed(2) + "%";
						}
						
						var combi = combinations[j] === undefined ? "~" : combinations[j];
						var combiLearner = combinationsLearner[j] === undefined ? "~" : combinationsLearner[j];
						
						twoLTable += "<tr><td>" + combi + "</td><td>" + combinationCount + "</td><td>" + combinationPercent + "</td><td>" + combiLearner + "</td><td>" + combinationLearnerCount + "</td><td>" + combinationLearnerPercent + "</td></tr>";
					}
					
					twoLTable += "</table>";
					
					
					twoRTable = "<table class='table table-striped'><tr><th colspan='6'>Search + 2R Combination</th><tr><td colspan='3'><strong>Professional Corpus</strong></td><td colspan='3'><strong>Student Corpus</strong></td></tr>";
					var twoRTableLength = Object.keys(arrayOfCombinations2R).length >= Object.keys(arrayOfCombinationsLearner2R).length ? Object.keys(arrayOfCombinations2R).length : Object.keys(arrayOfCombinationsLearner2R).length;
					

					var combinations = Object.keys(arrayOfCombinations2R);
					var combinationsLearner = Object.keys(arrayOfCombinationsLearner2R);
					for(var j = 0; j<twoRTableLength; ++j) {
						var combinationCount = arrayOfCombinations2R[combinations[j]] === undefined ? "~" : arrayOfCombinations2R[combinations[j]];
						var combinationPercent = arrayOfCombinations2R[combinations[j]] === undefined ? "~" : (arrayOfCombinations2R[combinations[j]] / length)*100;
						if(combinationPercent !== "~") {
							combinationPercent = combinationPercent.toFixed(2) + "%";	
						}
						
						var combinationLearnerCount = arrayOfCombinationsLearner2R[combinationsLearner[j]] === undefined ? "~" : arrayOfCombinationsLearner2R[combinationsLearner[j]];
						var combinationLearnerPercent = arrayOfCombinationsLearner2R[combinationsLearner[j]] === undefined ? "~" :(arrayOfCombinationsLearner2R[combinationsLearner[j]] / lengthLearner)*100;
						if(combinationLearnerPercent !== "~") {
							combinationLearnerPercent = combinationLearnerPercent.toFixed(2) + "%";
						}
						
						var combi = combinations[j] === undefined ? "~" : combinations[j];
						var combiLearner = combinationsLearner[j] === undefined ? "~" : combinationsLearner[j];
						
						twoRTable += "<tr><td>" + combi + "</td><td>" + combinationCount + "</td><td>" + combinationPercent + "</td><td>" + combiLearner + "</td><td>" + combinationLearnerCount + "</td><td>" + combinationLearnerPercent + "</td></tr>";
					}
					
					twoRTable += "</table>";
					
					
					var buttonGroup = "<div class='row'><div class='col-sm-12'><div class='btn-group btn-group-sm' role='group'><button type='button' class='btn btn-default' onclick='twoL()'>2L</button><button type='button' class='btn btn-default' onclick='oneL()'>1L</button><button type='button' class='btn btn-default' onclick='oneR()'>1R</button><button type='button' class='btn btn-default' onclick='twoR()'>2R</button></div></div></div><div class='row'><div class='col-sm-12' id='tableData'></div></div>";
										
					
					
					
					O('main-top-left-learner').innerHTML = table;
					O('main-top-right-learner').innerHTML = learnerTable;
					O('main-bottom-learner').innerHTML = buttonGroup;

				}
					
		}
		request.send(dataString);
	}
	
	if(outputType == "List") {
	
		request.open("POST", "index.php?controller=Corpus&action=search", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = this.responseText;
						//O('main-bottom').innerHTML = text;
						
						var obj = JSON.parse(text);
						text = obj.list;
						var newText = "<div class='table-responsive'><table class='table table-striped'>";
						newText += "<tr><th>Found</th><th>Count</th></tr>";
						var count = 0;
						var k=0;
						for(key in text) {
							newText += "<tr><td>" + key + "</td><td>" + text[key] + "</td></tr>";
							k++;
							if(k==100) {break;}
						}
						
						for(key in text) {
							count += Number(text[key]);
						}
						
						newText += "<tr><th>TOTAL OCCURRENCES</th><th>" + count + "</th></tr>";
						newText += "</table></div>"
						
						//Should prepare a table in a different function.
						//That table can then be populated with the values here.
						stats = obj.listWithFiles;
						var statText = "<div class='table-responsive'><table class='table table-condensed'>";
						statText += "<tr><th>Search</th><th>Fiction</th><th>Essays</th><th>Sci_News</th><th>Sci_Study</th></tr>";
						for(key in stats) {
							 object = stats[key];
							 statText += "<tr><td><a onclick='refineSearch(this)'>" + key + "</a></td>";
							 if("Fiction" in object) {
								 statText += "<td>" + object["Fiction"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Non_fiction" in object) {
								 statText += "<td>" + object["Non_fiction"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Sci_News" in object) {
								 statText += "<td>" + object["Sci_News"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Sci_Study" in object) {
								 statText += "<td>" + object["Sci_Study"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							statText += "</tr>";
						}
						statText += "</table></div>"
						
						O('main-top-left').innerHTML = statText;
						O('main-top-right').innerHTML = newText;
					}
		}
		request.send(dataString);
	}
	
	if(outputType == "Collocations") {
	
		request.open("POST", "index.php?controller=Corpus&action=collocations", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = this.responseText;
						//O('main-bottom').innerHTML = text;
						
						var obj = JSON.parse(text);
						var collTable = "<div class='table-responsive'><table class='table table-striped'>";
						collTable += "<tr><th>Collocation</th><th>Log-Likelihood Score</th><th>See More</th></tr>";
						var list = 1;
						for (key in obj.collocates) {
							collTable += "<tr><td>" + key + "</td><td>" + obj.collocates[key] + 
										"</td><td><input id='searchColl_" + list +"' type='hidden' value='" + obj.searchTerm + "'><input type='hidden' id='foundColl_" + list + "' value='" + key + "'>" + 
										"<button class='btn btn-sm btn-primary' onclick='getCollKWIC(" + list + ")'>KWIC</button>" + "</td></tr>";
							++list;
						}
						collTable += "</table></div>";
						O('main-top-right').innerHTML = collTable;
					}
		}
		request.send(dataString);
	}
}

function sendSearch() {
	var corpus = document.getElementById("which_corpus");
	var corpusName = corpus.options[corpus.selectedIndex].text;
	
	var output = document.getElementById("what_output");
	var outputType = output.options[output.selectedIndex].text;
	
	var searchTerm = document.getElementById("searchForm").value;
	
	var sort1 = document.getElementById("sort1");
	var sort1 = sort1.options[sort1.selectedIndex].text;
	
	var sort2 = document.getElementById("sort2");
	var sort2 = sort2.options[sort2.selectedIndex].text;
	
	var sort3 = document.getElementById("sort3");
	var sort3 = sort3.options[sort3.selectedIndex].text;

	dataString = "corpusName="+corpusName+"&outputType="+outputType+"&inputType=searchbar"+"&searchTerm="+searchTerm+"&sort1="+sort1+"&sort2="+sort2+"&sort3="+sort3;

	request = new ajaxRequest()
	if(outputType == "KWIC") {
		request.open("POST", "index.php?controller=Corpus&action=search", true)
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = '{"lines": ' + this.responseText + '}';
						//O('main-bottom').innerHTML = text;
						var obj = JSON.parse(text);
						var length = obj.lines.length;
						var table = '<div class="table-responsive"><table class="table table-striped">';
					
						var Fiction = 0;
						var Sci_News = 0;
						var Sci_Study = 0;
						var Essay = 0;
					
						for(var i=0; i<length; ++i) {
							var filename = obj.lines[i].file;
							var left = obj.lines[i].left;
							var nodeLine = obj.lines[i].node;
							var right = obj.lines[i].right;
							var data = obj.lines[i].folder;
							var keyValue = obj.lines[i].keyValue;
						
							if(data == "Fiction") Fiction++;
							if(data == "Non_fiction") Essay++;
							if(data == "Sci_Study") Sci_Study++;
							if(data == "Sci_News") Sci_News++;
						
							table += "<tr><td id='left_" + i + "' align='right'>" + left + "</td>" + 
											"<td id='node_" + i + "'>" + nodeLine + "</td>" + 
											"<td id='right_" + i + "'>" + right + "</td>" +
											"<td align='right'>" + 
												"<input type='hidden' id='filename_" + i + "' name='filename' value='" + filename + "'>" + 
												"<input type='hidden' id='keyValue_" + i + "' name='keyValue' value='" + keyValue + "'>" +
												"<button class='btn btn-sml btn-success' onclick='getSource(" + i + ")' name='" + data + "'>" + data + "</button>" +
											"</td></tr>";
						}
					
					table += '</table></div>';
					
					var FictionPercent = Math.round(100*(Fiction/length));
					var Sci_NewsPercent = Math.round(100*(Sci_News/length));
					var Sci_StudyPercent = Math.round(100*(Sci_Study/length));
					var EssayPercent = Math.round(100*(Essay/length));
					
					var stats = "<div class='table-responsive'><table class='table table-condensed'>" + 
					"<tr><th>Count</th><th>Percent</th><th>Graph</th>" + 
					"<tr><td style='width:150px'>Fiction: " + Fiction + 
					"</td><td style='width:80px'>" + FictionPercent + "%" + 
					"</td><td><div style='background-color:#3b3131; width:" + FictionPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Sci_News: " + Sci_News + 
					"</td><td style='width:80px'>" + Sci_NewsPercent + "%" + 
					"</td><td><div style='background-color:#98afc7; width:" + Sci_NewsPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Essay: " + Essay + 
					"</td><td style='width:80px'>" + EssayPercent + "%" + 
					"</td><td><div style='background-color:#736aff; width:" + EssayPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Sci_Study: " + Sci_Study + 
					"</td><td style='width:80px'>" + Sci_StudyPercent + "%" +
					"</td><td><div style='background-color:#307d7e; width:" + Sci_StudyPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>TOTAL: " + length +
					"</td><td></td><td></td></tr>"
					"</table></div>";
					
					
					O('main-bottom').innerHTML = table;
					O('main-top-left').innerHTML = stats;

				}
					
		}
		request.send(dataString);
	}
	
	if(outputType == "List") {
	
		request.open("POST", "index.php?controller=Corpus&action=search", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = this.responseText;
						//O('main-bottom').innerHTML = text;
						
						var obj = JSON.parse(text);
						text = obj.list;
						var newText = "<div class='table-responsive'><table class='table table-striped'>";
						newText += "<tr><th>Found</th><th>Count</th></tr>";
						var count = 0;
						var k=0;
						for(key in text) {
							newText += "<tr><td>" + key + "</td><td>" + text[key] + "</td></tr>";
							k++;
							if(k==100) {break;}
						}
						
						for(key in text) {
							count += Number(text[key]);
						}
						
						newText += "<tr><th>TOTAL OCCURRENCES</th><th>" + count + "</th></tr>";
						newText += "</table></div>"
						
						//Should prepare a table in a different function.
						//That table can then be populated with the values here.
						stats = obj.listWithFiles;
						var statText = "<div class='table-responsive'><table class='table table-condensed'>";
						statText += "<tr><th>Search</th><th>Fiction</th><th>Essays</th><th>Sci_News</th><th>Sci_Study</th></tr>";
						for(key in stats) {
							 object = stats[key];
							 statText += "<tr><td><a onclick='refineSearch(this)'>" + key + "</a></td>";
							 if("Fiction" in object) {
								 statText += "<td>" + object["Fiction"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Non_fiction" in object) {
								 statText += "<td>" + object["Non_fiction"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Sci_News" in object) {
								 statText += "<td>" + object["Sci_News"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							 
							 if("Sci_Study" in object) {
								 statText += "<td>" + object["Sci_Study"] + "</td>";
							 } else {
								 statText += "<td>0</td>";
							 }
							statText += "</tr>";
						}
						statText += "</table></div>"
						
						O('main-top-left').innerHTML = statText;
						O('main-top-right').innerHTML = newText;
					}
		}
		request.send(dataString);
	}
	
	if(outputType == "Collocations") {
	
		request.open("POST", "index.php?controller=Corpus&action=collocations", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = this.responseText;
						//O('main-bottom').innerHTML = text;
						
						var obj = JSON.parse(text);
						var collTable = "<div class='table-responsive'><table class='table table-striped'>";
						collTable += "<tr><th>Collocation</th><th>Log-Likelihood Score</th><th>See More</th></tr>";
						var list = 1;
						for (key in obj.collocates) {
							collTable += "<tr><td>" + key + "</td><td>" + obj.collocates[key] + 
										"</td><td><input id='searchColl_" + list +"' type='hidden' value='" + obj.searchTerm + "'><input type='hidden' id='foundColl_" + list + "' value='" + key + "'>" + 
										"<button class='btn btn-sm btn-primary' onclick='getCollKWIC(" + list + ")'>KWIC</button>" + "</td></tr>";
							++list;
						}
						collTable += "</table></div>";
						O('main-top-right').innerHTML = collTable;
					}
		}
		request.send(dataString);
	}
}

function getCollKWIC(value) {
	var searchId = "searchColl_" + value;
	var searchTerm = document.getElementById(searchId).value;
	var foundId = "foundColl_" + value;
	var collocate = document.getElementById(foundId).value;
	dataString = "corpusName=Search All"+"&outputType=KWIC"+"&inputType=collocationKWIC"+"&searchTerm="+searchTerm+"&collocate="+collocate+"&sort1=1R"+"&sort2=2R"+"&sort3=3R";
	request.open("POST", "index.php?controller=Corpus&action=collocateSearch", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = this.responseText;
						var text = '{"lines": ' + this.responseText + '}';
						//O('main-bottom').innerHTML = text;
						var obj = JSON.parse(text);
						var length = obj.lines.length;
						var table = '<div class="table-responsive"><table class="table table-striped">';
					
						var Fiction = 0;
						var Sci_News = 0;
						var Sci_Study = 0;
						var Essay = 0;
					
						for(var i=0; i<length; ++i) {
							var filename = obj.lines[i].file;
							var left = obj.lines[i].left;
							var nodeLine = obj.lines[i].node;
							var right = obj.lines[i].right;
							var data = obj.lines[i].folder;
							var keyValue = obj.lines[i].keyValue;
						
							if(data == "Fiction") Fiction++;
							if(data == "Non_fiction") Essay++;
							if(data == "Sci_Study") Sci_Study++;
							if(data == "Sci_News") Sci_News++;
						
							table += "<tr><td id='left_" + i + "' align='right'>" + left + "</td>" + 
											"<td id='node_" + i + "'>" + nodeLine + "</td>" + 
											"<td id='right_" + i + "'>" + right + "</td>" +
											"<td align='right'>" + 
												"<input type='hidden' id='filename_" + i + "' name='filename' value='" + filename + "'>" + 
												"<input type='hidden' id='keyValue_" + i + "' name='keyValue' value='" + keyValue + "'>" +
												"<button class='btn btn-sml btn-success' onclick='getSource(" + i + ")' name='" + data + "'>" + data + "</button>" +
											"</td></tr>";
						}
					
					table += '</table></div>';
					
					var FictionPercent = Math.round(100*(Fiction/length));
					var Sci_NewsPercent = Math.round(100*(Sci_News/length));
					var Sci_StudyPercent = Math.round(100*(Sci_Study/length));
					var EssayPercent = Math.round(100*(Essay/length));
					
					var stats = "<div class='table-responsive'><table class='table table-condensed'>" + 
					"<tr><th>Count</th><th>Percent</th><th>Graph</th>" + 
					"<tr><td style='width:150px'>Fiction: " + Fiction + 
					"</td><td style='width:80px'>" + FictionPercent + "%" + 
					"</td><td><div style='background-color:#3b3131; width:" + FictionPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Sci_News: " + Sci_News + 
					"</td><td style='width:80px'>" + Sci_NewsPercent + "%" + 
					"</td><td><div style='background-color:#98afc7; width:" + Sci_NewsPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Essay: " + Essay + 
					"</td><td style='width:80px'>" + EssayPercent + "%" + 
					"</td><td><div style='background-color:#736aff; width:" + EssayPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>Sci_Study: " + Sci_Study + 
					"</td><td style='width:80px'>" + Sci_StudyPercent + "%" +
					"</td><td><div style='background-color:#307d7e; width:" + Sci_StudyPercent + "%; height:15px;'></div></td></tr>" +
					"<tr><td style='width:150px'>TOTAL: " + length +
					"</td><td></td><td></td></tr>"
					"</table></div>";
					
					
					O('main-bottom').innerHTML = table;
					O('main-top-left').innerHTML = stats;
					}
		}
		request.send(dataString);
}

function getSource(number) {
	var left = document.getElementById("left_" + number);
	var node = document.getElementById("node_" + number);
	var right = document.getElementById("right_" + number);
	var filename = document.getElementById("filename_" + number);
	var keyValue = document.getElementById("keyValue_" + number);
	
	left = left.innerText;
	node = node.innerText;
	right = right.innerText;
	var searchString = left + " " + node + " " + right
	filename = filename.value;
	keyValue = keyValue.value;
	
	dataString = "searchString="+searchString+"&filename="+filename+"&keyValue="+keyValue;
	
	request = new ajaxRequest()
	request.open("POST", "index.php?controller=Corpus&action=getSource", true)
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	//request.setRequestHeader("Content-length", dataString.length)
	//request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function() {
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null) {
					O('main-top-right').innerHTML = this.responseText;
				}
	}
	request.send(dataString);
}

function refineSearch(element) {

	var searchTerm = element.text;

	dataString = "corpusName=Search All"+"&outputType=KWIC"+"&inputType=listlink"+"&searchTerm="+searchTerm+"&sort1=1R"+"&sort2=2R"+"&sort3=3R";

	request = new ajaxRequest()
		request.open("POST", "index.php?controller=Corpus&action=search", true)
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		//request.setRequestHeader("Content-length", dataString.length)
		//request.setRequestHeader("Connection", "close")
		request.onreadystatechange = function() {
			if (this.readyState == 4)
				if (this.status == 200)
					if (this.responseText != null) {
						var text = '{"lines": ' + this.responseText + '}';
						//O('main-bottom').innerHTML = text;
						var obj = JSON.parse(text);
						var length = obj.lines.length;
						var table = '<div class="table-responsive"><table class="table table-striped">';
					
						var Fiction = 0;
						var Sci_News = 0;
						var Sci_Study = 0;
						var Essay = 0;
					
						for(var i=0; i<length; ++i) {
							var filename = obj.lines[i].file;
							var left = obj.lines[i].left;
							var nodeLine = obj.lines[i].node;
							var right = obj.lines[i].right;
							var data = obj.lines[i].folder;
							var keyValue = obj.lines[i].keyValue;
						
							if(data == "Fiction") Fiction++;
							if(data == "Non_fiction") Essay++;
							if(data == "Sci_Study") Sci_Study++;
							if(data == "Sci_News") Sci_News++;
						
							table += "<tr><td id='left_" + i + "' align='right'>" + left + "</td>" + 
											"<td id='node_" + i + "'>" + nodeLine + "</td>" + 
											"<td id='right_" + i + "'>" + right + "</td>" +
											"<td align='right'>" + 
												"<input type='hidden' id='filename_" + i + "' name='filename' value='" + filename + "'>" + 
												"<input type='hidden' id='keyValue_" + i + "' name='keyValue' value='" + keyValue + "'>" +
												"<button class='btn btn-sml btn-success' onclick='getSource(" + i + ")' name='" + data + "'>" + data + "</button>" +
											"</td></tr>";
						}
					
					table += '</table></div>';	
					O('main-bottom').innerHTML = table;

				}
					
		}
		request.send(dataString);	
}

function collocation() {
	var collocationForm = "<div class='form-group form-inline'>";
	collocationForm += "<input type='text' id='collocationForm' class='form-control' name='collocationSearch' placeholder='Add a collocating word'>";
	collocationForm += "</div>";
	collocationForm += "<div class='form-group form-inline'>";
	collocationForm += "<select id='colloLeft' class='form-control'>";
	collocationForm += "<option selected>3L</option>";
	collocationForm += "<option>2L</option>";
	collocationForm += "<option>1L</option>";
	collocationForm += "<option>NONE</option>";
	collocationForm += "</select>";
	collocationForm += "<select id='colloRight' class='form-control'>";
	collocationForm += "<option selected>3R</option>";
	collocationForm += "<option>2R</option>";
	collocationForm += "<option>1R</option>";
	collocationForm += "<option>NONE</option>";
	collocationForm += "</select>";
	collocationForm += "</div>";
	collocationForm += "<button type='button' class='btn btn-sm btn-warning form-inline' onclick='sendCollocation()'>Check</button>";
	$(collocationForm).insertAfter('#collocation');
	$('#collocation').hide(200);
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