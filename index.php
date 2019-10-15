<?php
// seek ye predefined variables

$snum = isset( $_GET['s'] ) ? $_GET['s'] : 20;		// number of slides
$tag = isset( $_GET['t'] ) ? str_rot13( substr( $_GET['t'], $snum  ) ) : 'dog'; // coded tag
$inter = isset( $_GET['i'] ) ? $_GET['i'] : 20;		// time interval

// check box for user setting
$cbox =  ( !isset ( $_GET['u'] ) or $_GET['u'] == 1 ) ? 'checked="checked"' : '';

// "heather" mode for hiding tags
$hbox = ( $_GET['h'] == 'y' ) ? 'checked="checked"' : '';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr</title>
	
	<!--  get some jQuery  -->
	<script src="https://code.jquery.com/jquery.min.js"></script>
	
	<link rel="stylesheet" href="css/style.css" media="screen">
	
	<script>
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
	</script>

	
<script type="text/javascript" language="JavaScript">
	function calctime() {
		var totaltime = document.getElementById('snum').value * document.getElementById('inter').value;
	
		var s = totaltime % 60;
		var m = Math.floor((totaltime % 3600 ) /60);
		
		var secstring = s<10 ? "0"+s : s;
	
		var disp = document.getElementById("runtime");
		
		disp.innerHTML = m+":"+secstring;
	}
	
	function remove_qs(url) {
		//removes query strong from  url
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
		document.getElementById('pgo').value = purl + '?t=' + t + hmode + '&s=' + s + '&i=' + i + '&u=' + u;
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
</script>

</head>
<body>

<div id="wrapper">

<img src="images/pecha-flickr.jpg" alt="pecha flickr" class="banner" width="530" height="114" />

<form id="pecha">

	<input name="tag" type="text" size="40" id="ptag" value="<?php echo $tag?>" title="enter a tag to search on in flickr for image" onChange="makego()"  />


	<img src="images/tri-right.png" class="toClick"> <span id="show_label">Advanced Options</span><br />

	<div class="revealMenu" style="display: none;">
	<input name="num" type="text" size="4" value="<?php echo $snum?>" id="snum" onChange="calctime(); makego()" /> slides 


	<select name="interval" id="inter" onChange="calctime(); makego()">

	<?php

		for ($i=5; $i<31; $i++) {
			$selected = ($i == $inter) ? ' selected="selected"' : '';
		
			echo '<option value="' . $i . '"' . $selected . '>' . $i . "</option>\n";
		}

	?>
	</select> sec interval 

	<span id="runtime">6:40</span> total run time<br />

	<input type="checkbox" id="cbox" name="unique" value="on" <?php echo $cbox?> onChange="makego()"  /> Unique Photo Owners (More variability)<br />

	<input type="checkbox" id="hbox" name="heathermode" value="off" <?php echo $hbox?> onChange="makego()"  /> Heather Mode (Hide tags for users to guess from photos)<br />

	pecha share<br />
	<input type="text" size="80" id="pgo" title="share url" onClick="this.select()" >
	</div>

	<input value="play" type="button" id="play" onClick="if (document.getElementById('ptag').value == '') {alert('This wont work unless you type in a tag!') } else if (document.getElementById('snum').value < 1 || document.getElementById('snum').value > 50) {alert('Number of slides must be between 1 and 50.') } else  {window.open('pecha.php?n=' + document.getElementById('snum').value  + '&h=' + document.getElementById('hbox').checked +  '&t=' + ran_string(document.getElementById('snum').value) + str_rot13(document.getElementById('ptag').value) + '&i=' + document.getElementById('inter').value + '&u=' + document.getElementById('cbox').checked , 'pecha', 'fullscreen=yes')}" />
	

</form>

<p><em>pechaflickr = the sound of random flickring</em></p>

<p>Can you improv a coherent presentation from images you have never seen?</p>

<p>Enter a tag, press play, and see how well you can communicate a coherent message illustrated by 20 random photos, each one on screen for 20 seconds. Advanced options let you change the number of images and/or the timing.</p>

<p>Curious? <a href="http://cogdogblog.com/stuff/techtalks13/">I used pechaflickr to talk about pechaflickr.</a> If you are making use of this, <a href="http://bit.ly/pechaflickr-survey">please share with me</a>!</p>

<div class="aligncenter">

<h2>Tweets About Pechaflickr (<a href="https://twitter.com/search?q=pechaflickr&f=live" target="_blank">go</a>)</h2>

<iframe style="border:0; width:100%;max-width:600px;height:500px" src="https://hawksey.info/tagsexplorer/widget/?q=SELECT%20B%2C%20A%2C%20C%2C%20E%2C%20COUNT(A)%20%20GROUP%20BY%20B%2C%20A%2C%20C%2C%20E%20ORDER%20BY%20E%20DESC%20LIMIT%2010&d=1jDgB1sCNMBgLkWQkW5X4_LvWwnzAevhjlbfWIeJ5kak&sheet=Archive&theme=light&linkColor=%231c94e0&widgetHeight=500&excludeTracking=true&excludeThread=true&includeRT=true&includeMedia=true" ></iframe>


</div>


<?php include 'footer.php'?>
</body>
</html>
