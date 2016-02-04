<?php
/*
Pecha Flickr: pecha.php

by Alan Levine, cogdogblog@gmail.com
see it at http://pechaflickr.net/

This script generates the actual slide show using the jQuery Vegas plugin
http://vegas.jaysalvat.com/

Images are retrieved from flickr using phpflickr http://www.phpflickr.com/

It expects to be passed 
	the tag to look for (variable 'tag' received as a str_rot13 value
	number of slides to present (variable 'n')
	time interval between slides (variable 'i')
	flag for pulling from unique owners  (variable 'u' = true or false)
	flag for special "heather" moder where the tag is a mystery  (variable 'h' = true or false)

*/ 


// ------- SETUP ---------------------------------------------------------------
require_once('utils.php');   	// common utilities
require_once('config.php'); 	// configuration stuff

// check for flickr api key being set
if (FLICKRKEY == 'XXXXWONTWORKWITHOUTYOUROWNKEYXXXXX') die ('There is no pechaflickr without a valid flickr API key. Check the configuration file.');

// set up params from input URL
$slidecount = (is_numeric($_REQUEST['n'])) ? $_REQUEST['n'] : 20;
$flickr_tag = (isset($_REQUEST['t'])) ? str_rot13( substr( $_REQUEST['t'], $slidecount  ) ) : 'dog';
$interval = (is_numeric($_REQUEST['i'])) ? $_REQUEST['i'] : 20;
$unique = (isset($_REQUEST['u']) and $_REQUEST['u'] == 'true') ? true : false;
$heathermode = ( isset($_REQUEST['h']) and $_REQUEST['h'] == 'true') ? true : false;

if ($heathermode) {
	// in this special case, we do not display the tag, but ask players to guess what it is 
	// named for Alaska teacher Heather M who suggested this idea!
	
	$pretty_title = 'pechaflicker guess the tag';
	$tags_label = ' -- you have to guess their common tag -- ';

} else {

	// regular pecha flickr mode, always fun, the classic
	$pretty_title = 'pechaflickr for ' . $flickr_tag;
	$tags_label = ' tagged <a href="http://flickr.com/photos/tags/' . $flickr_tag . '" target="_blank">' .  $flickr_tag . '</a> ';
}

function GetBasePath() { 
	// get the director path for the current script
	// h/t ----- http://stackoverflow.com/a/15110424/2418186
	$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];

	return dirname( $url );
}



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
	
	<!--  Give us jQuery or give us dull web pages -->
	<script src="http://code.jquery.com/jquery.min.js"></script>
	
	<!--  Set up Vegas  -->
	<script src="js/vegas.min.js"></script>
	
	<!--  start the magic when DOM sez "Ready Boss" -->
	<script type="text/javascript">	
	
	$(document).ready(function() {

		// let's go to vegas! run the slide show
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
				// each slide update the current slide count
				$('.caption').html(index + ' / <?php echo $slidecount?>');
			
				// STOP THE VEGAS SHOW! We are done
				if (index == (<?php echo $slidecount?> + 1)) {
					$("body").vegas( 'pause' );
        			$("#marquee").css("left","20%");
        			$("#stripe").css("display", 'none');
        			$(".vegas-slide").css("opacity","0.2");
				}
			}
		});	
		
		
		// For heather mode, show the hidden tag display box, and hide the pechaflickr feedback at bottom
		$("#showTag").on('click',function() {
			$("#tagbox").css("top",0);
		});
		
		
	});
	</script>
	
	<?php endif?>
	
	<title><?php echo $pretty_title?></title>

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
	<span id="stats"><?php echo $slidecount?> flickr photos <?php echo $tags_label?> displayed for <?php echo $interval?> seconds each (total run time: <?php echo sec2hms($slidecount * $interval) ?>)
	</span>	
	
</div>

<!-- hidden div for the final list of photos -->
<div id="marquee">
	<h1>Your <span class="pf">pecha<span class="blue">flick</span><span class="pink">r</span></span> Experience</h1>


	<?php if ($heathermode) :?>
		<p>You have just seen <strong><?php echo $slidecount?></strong> random flickr photos each displayed every <strong><?php echo $interval?></strong> seconds. Now comes your challenge...</p>

		<p class="pf pink">What do you think is the common tag for all of the pictures that you saw? <br />



		<p><a href="#" class="myButton centertext" id="showTag">I give up. Tell me what the tag is!</a></p>
		
		<div id="tagbox">The common tag for all of these photos is <strong><span class="pink"><big><?php echo strtoupper($flickr_tag)?></span></big></strong> How did you do? Let the world know through twitter...</div>

		<p><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo GetBasePath()?>/heather.php?t=<?php echo $_REQUEST['t']?>&h=1&s=<?php echo $slidecount?>&i=<?php echo $interval?>&u=<?php echo $unique?>" data-text="I just did #pechaflickr with <?php echo $slidecount?> random flickr images and tried to guess the tag." data-via="cogdog" data-size="large">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</p>


	<?php else:?>
	
		<!-- regular pechaflickr feedback -->
		<p>Congratulations! You experienced <strong><?php echo $slidecount?></strong> random flickr photos tagged <strong><?php echo $flickr_tag?></strong> displayed every <strong><?php echo $interval?></strong> seconds, using the following images. If this was utterly fantastic, please let the world know... <br /><br />
		
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo GetBasePath()?>/index.php?t=<?php echo $_REQUEST['t']?>&s=<?php echo $slidecount?>&i=<?php echo $interval?>&u=<?php echo $unique?>" data-text="I just did #pechaflickr with <?php echo $slidecount?> random flickr images tagged &quot;<?php echo $flickr_tag?>&quot;" data-via="cogdog" data-size="large">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</p>
		<!-- end regular pechaflickr feedback -->
		
	<?php endif?>

	<?php 
		// holder for the list of links
		$list_str = '';
	
		// cycle through the photos and build a list of the flickr to show at the end
		for ($i=0; $i< $slidecount; $i++) {
			// output the small size image
			echo '<a href="' . $photos['url'][$i] . '"><img src="' . $photos['icon'][$i] . '" /></a> ';
		
			// store the list credit
			$list_str .= '<li><a href="' . $photos['url'][$i] . '" target="_blank">' . $photos['url'][$i] . "</a></li>\n";
		}
	?>

	<ol>
	<?php echo $list_str?>
	</ol>

	<!-- the closer -->
	<a href="#" onClick="window.close()" class="myButton">let's  pechaflickr again!</a>
</div><!-- end marquee -->



<?php endif?>

</body>
</html>
