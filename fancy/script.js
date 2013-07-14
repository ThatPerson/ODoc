function loadTextFileAjaxSync(filePath, mimeType){
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.open("GET",filePath,false);
	if (mimeType != null) {
		if (xmlhttp.overrideMimeType) {
			xmlhttp.overrideMimeType(mimeType);
		}
	}
	xmlhttp.send();
	if (xmlhttp.status==200){
		updateFault = 0;
		return xmlhttp.responseText;
	}else {
		updateFault = 1;
		return null;
	}
}
var ro;
var titles;
var urls;
function setup() {

	var l = loadTextFileAjaxSync(window.location.href + "../docs/DOCLIST");
	ro = l.split("\n");
	var i = 0;
	var resp = "";
	for (i = 0; i < ro.length-1; i++) {
		var q = ro[i].split("::");
		resp += '<div onclick = "visit('+i+')" class="button"><p class="button">'+q[1]+'</p></div>';
		
	}
	document.getElementById("res").innerHTML = resp;
}
function visit(i) {
	ro[i]
	var q = ro[i].split("::");
	var p = loadTextFileAjaxSync(window.location.href+"../parser.php?q="+q[0]);

	document.getElementById("maincontent").innerHTML = "<div class='text'>"+p+"</div>";
}
function searchq() {
	var term = document.getElementById("search").value;
	var l = loadTextFileAjaxSync(window.location.href + "../docs/DOCLIST");
	ro = l.split("\n");
	var i = 0;
	var resp = "";
	for (i = 0; i < ro.length-1; i++) {
		var q = ro[i].split("::");
		if (q[1].indexOf(term) !== -1) {
			resp += '<div onclick = "visit('+i+')" class="button"><p class="button">'+q[1]+'</p></div>';
		}
		
	}
	document.getElementById("res").innerHTML = resp;
}
