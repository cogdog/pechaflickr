<?php

if ($commonsbox) {
	$bg_image = 'commons' . random_int(1, 5) . '.jpg';
} elseif ($hbox) {
	$bg_image = 'heather' . random_int(1, 5) . '.jpg';
} elseif ($tag == 'dog') {
	$bg_image = 'pechaflickr-og.jpg';
} else {
	$bg_image = 'splash' . random_int(1, 5) . '.jpg';	
}


?>


	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">	
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Pechaflickr" />
	<meta property="og:description" content="Can you improv a coherent presentation from images you have never seen? Pechaflickr is a mashup of pechakucha and powerpoint karaoke." />
	<meta property="og:url" content="https://pechaflickr.net" />
	<meta property="og:site_name" content="Pechaflickr" />
	<meta property="og:image" content="https://pechaflickr.net/images/<?php echo $bg_image?>"
	<meta property="og:locale" content="en_US" />
	<meta name="twitter:creator" content="@cogdog" />
	
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@cogdog">
	<meta name="twitter:title" content="Pechaflickr">
	<meta name="twitter:description" content="Can you improv a coherent presentation from images you have never seen? Pechaflickr is a mashup of pechakucha and powerpoint karaoke.">	
