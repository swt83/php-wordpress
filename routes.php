<?php

Route::get('wordpress', function() {

    // return view
    return View::make('wordpress::mode');
    
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