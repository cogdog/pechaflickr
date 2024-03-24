# pechaflickr
by Alan Levine http://cog.dog/ or http://cogdogblog.com/

The fun improv game that mashes up pecha kucha, powerpoint karaoke with random photos from flickr-- seen at https://pechaflickr.net/

-----
*If this kind of stuff has any value to you, please consider supporting me so I can do more!*

[![Support me on Patreon](http://cogdog.github.io/images/badge-patreon.png)](https://patreon.com/cogdog) [![Support me on via PayPal](http://cogdog.github.io/images/badge-paypal.png)](https://paypal.me/cogdog)

----- 

![](images/pecha-flickr.jpg "pechaflickr")

## What the heck is pechaflickr?

Huh? Give pechaflickr a tag to search for flickr photos, how many you want, how long you want each slide on the screen, and see what kind of improv you and your friends can do.

And try the new *Heather mode* -- Inspired by the suggestion of a grade 6 teacher, in this mode the tag is not displayed, and the challenge is to guess the tag from the pictures you get. Or try the option to draw only from images in the [Flickr Commons](https://www.flickr.com/commons).


## Requirements for Running Your Own Pechaflickr

If for some reason you want to host your own Pechaflickr, you will need a web server or a local running server, PHP 7.4 (working on an 8.0 version) and to get [a flickr API key](https://www.flickr.com/services/api/misc.api_keys.html). Do I really need to say you need the internet?

## Setting Up

1. Copy all files to your web server in directory of your choice. 
2. Get a flickr api key http://www.flickr.com/services/apps/create/apply/
3. Edit config.php to enter the string for the API key (and asll you can add a Google Analytics code if that's your thing)
4. Play and have fun

## Ch-ch-ch-changes
This was made first in 2011, and I have been sloppy at tracking updates. Time to make up for that!

* May 2011: First blogged https://cogdogblog.com/2011/05/pechaflickr/
* Jul 2011: first release on Google Code https://code.google.com/archive/p/pechaflickr/
* Mar 2014: Photo credits screen added https://cogdogblog.com/2014/03/pechaflickr-super-powers/
* Apr 2014: Moved to a domain of it's own http://pechaflickr.net/ 
* Aug 2015: Slide show moved to vegas https://cogdogblog.com/2015/08/new-pechaflickr/
* Feb 2016: heather mode added https://cogdogblog.com/2016/02/new-wave-pechaflickr/
* Dec 2018 German version announced https://cogdogblog.com/2018/12/improvisieren-mit-zufalligen-fotos/
* Mar 2021: Config option added for Google Analytics, and option added for limiting to Flickr Commons https://cogdogblog.com/2021/03/pechaflickrcommons/
* Mar 2023 Removed features to share to Twitter because, well its dead to me, Replaced with Share to Mastodon and a front page widget to show all [Mastodon posts tagged pechaflickr](https://mastodon.social/tags/pechaflickr).

## Credit for Code Bits
I am more a patcher together of bits of code. Pechaflickr would not be possible without

* Sam Coulter's [phpFlickr](https://github.com/dan-coulter/phpflickr) wrapper for the flickr API. Yes, this is old, and does not work in PHP 8 (this will require me to integrate Sam Wilson's [phpFlickr](https://github.com/samwilson/phpflickr))
* Jay Salvat's [Vegas slideshow Javascript library](http://vegas.jaysalvat.com/)
* idotj's [Mastodon embed timeline](https://gitlab.com/idotj/mastodon-embed-timeline)
* codepo8's  [Share on Mastodon Button](https://github.com/codepo8/mastodon-share)

## Going Worldwide

Other versions of pechaflickr:

* http://pechaflickr.de German version by [Nele Hirsch](https://ebildungslabor.de/)

## Tell Me
If you have used pechaflickr in any way, I'm interested in knowing about it!  Leave me some feedback at http://bit.ly/pechaflickr-survey




