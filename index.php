<?php
// seek ye predefined variables

$tag = isset( $_GET['t'] ) ? $_GET['t'] : 'dog'; 	// tag
$snum = isset( $_GET['s'] ) ? $_GET['s'] : 20;		// number of slides
$inter = isset( $_GET['i'] ) ? $_GET['i'] : 20;		// time interval
$cbox =  ( !isset ( $_GET['u'] ) or $_GET['u'] == 1 ) ? 'checked="checked"' : '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr</title>
	
	<script src="js/jquery-1.7.2.min.js"></script>	<link rel="stylesheet" href="style.css" media="screen">
	
	<script>
	$(document).ready(function(){
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

	function makego() {
	// build the link for the go launcher url
		var t = document.getElementById('ptag').value;
		var s = document.getElementById('snum').value;
		var i = document.getElementById('inter').value;
	
		if (document.getElementById('cbox').checked) {
			var u = 1;
		} else {
			var u = 0;
		}
	
		var purl = remove_qs(window.location.href);
	
		document.getElementById('pgo').value = purl + 't=' + t + '&s=' + s + '&i=' + i + '&u=' + u;
	}

	function remove_qs(url) {
		//removes query strong from  url
		// thx stackoverflow http://stackoverflow.com/questions/11543398/jquery-how-to-remove-query-string-from-a-link
		var a = document.createElement('a'); // dummy element
		a.href = url;   // set full url
		a.search = "";  // blank out query string
		return a.href;
	}
</script>

</head>
<body onLoad="calctime(); makego()">

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


pecha share<br />
<input type="text" size="80" id="pgo" title="share url" onClick="this.select()" >
</div>

<input value="play" type="button" id="play" onClick="if (document.getElementById('ptag').value == '') {alert('This wont work unless you type in a tag!') } else if (document.getElementById('snum').value < 1 || document.getElementById('snum').value > 50) {alert('Number of slides must be between 1 and 50.') } else  {window.open('pecha.php?tag=' + document.getElementById('ptag').value + '&n=' + document.getElementById('snum').value + '&i=' + document.getElementById('inter').value + '&u=' + document.getElementById('cbox').checked , 'pecha', 'fullscreen=yes')}" />




</form>

<p><em>pechaflickr = the sound of random flickring</em></p>

<p>Can you improv a coherent presentation from images you have never seen?</p>

<p> Enter a tag, and see how well you can communicate sense of 20 random flickr photos, each one on screen for 20 seconds. Advanced options offer  different settings.</p>

<p>Curious? <a href="http://cogdogblog.com/stuff/techtalks13/">I used pechaflickr to talk about pechaflickr.</a> If you are making use of this, <a href="http://bit.ly/pechaflickr-survey">please share with me</a>!</p>

<p class="credit"><a href="http://pechaflickr.net/">pechaflickr.net</a> • <a href="notes.php">notes 'n stuff for geeks</a><br />pechaflickr is a cogdog production<br />
<a href="http://cogdog.info/">cogdog.info</a> •  <a href="http://twitter.com/cogdog">@cogdog</a>
</div>

<?php include 'footer.php'?>
</body>
</html>
