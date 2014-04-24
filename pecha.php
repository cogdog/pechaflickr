<?php
/*
Pecha Flickr: pecha.php
version 0.53 (January 17, 2011)

by Alan Levine, cogdogblog@gmail.com
see it at http://pechaflickr.net/

This script generates the actual slide show using the jQuery cycle plugin
http://jquery.malsup.com/cycle/

Images are retrieved from flickr using phpflickr http://www.phpflickr.com/

It expects to be passed 
	the tag to look for (variable 'tag')
	number of slides to present (variable 'n')
	time interval between slides (variable 'i')
	flag for pulling from unique owners  (variable 'u' = true or false)

*/ 


// ------- SETUP ---------------------------------------------------------------
require_once('utils.php');   	// common utilities
require_once('config.php'); 	// configuration stuff

// check for flickr api key being set
if (FLICKRKEY == 'xxxxxx') die ('There is no pechaflickr without a valid flickr API key. Check the configuration file.');

// set up params from input URL
$flickr_tag = (isset($_REQUEST['tag'])) ? $_REQUEST['tag'] : 'dog';
$slidecount = (is_numeric($_REQUEST['n'])) ? $_REQUEST['n'] : 20;
$interval = (is_numeric($_REQUEST['i'])) ? $_REQUEST['i'] : 20;
$unique = ($_REQUEST['u'] == true) ? true : false;

// used to size images to 970 px wide from z sized originals (640)
$size_factor  = 970.0/640.0;

