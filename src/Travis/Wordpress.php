<?php

namespace Travis;

class Wordpress {

    /**
     * Magic method for API calls.
     *
     * @param   string  $url
     * @param   string  $controller
     * @param   string  $method
     * @param   array   $args
     * @return  object
     */
    public static function run($url, $controller, $method, $args = [])
    {
        // build query
        $url .= '?json='.$controller.'/'.$method;
        if (!empty($args))
        {
            foreach($args as $key => $value)
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

        // catch errors...
        if (curl_errno($ch))
        {
            #$errors = curl_error($ch);

            $result = false;
        }
        else
        {
            $result = json_decode($response);
        }

        // close
        curl_close($ch);

        // return
        return $result;
    }

}