<?php

/* Pecha Flickr function library

by Alan Levine, cogdogblog@gmail.com

*/



/* ----------- GET_FROM_FLICKR ---------------------------------
Use flickr API get a batch of images for a given tag.
-------------- GET_FROM_FLICKR --------------------------------- */

function get_from_flickr($tag, $cnt=100) {

	require_once("phpFlickr.php");
	$f = new phpFlickr(FLICKRKEY);
	
	// to add a bit more randomness, we can use 1 of 6 sorts for flickr photo fetches
	$sortof = array('date-posted-asc', 'date-posted-desc', 'date-taken-asc', 'date-taken-desc', 'interestingness-desc', 'interestingness-asc');
	
	
	// get $cnt flickr photos for search on the tag, apply the flickr safe search filters
	//     so we don't get any offending body parts in the batch	
	$found = $f->photos_search(array("tags"=>$tag, "sort" => $sortof[rand(0,6)],  "per_page" => $cnt, "safe_search" => 1, "extras" => 'url_z'));
	
	return($found['photo'] );

}

/* ----------- LOAD_PECHA ---------------------------------
Use flickr API get a batch of images for a given tag; we want more
than we will need, so grab 400 total and return a random selection of
the number specified by $n
-------------- LOAD_PECHA --------------------------------- */


function load_pecha($tag, $n, $unique_owner=true, $size='z') {

	// get 400 photos for tag
	$pile = get_from_flickr($tag, 400);
	
	// error condition if we do not have sufficient photos; estimated
	//   as 4 times the number requested
	if (count($pile) < 4 * $n) return (-1);
	
	// shuffle the photos like a deft card dealer
	shuffle($pile);
	
	// set up holder for the photo info 
	//   we want the link to the static z size image, the images height
	//   (for scaling), and the owner id
	
	$photos = array(
		'link' => array(), 
		'height' => array(), 
		'owner' => array(),
		'url' => array(),
		'icon' => array()
		);
						
	// Generate the URLs and heights for the static version of each photo
	// We will just walk the array til we get enough photos_search
	
	if ($unique_owner) {
	
		// make sure each photo is from different creator
		for ($indx = 0; $indx < count($pile); $indx++) {
			
			// check that photos are landscape orientation
			//   and that we do not have more than one photo by the same owner
			if ($pile[$indx]['width_z'] > $pile[$indx]['height_z'] and  !in_array($pile[$indx]['owner'],$photos['owner'] ) ) {
				
				// save the image info in an array we can send back
				$photos['link'][] = $pile[$indx]['url_z'];
				$photos['height'][] = $pile[$indx]['height_z'];
				$photos['width'][] = $pile[$indx]['width_z'];	
				$photos['owner'][] = $pile[$indx]['owner'];	
				$photos['url'][] = 'http://www.flickr.com/photos/' . $pile[$indx]['owner'] . '/' . $pile[$indx]['id'];	
				$photos['icon'][] = 'http://farm' . $pile[$indx]['farm'] . '.staticflickr.com/' . $pile[$indx]['server'] . '/' . $pile[$indx]['id'] . '_' . $pile[$indx]['secret'] . '_t.jpg';
				
				// exit when we have enough photos
				if ( count($photos['link']) == $n ) return ($photos);
			}
		}
		
	} else {
		// okay for photos from same owner
		for ($indx = 0; $indx < count($pile); $indx++) {
			
			// check that photos are landscape orientation
			//   and that we do not have more than one photo by the same owner
			if ($pile[$indx]['width_z'] > $pile[$indx]['height_z']) {
				
				// save the image info in an array we can send back
				$photos['link'][] = $pile[$indx]['url_z'];
				$photos['height'][] = $pile[$indx]['height_z'];
				$photos['width'][] = $pile[$indx]['width_z'];	
				$photos['owner'][] = $pile[$indx]['owner'];	
				$photos['url'][] = 'http://www.flickr.com/photos/' . $pile[$indx]['owner'] . '/' . $pile[$indx]['id'];
				$photos['icon'][] = 'http://farm' . $pile[$indx]['farm'] . '.staticflickr.com/' . $pile[$indx]['server'] . '/' . $pile[$indx]['id'] . '_' . $pile[$indx]['secret'] . '_t.jpg';
				
					
				// exit when we have enough photos
				if ( count($photos['link']) == $n ) return ($photos);
			}
		}
	}	
	
	// uh if we ended up here we did not get enough photos, return error code
	return (-1);

}
?>