function sec2hms ($sec )
// used to convert time in seconds to minutes"seconds
// code from http://www.laughing-buddha.net/php/lib/sec2hms/ but removed the hours
  {

    // start with a blank string
    $hms = "";
    
    
    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= $minutes . ":";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
    return $hms;  
  }


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="Alan Levine" />
	<meta name="description" content="Flickr a la Pecha Kucha" />

	<style type="text/css">
	
	body {background-color:#000; font-family: helvetica, arial, san-serif; color:#fff;}
	h1 {margin:0; font-size: 3em;}
	
	.slideshow { height: 625px; width: 1000px; position:absolute; top: 5px; left: 170px; z-index:1 }
	.slideshow img { padding: 15px; border: 1px solid #ccc; background-color: #eee; }
		
	#logo {
		position: absolute;
		top:5px;
		left:10px;
	}
	
	#caption {
		padding: 6px;
		border: 2px solid #555;
		color: white;
		font-weight: bold;
		font-size: 28px;
		position: absolute;
		top: 100px;
		left: 10px;
		width: 120px;
	}
	
	#stats {
		padding: 6px;
		color: white;
		font-size: 12px;
		position: absolute;
		top: 220px;
		left: 10px;
		width: 120px;
	}
	
	#loader {
		margin-top: 100px auto 10px;
		text-align:center;
		width: 200px;
	}
	
	#credit {
		color: #FFFC1C;
	}
	
	#marquee { visibility: hidden; width: 800px; position:absolute; top: 80px; left: 200px; z-index: -1; }
		
	#marquee strong, .pink { color: #e74a9b;}
	
	.blue { color: #3079f9;}
	
	.pf {font-size:1.5em;}
	s
	a, a:link, a:visited
		{
			color: #3079f9;
			text-decoration: none;
			font-weight:bold; 	
		}	
	a:hover { color: #e74a9b; }

	h1.sorry {
		margin-top:200px;
	}
	
	
	a.myButton {
	-moz-box-shadow: 0px 1px 0px 0px #f0f7fa;
	-webkit-box-shadow: 0px 1px 0px 0px #f0f7fa;
	box-shadow: 0px 1px 0px 0px #f0f7fa;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #33bdef), color-stop(1, #019ad2));
	background:-moz-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-webkit-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-o-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-ms-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:linear-gradient(to bottom, #33bdef 5%, #019ad2 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bdef', endColorstr='#019ad2',GradientType=0);
	background-color:#33bdef;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #057fd0;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px -1px 0px #5b6178;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #019ad2), color-stop(1, #33bdef));
	background:-moz-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-webkit-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-o-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-ms-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:linear-gradient(to bottom, #019ad2 5%, #33bdef 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#019ad2', endColorstr='#33bdef',GradientType=0);
	background-color:#019ad2;
}
.myButton:active {
	position:relative;
	top:1px;
}

	
	</style>
	
	<?php if ($photos != -1):?>
	<!-- include jQuery library -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	
	<!-- include Cycle plugin -->
	<script type="text/javascript" src="js/jquery.cycle.all.2.74.js"></script>
	
	<!--  initialize the slideshow when the DOM is ready -->
	<script type="text/javascript">	
	
	$(document).ready(function() {
	
		$('.slideshow').cycle({
			fx: 'fadeZoom',
			timeout: <?php echo $interval * 1000?> ,
			width:970,
			autostop: 1, 
			end:   function() {  
				$('#caption').html('DONE!');
        		$('#mainstage').fadeOut('slow'); 
        		$("#marquee").css("visibility","visible");	
        	},
        	before: function() {
            	$('#caption').html(this.alt);
        	}

		});
	});
	</script>
	
	<?php endif?>
	
	<title>pechaflickr for <?php echo $flickr_tag?></title>

</head>
<body>

<div class="slideshow" id="mainstage">


<?php
// go fetch the photos
$photos =  load_pecha($flickr_tag, $slidecount, $unique);
?>

<?php if ($photos == -1):?>
	
	<h1 class="sorry">We are sorry, but pechaflickr did not find enough flickr photos tagged <?php echo $flickr_tag?> to make this work.</h1>
	<form><input type="button" value="try again?" onClick="window.close()"></form>
	</div>
	
	<div id="logo">
		<a href="http://pechaflickr.net/" target="_pecha"><img src="images/pecha-flickr-bk.png" alt="pecha-flickr-bk" alt="pechaflickr" width="120" height="26" /></a>
	</div>
	
	
<?php else:?>

		<img src="images/splash<?php echo rand(1,5)?>.jpg" alt="Get Ready!" width="970" height="738" />
		
		<?php
		// we just need to output the images as img tabs
		for ($i=1; $i<=$slidecount; $i++) {
		
			$indx = $i-1; // correct to array index
			echo '<img src= "' . $photos['link'][$indx] . '" width="970" height="' . intval($photos['height'][$indx] * $size_factor)  . '"  alt="' . $i  . ' / ' . $slidecount . '"  />' . "\n";
		}
		
		?>	
</div>



<!-- our lovely logo -->	
<div id="logo"><a href="http://pechaflickr.net/" target="_pecha"><img src="images/pecha-flickr-bk.png" alt="pecha-flickr-bk" alt="pechaflickr" width="120" height="26" /></a></div>

<!-- holder for the slide counter -->
<div id="caption"></div>

<!-- displays parameters for this round -->	
<div id="stats"><?php echo $slidecount?> flickr photos tagged <a href="http://flickr.com/photos/tags/<?php echo $flickr_tag?>" target="_blank"><?php echo $flickr_tag?></a> displayed on screen for <?php echo $interval?> seconds each.<br /><br />Total run time: <?php echo sec2hms($slidecount * $interval) ?><br /><br />
</div>

<!-- hidden div for the final list of photos -->
<div id="marquee">
<h1>Your <span class="pf">pecha<span class="blue">flick</span><span class="pink">r</span></span> Experience</h1>
<p>Congratulations! You improvised a story based on <strong><?php echo $slidecount?></strong> random flickr photos tagged <strong><?php echo $flickr_tag?></strong> displayed every <strong><?php echo $interval?></strong> seconds, using the following images. <br />
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://pechaflickr.net/index.php?t=<?php echo $flickr_tag?>&s=<?php echo $slidecount?>&i=<?php echo $interval?>&u=<?php echo $unique?>" data-text="I just did #pechaflickr with <?php echo $slidecount?> random flickr images tagged &quot;<?php echo $flickr_tag?>&quot;" data-via="cogdog" data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

</p>

<?php 
	// holder for the list of links
	$list_str = '';
	
	// cycle through the photos
	for ($i=0; $i< $slidecount; $i++) {
		// output the small size image
		echo '<a href="' . $photos['url'][$i] . '"><img src="' . $photos['icon'][$i] . '" /></a> ';
		
		// store the list credit
		$list_str .= '<li><a href="' . $photos['url'][$i] . '">' . $photos['url'][$i] . "</a></li>\n";
	}
?>

<ol>
<?php echo $list_str?>
</ol>

<a href="#" onClick="window.close()" class="myButton">let's  pechaflickr again!</a>
</div>
<?php endif?>

<?php include 'footer.php'?>

</body>
</html>
