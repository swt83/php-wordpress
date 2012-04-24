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
		$url .= '?json='.$method;
		if (!empty($args))
		{
			foreach($args[0] as $key=>$value)
			{
				$url .= '&'.$key.'='.urlencode($value);
			}
		}
		
		// add multisite option
		if ($site_id !== null) $url .= '&site_id='.urlencode($site_id);
		
		// connect to api
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
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