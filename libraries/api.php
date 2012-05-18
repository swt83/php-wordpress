<?php

/**
 * A LaravelPHP package for working w/ Wordpress.
 *
 * @package    Wordpress
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-wordpress
 * @license    MIT License
 */

namespace Wordpress;

class API
{
	public static function __callStatic($method, $args)
	{
		// load url
		$url = \Config::get('wordpress.url');
		
		// add query
		$url .= '?json='.$method;
		if (!empty($args))
		{
			foreach($args[0] as $key=>$value)
			{
				$url .= '&'.$key.'='.urlencode($value);
			}
		}
		
		// connect to api
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		
		// catch errors
		if (curl_errno($ch))
		{
			#$errors = curl_error($ch);
			curl_close($ch);

			// fail
			return false;
		}
		else
		{
			curl_close($ch);

			// filter response
			$start = strpos($response, '{');
			$stop = strrpos($response, '}');
			$response = substr($response, $start, $stop - $start + 1);
			
			// return
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
}