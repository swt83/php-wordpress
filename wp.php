<?php

/**
 * A LaravelPHP package for working w/ the Wordpress API.
 *
 * @package    Wordpress
 * @version    1.0
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-wp
 * @license    MIT License
 */

class WP
{
	/**
	 * Magic method to execute all methods for JSON API.
	 */
	public static function __callStatic($method, $args)
	{
		// load config
		extract(Config::get('wordpress::wp'));
	
		// build url
		$url .= '?json='.$method.'&';
		if (!empty($args))
		{
			foreach($args[0] as $key=>$value)
			{
				$url .= $key.'='.urlencode($value).'&';
			}
		}
		$url = rtrim($url, '&');
		
		// connect to api
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		// return response
		$result = @json_decode($response);
		if ($result !== false and $result !== null)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}
}