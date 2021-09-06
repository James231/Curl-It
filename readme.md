# Curl It - HTTP (GET/POST) Request Testing Tool
Curl It allows you to test your Web APIs by sending HTTP GET/POST Requests.
* Easily change request headers
* Specify a maximum number of redirects
* Add POST parameters or raw body content

## Getting Started
You can find an online version at: https://curlit.jam-es.com  
Or you use the source code in the repository to host your own

### Installing
If you wish to host the source code yourself, you'll need a PHP hosting environment. If you do not have one available, you can use Google App Engine (https://cloud.google.com/appengine/) for free.  
I origionally wrote the code for PHP 5.6 but it may work on earlier/later versions without any changes. In the worst case you'll have to make a couple of small changes at most.

## Built With

* [MaterializeCSS Framework](https://materializecss.com/) - A great CSS framework, I highly recommend. I used version 1.0.0-rc.2. The index.php files links to the require CSS/Js files which are hosted on a CDN.
* [Ace Code Editor](https://ace.c9.io/) - High performance code editor for the web. It is used for displaying the HTTP Responses. You can find a buid in the 'src-min' folder

## Breakdown of files/folders
* readme.md - This readme markdown file
* app.yaml - Specifies how URL paths correspond to request handlers and static files when hosting with Google App Engine. If you are not using GAE you do not need it.
* php.ini - This allows the index.php to use cURL in the Google App Engine Environment. If you are not using GAE you do not need it.
* index.php - The webpage where all the fun happens :)
* src-min folder - Contains build of Ace Code Editor. It is used as a read-only editor for displaying the HTTP Responses.

## License

You may download/use/distribute/modify/host/sell the code however you like. There are no restrictions.

## Acknowledgements

Inspiration came from a free service previously called Hurl.it. Hurl.it is open source and you can find the source code here: [https://github.com/twilio/hurl2](https://github.com/twilio/hurl2) 
It was written in Ruby but is no longer being hosted anywhere online (which is why I made this).

Update: The roles have reversed now. After a sequence of acquisitions [Hurl.it](https://www.hurlit.com/) is back online. And I'm no longer maintaining this tool, nor attempting to keep the site up. 
