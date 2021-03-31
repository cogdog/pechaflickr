function calctime() {
	var totaltime = document.getElementById('snum').value * document.getElementById('inter').value;

	var s = totaltime % 60;
	var m = Math.floor((totaltime % 3600 ) /60);
	
	var secstring = s<10 ? "0"+s : s;

	var disp = document.getElementById("runtime");
	
	disp.innerHTML = m+":"+secstring;
}

function remove_qs(url) {
	//removes query string from  url
	// thx stackoverflow http://stackoverflow.com/questions/11543398/jquery-how-to-remove-query-string-from-a-link
	
	var a = document.createElement('a'); // dummy element
	a.href = url;   // set full url
	a.search = "";  // blank out query string
	return a.href;
}


function makego() {
// build the link for the go launcher url

	// get main pechaflickr URL 
	var purl = remove_qs(window.location.href);

	// get params from current form values, t=tag, s= slide #; i = interval
	var s = document.getElementById('snum').value;
	var i = document.getElementById('inter').value;
	
	// prefix a coded version of the tag with a random string of chars of length = s
	var t = ran_string(s) + str_rot13(document.getElementById('ptag').value);


	// unique setting
	if (document.getElementById('cbox').checked) {
		var u = 1;
	} else {
		var u = 0;
	}

	// unique setting
	if (document.getElementById('commonsbox').checked) {
		var c = 1;
	} else {
		var c = 0;
	}
	
	//heather mode setting
	if (document.getElementById('hbox').checked) {
		var hmode = '&h=1';
		
		if ( purl.indexOf('index.php') > -1 ) {
			purl = purl.replace('index.php', 'heather.php'); 
		} else {
			purl += 'heather.php';
		}
		
	}  else {
		hmode = '';
	}
	
	// update display field
	document.getElementById('pgo').value = purl + '?t=' + t + hmode + '&s=' + s + '&i=' + i + '&u=' + u + '&c=' + c;
}

function ran_string( len ) {
	// create a random string of chars of length = len
	// h/t http://stackoverflow.com/a/22028809/2418186	
	var outStr = "", newStr;
	while (outStr.length < len) {
		newStr = Math.random().toString(36).slice(2);
		outStr += newStr.slice(0, Math.min(newStr.length, (len - outStr.length)));
	}
	return outStr;
}

function str_rot13(str) {
  // discuss at: http://phpjs.org/functions/str_rot13/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Ates Goral (http://magnetiq.com)
  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
  // bugfixed by: Onno Marsman

  return (str + '')
	.replace(/[a-z]/gi, function(s) {
	  return String.fromCharCode(s.charCodeAt(0) + (s.toLowerCase() < 'n' ? 13 : -13));
	});
}

$(document).ready(function(){

	calctime(); 
	makego();
	
	$(".toClick").click(function () {
		var wasClicked = $(this);
		var tdisp = document.getElementById("show_label");

		if($(wasClicked).attr("src") == 'images/tri-right.png') {
			tdisp.innerHTML = "Hide Advanced Options";	
			$(wasClicked).attr("src","images/tri-down.png");

		} else {
			$(wasClicked).attr("src","images/tri-right.png");
			tdisp.innerHTML = "Show Advanced Options";
		}
	$(this).siblings(".revealMenu").toggle();
	});
});
