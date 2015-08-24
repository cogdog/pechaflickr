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
if (FLICKRKEY == 'XXXXWONTWORKWITHOUTYOUROWNKEYXXXXX') die ('There is no pechaflickr without a valid flickr API key. Check the configuration file.');

// set up params from input URL
$flickr_tag = (isset($_REQUEST['tag'])) ? $_REQUEST['tag'] : 'dog';
$slidecount = (is_numeric($_REQUEST['n'])) ? $_REQUEST['n'] : 20;
$interval = (is_numeric($_REQUEST['i'])) ? $_REQUEST['i'] : 20;
$unique = ($_REQUEST['u'] == true) ? true : false;


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
  
// go fetch the photos
$photos =  load_pecha($flickr_tag, $slidecount, $unique);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="Alan Levine" />
	<meta name="description" content="Flickr a la Pecha Kucha" />

	<link rel="stylesheet" href="css/pecha.css" media="screen">	
	
	
	<?php if ($photos != -1):?>
	
	<!-- Vegas styles, baby -->
	<link rel="stylesheet" href="css/vegas.min.css">
	
	<!--  jQuery library -->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	
	<!--  Vegas plugin -->
	<script src="js/vegas.min.js"></script>
	
	<!--  initialize when  DOM sez "Ready Boss" -->
	<script type="text/javascript">	
	
	$(document).ready(function() {

		$("body").vegas({
			delay: <?php echo $interval * 1000?>,
			slides: [
				{src: "images/splash<?php echo rand(1,5)?>.jpg"}, 
				
				<?php
				// we just need to output the images as img tabs
				for ($i=1; $i<=$slidecount; $i++) {
		
					$indx = $i-1; // correct to array index
					echo '{src:"' . $photos['link'][$indx]  . '" },' . "\n";
				}
				
				echo '{src:"' . $photos['link'][$indx]  . '" },' . "\n";
				?>
			],
			
			walk: function (index, slideSettings) {
				$('.caption').html(index + ' / <?php echo $slidecount?>');
			
				if (index == (<?php echo $slidecount?> + 1)) {
					$("body").vegas( 'pause' );
					$('.caption').html('DONE!');
        			$("#marquee").css("left","20%");
        			$(".vegas-slide").css("opacity","0.2");
				}
			}
		});	
	});
	</script>
	
	<?php endif?>
	
	<title>pechaflickr for <?php echo $flickr_tag?></title>

</head>
<body>



<?php if ($photos == -1):?>
	
	<h1 class="sorry">We are sorry, but pechaflickr did not find enough flickr photos tagged <?php echo $flickr_tag?> to make this work.</h1>
	<form><input type="button" value="try again?" onClick="window.close()"></form>
	</div>
	
	<div id="logo">
		<a href="http://pechaflickr.net/" target="_pecha"><img src="images/pecha-flickr-bk.png" alt="pecha-flickr-bk" alt="pechaflickr" width="120" height="26" /></a>
	</div>
	
	
<?php else:?>


<div id="stripe">
	<!-- our lovely logo -->	
	<a href="http://pechaflickr.net/" target="_pecha"><img src="images/pecha-flickr-bk.png" alt="pecha-flickr-bk" alt="pechaflickr" id="logo" /></a>

	<!-- holder for the slide counter -->
	<span class="caption"></span>

	<!-- displays parameters for this round -->	
	<span id="stats"><?php echo $slidecount?> flickr photos tagged <a href="http://flickr.com/photos/tags/<?php echo $flickr_tag?>" target="_blank"><?php echo $flickr_tag?></a> displayed for <?php echo $interval?> seconds each (total run time: <?php echo sec2hms($slidecount * $interval) ?>)
	</span>
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
