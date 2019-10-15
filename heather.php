<?php
// seek ye predefined variables

function ran_string($len) {
	return substr(md5(rand()), 0, $len);
}


// set up params from input URL
$slidecount = (is_numeric($_REQUEST['s'])) ? $_REQUEST['s'] : 20;
$flickr_tag = (isset($_REQUEST['t'])) ? $_REQUEST['t'] : ran_string($slidecount) . str_rot13('dog');
$interval = (is_numeric($_REQUEST['i'])) ? $_REQUEST['i'] : 20;
$unique = (isset($_REQUEST['u']) and $_REQUEST['u'] == 1) ? 'true' : 'false';
$heathermode = ( isset($_REQUEST['h']) and $_REQUEST['h'] == 1) ? 'true' : 'false';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr (heather mode)</title>
	
	<!--  get some jQuery  -->
	<script src="https://code.jquery.com/jquery.min.js"></script>
	
	<link rel="stylesheet" href="css/style.css" media="screen">
	
<script type="text/javascript" language="JavaScript">
	
	function remove_qs(url) {
		//removes query strong from  url
		// thx stackoverflow http://stackoverflow.com/questions/11543398/jquery-how-to-remove-query-string-from-a-link
		var a = document.createElement('a'); // dummy element
		a.href = url;   // set full url
		a.search = "";  // blank out query string
		return a.href;
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


<p class="text-center"><em>pechaflickr = the sound of random flickring</em></p>

<p class="text-center">This is the "heather" mode of <a href="index.php">pechaflickr</a>... a slideshow of <strong><?php echo $slidecount?></strong> random flicker photos will appear on screen for <strong><?php echo $interval?></strong> seconds each.</p>

<p class="text-center">Can you guess the tag that is common to all the photos?</p>

<form id="pecha">



	<input value="play" type="button" id="play" onClick="window.open('pecha.php?n=<?php echo $slidecount?>&h=<?php echo $heathermode?>&t=<?php echo $flickr_tag?>&i=<?php echo $interval?>&u=<?php echo $unique?>' , 'pecha', 'fullscreen=yes')" />

	

</form>


<?php include 'footer.php'?>
</body>
</html>
