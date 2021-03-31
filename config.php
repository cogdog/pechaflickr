<?php
/*
pechaflickr

Pecha Flickr: pecha.php

by Alan Levine, cogdogblog@gmail.com
see it at http://pechaflickr.net/

This script generates the actual slide show using the jQuery Vegas plugin
http://vegas.jaysalvat.com/

Images are retrieved from flickr using phpflickr http://www.phpflickr.com/
*/ 


// ------- CONFIGURATION -------------------------------------------------------

// flickr api key. Get one at http://www.flickr.com/services/apps/create/apply/
define('FLICKRKEY','XXXXWONTWORKWITHOUTYOUROWNKEYXXXXX');

// Google Analytics, enter key of you have one https://analytics.google.com/
// something that looks like UA-XXXXXXXX-1
define('GOOGLEKEY', ''); 

// uncomment just for bug testing
//ini_set('error_reporting', E_ALL^ E_NOTICE);


error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

?>