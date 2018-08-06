<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>pechaflickr notes</title>
	
	<link rel="stylesheet" href="css/style.css" media="screen">


</head>
<body>

<div id="wrapper">

<img src="images/pecha-flickr.jpg" alt="pecha flickr" class="banner" width="530" height="114" />


<p>The idea for pechaflickr came from someone who used my <a href="http://5card.cogdogblog.com/">Five Card Flickr</a> and asked if it could do a spontaneous pecha kucha type presentation. With some digging inti  <a href="http://www.phpflickr.com/">phpflickr</a> and the useful <a href="http://jquery.malsup.com/cycle/">jQuery Cycle</a> I as able to conjure this site).</p>


<p>You can download the code and run it on your own web site; see <a href="https://github.com/cogdog/pechaflickr">github.com/cogdog/pechaflickr</a>

<hr />

<h2>Questions, Some Answers</h2>

<blockquote class="pink"><strong>I am a 5th grade teacher and my kids absolutely love pechaflikr.  They have found a whole new way to look at vocabulary words. <br /><br />

Occasionally though, inappropriate pictures come up with our vocab words.  Yesterday, our word was "era" and a Victoria Secret model came up in her bra and panties.  <br /><br />

Is there a way we can use this wonderful fun game and censor some of the random pictures that may be inappropriate?</strong></blockquote>


<p>I understand your concern about the potential for inappropriate photos to come up. Pechflickr use the flickr search mechanism that uses <a href="https://info.yahoo.com/safely/us/yahoo/flickr">only images marked as "safe" according to flickr</a>; however this is completely dependent on the person who posts the photos to follow these guidelines. </p>

<p>You can report a photo that is in appropriate as detailed at <a href="https://info.yahoo.com/safely/us/yahoo/flickr">https://info.yahoo.com/safely/us/yahoo/flickr</a> but that's really an after the fact act. 

<p>
So to answer you, I cannot censor the photos that come in. 
</p>

<p>
If you want to make completely sure that you have a safe set of images what I can suggest is to make you own pool (see the next question!)
</p>

<hr />

<blockquote class="pink"><strong>Can I use pechaflickr to use only my own photos?</strong></blockquote>


<p>Certainly, if you use a tag that is unique to your photos. The way pechaflickr looks for random photos requires four times as many as the desired number for a round; so if you want to show 20 photos in a round of pechaflickr, you will need at least 80 photos that use the tag. You should also open the Advance options and uncheck the option for <code>Unique Photo Owners (More variability)</code> (this allows it to pick more than one photo from the same person).

<hr />

<h2>Random Assorted Comments / Tips</h2>

<blockquote class="twitter-tweet" data-lang="en"><p lang="en" dir="ltr"><a href="https://twitter.com/cogdog">@cogdog</a> sixth grade students struggled not to say &quot;Um&quot; as they created a story about each dog. Rule #2 : give dog a very silly name.</p>&mdash; teresa (@renlibrarian) <a href="https://twitter.com/renlibrarian/status/737679042049155072">May 31, 2016</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>


<h2>Stuff To Maybe Be Do Some Nebulous Day</h2>

<ul>
<li>Create a way to save a series as a set to share or post with notes (a version as a wordpress template?)</li>
</ul>

<hr />
<h2>Pechaflickr History</h2>

<ul>
<li>5.1.2011 - [v 0.1] First version released</li>
<li>5.11.2011 - Based on feedback, added the counter (I refuse to add a timer, that takes away the fun).</li>
<li>7.11.2011 - On request of @kylemackie, added a field option to specify other numbers of slides for those wanting to do shorter (or longer) than standard 20 slide pecha kucha.</li>
<li>7.13.2011 - [v 0.2] added the flickr safe search option for results to try and reduce the fear of random naked body parts appearing (no guarantees). Source code posted to google <a href="http://code.google.com/p/pechaflickr/">http://code.google.com/p/pechaflickr/</a></l>
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
<li>02.01.2016 - added option for "heather" to present random photos without revealing the tag, as a game to guess the common tag. It is named for a teacher who suggested the idea to me (see<a href="http://cogdogblog.com/2016/02/new-wave-pechaflickr/"> A New Wave for Pechaflickr</a>). To make this work, the tag passed in the URL is now encoded with a <code>rot13_str()</code> function.</li>


</ul> 

<h2>What Are You Reading This Stuff For?</h2>

<form id="pecha" method="post" action="index.php">
<input type="submit" id="play" value="Go Play" />
</form>


<?php include 'footer.php'?>
</body>
</html>
