<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr notes</title>
	
	<style type="text/css" title="text/css">
		body
		{
			background-color: #fff;
			margin: 0;
			padding: 0;
			font-family: arial;
		}
		
		#wrapper
		{
			width: 600px;
			margin: 150px auto 100px;
			text-align: center;
		}
		
		li 
		{
			text-align: left;
		}
		
		input
		{
			padding: 4px 8px;
			margin: 18px auto;
			background-color: #eb47a0;
			border: 2px solid #777;
			color: #fff;
			font-size: 30px;
			font-weight: 800;
			text-align: center;
			display: block;
			width: 100%;
		}
		
		#play
		{
			background-color: #2f7bef;
			width: 140px;
			display: inline;
		}
		
		#snum {
			width: 80px;
			display: inline;
		
		}
		
		p
		{
			font-size: 20px;
			line-height: 24px;
			text-align: left;
			color: #666;
		}
		
		.credit
		{
			font-size: 14px;
			text-align: center;
			margin-top: 80px;
		}
		
		a, a:link, a:visited
		{
			color: #666;
			text-decoration: none;
			font-weight:bold; 
			
		}
		
		a:hover { color: #eb47a0; }
</style>

</head>
<body>

<div id="wrapper">

<img src="images/pecha-flickr.jpg" alt="pecha flickr" class="banner" width="530" height="114" />


<p>The idea for pechaflickr came completely from <a href="http://gforsythe.ca/">Giulia Forsythe</a> who asked if my <a href="http://5card.cogdogblog.com/">Five Card Flickr</a> could do this (no, but  <a href="http://www.phpflickr.com/">phpflickr</a> and the useful <a href="http://jquery.malsup.com/cycle/">jQuery Cycle</a> made it not too hard).</p>

<p>You can download the code and run it on your own web site; see <a href="https://github.com/cogdog/pechaflickr">github.com/cogdog/pechaflickr</a>

<p><strong>To Maybe Be Done Someday</strong></p>
<ul>
<li>Create a way to save a series as a set to share or post with notes (a version as a wordpress template?)</li>
<li>What do you want? Let me know <a href="http://cogdog.info">http://cogdog.info</a>
</ul>

<p><strong>History</strong></p>
<ul>
<li>5.1.2011 - [v 0.1] First version released</li>
<li>5.11.2011 - Based on feedback, added the counter (I refuse to add a timer, that takes away the fun).</li>
<li>7.11.2011 - On request of @kylemackie, added a field option to specify other numbers of slides for those wanting to do shorter (or longer) than standard 20 slide pecha kucha.</li>
<li>7.13.2011 - [v 0.2] dded the flickr safe search option for results to try and reduce the fear of random naked body parts appearing (no guarantees). Source code posted to google <a href="http://code.google.com/p/pechaflickr/">http://code.google.com/p/pechaflickr/</a></l>
<li>8.15.2011 - Revised code to hopefully address the bug of all images going to a white bar-  making sure only landscape orientation photos are fetched from flickr, and none that are too small in one dimension. All images displayed are now exactly sized to correct dimensions to fit the CSS div used for display.</li>
<li>10.20.2011 - [v 0.3] Slide show options now moved to a <a href="advanced.html">separate page</a> to allow user selection of number of slides and duration between slides- an onscreen calculator shows the duration of the slideshow. <a href="index.html">Basic front page</a> offers standard 20x20 pecha kucha style.</li>
<li>10.29.2011- [v 0.4] Tweaked flickr fetch to increase randomizing of photos, updated splash images to remove references to "20" slides.</li>
<li>11.12.2011- <strike>The slide show screen now displays credits for flickt photo- photo title and photo ownerflickr  name.</strike> This was a bit buggy, it is going back into the lab.</li>
<li>04.26.2012 - [v 0.5] Bunch o' fixes. Fixed problem of the mystery white box (we were running out of images due to a bad test condition). Improved the randomness by using 1 of six ordering schemes for fetching photos (by date posted, by date taken, by interestingness, and each of these either ascending or descending). Also, to improve variety set up photo selection to not include more than one photo posted by the same person. Lastly, we now check for a lack of sufficient numbers of photos found, e.g. for obscure tags, or ones with not enough photos to give good randomness (specified by 4 times the number requested)</li>
<li>05.29.2012 - [v 0.51] Put all advanced options in toggle open div for main page, added check box option to allow for photos from same owner.</li>
<li>01.17.2013 - [v 0.53] New field generated under advanced options to save the settings as a URL, e.g. so another show can be generated with same settings. Also corrected previous version which was not passing the unique owner checkbox option to the script, whoops.</li>
<li>03.06.2014 - [v 1.0] Now equipped with a credits screen at end of a round that lists and displays thumbnails of all images used (see <a href="http://cogdogblog.com/2014/03/06/pechaflickr-super-powers/">http://cogdogblog.com/2014/03/06/pechaflickr-super-powers/</a>)</li>
<li>03.12.2014 - moving the code archive to github cause that's where the cool kids are.</li>
<li>04.22.2014 - about time we had our own domain <a href="http://pechaflickr.net/">pechaflickr.net</a></li>
<li>08.23.2015 - implemented <a href="http://vegas.jaysalvat.com/" target="_blank">vegas background slide show library</a> for full screen and responsive display of images, moved status to bottom of screen</li>

</ul> 

<p><strong>What Are You Reading This Stuff For?</strong></p>
<form id="pecha" method="post" action="index.php">
<input type="submit" id="play" value="Go Play" />
</form>

<p class="credit"><a href="http://pechaflickr.net/">pechaflickr.net</a><br />pechaflickr is a cogdog production<br />
<a href="http://cogdog.info">http://cogdog.info</a> •  <a href="http://twitter.com/cogdog">@cogdog</a>
</div>


<?php include 'footer.php'?>
</body>
</html>
