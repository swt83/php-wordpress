<?php

/**
 * A LaravelPHP package for working w/ Wordpress.
 *
 * @package    Wordpress
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-wordpress
 * @license    MIT License
 */

class Wordpress
{
	public static function __callStatic($method, $args)
	{
		// load config
		extract(Config::get('wordpress'));
	
		// build url
		$api_endpoint .= '?json='.$method;
		if (!empty($args))
		{
			foreach($args[0] as $key=>$value)
			{
				$api_endpoint .= '&'.$key.'='.urlencode($value);
			}
		}
		
		// add multisite option
		if ($api_site_id !== null) $api_endpoint .= '&site_id='.urlencode($api_site_id);
		
		// connect to api
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		// filter response (to prevent weird random characters from breaking)
		$start = strpos($response, '{');
		$stop = strrpos($response, '}');
		$response = substr($response, $start, $stop - $start + 1);
		
		// return response
		$result = @json_decode($response);
		if ($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}
}