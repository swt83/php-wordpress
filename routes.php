<?php

Route::get('wordpress', function() {

	// build html
	echo '<html>';
	echo '<head><title>WP Edit Mode</title></head>';
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
	
});

Route::get('wordpress/mode/on', function() {

	// enable
	Session::put('wordpress_edit_mode', true);
	
	// redirect
	return Redirect::to('wordpress');

});

Route::get('wordpress/mode/off', function() {

	// disable
	Session::forget('wordpress_edit_mode');
	
	// redirect
	return Redirect::to('wordpress');

});