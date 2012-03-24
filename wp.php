<?php

class WP
{
	/**
	 * Magic method to execute all methods from JSON API.
	 */
	public static function __callStatic($method, $args)
	{
		return self::curl($method, $args);
	}
	
	/**
	 * Curl method to execute queries.
	 */
	protected static function curl($method, $args)
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
		
		//open connection
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