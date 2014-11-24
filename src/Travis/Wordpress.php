<?php

namespace Travis;

class Wordpress {

    /**
     * Magic method for API calls.
     *
     * @param   string  $method
     * @param   array   $args
     * @return  object
     */
    public static function __callStatic($method, $args)
    {
        // capture args
        $args = isset($args[0]) ? $args[0] : array();

        // set endpoint
        $url = $args['url'];
        unset($args['url']);

        // build query
        $url .= '?json='.$method;
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