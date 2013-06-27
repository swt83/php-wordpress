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

    /**
     * Magic method for API calls.
     *
     * @param   string  $method
     * @param   array   $args
     * @return  object
     */
    public static function __callStatic($method, $args)
    {
        // load url
        $url = \Config::get('wordpress.url');

        // catch error
        if (!$url)
        {
            trigger_error('Wordpress configuration file not found.');
        }
        
        // add query
        $url .= '?json='.$method;
        if (!empty($args))
        {
            foreach($args[0] as $key=>$value)
            {
                $url .= '&'.$key.'='.urlencode($value);
            }
        }

        // if caching...
        if (Config::get('wordpress.cache'))
        {
            // check cache
            $hash = 'wp_'.md5($url);
            $check = Cache::get($hash);
            if ($check and !Session::get('wordpress_edit_mode'))
            {
                return $check;
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
            $result = false;
        }
        else
        {
            curl_close($ch);

            // return
            $result = json_decode($response);
        }

        // if caching...
        if (Config::get('wordpress.cache'))
        {
            // cache result
            Cache::put($hash, $result, Config::get('wordpress.cache'));
        }

        // return
        return $result;
    }

    /**
     * Filter string according to configuration definitions.
     *
     * @param   string  $string
     * @return  string
     */
    public static function filter($string)
    {
        // build find/replace arrays
        $find = array();
        $replace = array();
        $filters = Config::get('wordpress.filter');
        foreach ($filters as $key => $value)
        {
            $find[] = $key;
            $replace[] = $value;
        }

        // return filtered string
        return str_ireplace($find, $replace, $string);
    }

}