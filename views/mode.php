<?php

// build html
echo '<html>';
echo '<head><title>Wordpress Edit Mode</title></head>';
echo '<body>';
echo '<pre>';
if (Session::get('wordpress_edit_mode'))
{
    echo 'Wordpress "edit mode" is <strong style="background:#00CC00;padding:3px;color:#fff;">ON</strong>. ';
    echo '<a href="'.URL::to('wordpress/mode/off').'" style="color:#aaa;">Click here to turn it off.</a>';
}
else
{
    echo 'Wordpress "edit mode" is <strong style="background:#CC0000;padding:3px;color:#fff;">OFF</strong>. ';
    echo '<a href="'.URL::to('wordpress/mode/on').'" style="color:#aaa;">Click here to turn it on.</a>';
}
echo '</pre>';
echo '</body>';
echo '</html>';