<?php

// configuration stuff
require_once('config.php');

// seek ye predefined variables

$snum = isset( $_GET['s'] ) ? $_GET['s'] : 20;		// number of slides
$tag = isset( $_GET['t'] ) ? str_rot13( substr( $_GET['t'], $snum  ) ) : 'dog'; // coded tag
$inter = isset( $_GET['i'] ) ? $_GET['i'] : 20;		// time interval

// check box for unique user setting
$cbox =  ( !isset ( $_GET['u'] ) or $_GET['u'] == 1 ) ? 'checked="checked"' : '';

// check box for flickr commons
$commonsbox =  ( $_GET['c'] == 1 ) ? 'checked="checked"' : '';

// "heather" mode for hiding tags
$hbox = ( $_GET['h'] == 'y' ) ? 'checked="checked"' : '';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr</title>
	<?php include 'header-meta.php'?>

	<link rel="stylesheet" href="css/style.css" media="screen">
	
	<!--  get some jQuery  -->
	<script src="https://code.jquery.com/jquery.min.js"></script>
	
	<!--  pecha scripts  -->
	<script src="js/pechaflickr.js"></script>
	
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
	
	<input type="checkbox" id="commonsbox" name="commons" value="off" <?php echo $commonsbox?> onChange="makego()"  /> Flickr Commons Only<br />

	<input type="checkbox" id="hbox" name="heathermode" value="off" <?php echo $hbox?> onChange="makego()"  /> Heather Mode (Hide tags for users to guess from photos)<br />

	pecha share<br />
	<input type="text" size="80" id="pgo" title="share url" onClick="this.select()" >
	</div>

	<input value="play" type="button" id="play" onClick="if (document.getElementById('ptag').value == '') {alert('This wont work unless you type in a tag!') } else if (document.getElementById('snum').value < 1 || document.getElementById('snum').value > 50) {alert('Number of slides must be between 1 and 50.') } else  {window.open('pecha.php?n=' + document.getElementById('snum').value  + '&h=' + document.getElementById('hbox').checked + '&c=' + document.getElementById('commonsbox').checked +  '&t=' + ran_string(document.getElementById('snum').value) + str_rot13(document.getElementById('ptag').value) + '&i=' + document.getElementById('inter').value + '&u=' + document.getElementById('cbox').checked , 'pecha', 'fullscreen=yes')}" />
	

</form>

<p><em>pechaflickr = the sound of random flickring</em></p>

<p>Can you improv a coherent presentation from images you have never seen? Pechaflickr is a mashup of <a href="https://www.pechakucha.com/" target="_blank">pechakucha</a> and <a href="https://www.powerpointkaraoke.com/" target="_blank">powerpoint karaoke</a> created by <a href="https://cog.dog" target="_blank">Alan Levine</a>.</p>

<p>Enter a tag, press play, and see how well you can communicate a coherent message illustrated by 20 random flickr photos, each one on screen for 20 seconds. Advanced options let you change the number of images and/or the timing as well as use images just from the <a href="http://flickr.com/commons" target="_blank">Flickr Commons</a>.</p>

<p>Curious? <a href="http://cogdogblog.com/stuff/techtalks13/">I used pechaflickr to talk about pechaflickr.</a> If you are making use of this, <a href="http://bit.ly/pechaflickr-survey">please share with me</a>!</p>

<div text-center="aligncenter">

<h2>Tweets About Pechaflickr (<a href="https://twitter.com/search?q=pechaflickr&f=live" target="_blank">go</a>)</h2>
<p class="text-center"><em><small>through Feb 2023 before twitter died to me</small></em></p>

<iframe style="border:0; width:100%;max-width:600px;height:500px" src="https://hawksey.info/tagsexplorer/widget/?q=SELECT%20B%2C%20A%2C%20C%2C%20E%2C%20COUNT(A)%20%20GROUP%20BY%20B%2C%20A%2C%20C%2C%20E%20ORDER%20BY%20E%20DESC%20LIMIT%2010&d=1jDgB1sCNMBgLkWQkW5X4_LvWwnzAevhjlbfWIeJ5kak&sheet=Archive&theme=light&linkColor=%231c94e0&widgetHeight=500&excludeTracking=true&excludeThread=true&includeRT=true&includeMedia=true" ></iframe>


</div>


<?php include 'footer.php'?>
</body>
</html>
