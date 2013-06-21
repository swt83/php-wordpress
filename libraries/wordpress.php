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
	private static $filter = array();

	/**
	 * Magic method for API calls, with filtering and caching.
	 */
	public static function __callStatic($method, $args)
	{
		// build hash for request
		$hash = 'wordpress_'.md5($method.serialize($args));

		// check cache
		$result = Cache::get($hash);

		// if in edit mode...
		if (Session::get('wordpress_edit_mode'))
		{
			// force null
			$result = null;
		}

		// if null...
		if (!$result)
		{
			// request
			$result = call_user_func_array(array('Wordpress\\API', $method), $args);

			// catch
			if ($result)
			{
				// if success...
				if ($result->status !== 'error')
				{
					// prep filter
					foreach (Config::get('wordpress.filter') as $key => $value)
					{
						self::$filter['find'][] = $key;
						self::$filter['replace'][] = $value;
					}

					// recusively filter
					$result = self::filter($result);

					// cache
					Cache::put($hash, $result, Config::get('wordpress.cache.'.$method, 0));
				}
				else
				{
					// fail
					self::error();
				}
			}
			else
			{
				// fail
				self::error();
			}

		}

		return $result;
	}

	/**
	 * Recursive method for filtering content.
	 *
	 * @param	object	$object
	 */
	private static function filter($object)
	{
		if (is_object($object))
		{
			foreach ($object as $key => $value)
			{
				$object->$key = self::filter($value);
			}

			// check for page or post, then add description and keywords
			if (isset($object->page))
			{
				$object->page->keywords = self::tags2keywords($object->page->tags);
				$object->page->description = self::excerpt2description($object->page->excerpt);
			}
			elseif (isset($object->post))
			{
				$object->post->keywords = self::tags2keywords($object->post->tags);
				$object->post->description = self::excerpt2description($object->post->excerpt);
			}
		}
		elseif (is_array($object))
		{
			foreach ($object as $key => $value)
			{
				$object[$key] = self::filter($value);
			}
		}
		else
		{
			return str_ireplace(self::$filter['find'], self::$filter['replace'], $object);
		}

		return $object;
	}

	/**
	 * Helper function to convert array of tags into a keyword string.
	 *
	 * @param	array	@array
	 */
	public static function tags2keywords($list)
	{
		// build
		$keywords = '';
		foreach ($list as $value)
		{
			$keywords .= $value->title.',';
		}

		// return
		return $keywords;
	}

	/**
	 * Helper function to convert an excerpt into a description string.
	 *
	 * @param	string	$string
	 */
	public static function excerpt2description($string)
	{
		return strip_tags($string);
	}

	/**
	 * Helper function to make uniform error notices.
	 */
	private static function error()
	{
		if (\Config::get('wordpress.show_errors') == TRUE)
		{
			trigger_error('Failed to get data from Wordpress.');
			return;
		}

		return FALSE;
	}
}