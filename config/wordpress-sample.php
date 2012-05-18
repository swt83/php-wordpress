<?php

return array(
	
	/**
	 * URL
	 * ----
	 * Set the location of your Wordpress installation.  Be sure
	 * to include a trailing slash at the end, which for some 
	 * reason is necessary.
	 */
	'url' => 'http://www.foobar.com/',
	
	/**
	 * CACHE
	 * ------
	 * Set how long API requests should be cached.  This prevents
	 * slow pageloads and excessive stress on the API server.
	 * Method names NOT found below will NOT be cached.
	 */
	'cache' => array(
		'get_page' => 10,
		'get_post' => 10,
		'get_recent_posts' => 10,
	),
	
	/**
	 * FILTER
	 * -------
	 * Run all content thru a simple find and replace filter.
	 * This is especially useful for working w/ CDN plugins.
	 */
	'filter' => array(
		'http://www.foobar.com/' => 'https://foobar.s3.amazonaws.com/',
		#'find' => 'replace',
		#'find' => 'replace',
		#'find' => 'replace',
		#...
	),
	
);