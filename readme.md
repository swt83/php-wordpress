# Wordpress for LaravelPHP #

This package allows you to fetch data from any Wordpress installation via a RESTful API.  It requires that the Wordpress installation include the [JSON API plugin](http://wordpress.org/extend/plugins/json-api/).

## Install ##

In ``application/bundles.php`` add:

```php
'wordpress' => array('auto' => true),
```

### Configuration ###

Copy the sample config file to ``application/config/wordpress.php`` and input the proper information.

## Usage ##

Use any API method and pass params as a single array.  Here are some common API requests you might make:

```php
// get a page
$page = Wordpress::get_page(array(
	'post_type' => 'page',
	'slug' => 'about',
));

// get a post
$post = Wordpress::get_post(array(
	'post_type' => 'post',
	'id' => 100,
));

// get recent posts
$posts = Wordpress::get_recent_posts(array(
	'post_type' => 'post',
	'count' => 10,
	'page' => 1,
));
```

See the [API docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a full list of available methods.

## Notes ##

The ``Wordpress`` class is built on top of the ``Wordpress\API`` class, and simply adds some caching and filtering features (as specified in your config file).  For straightup API calls and nothing else, use ``Wordpress\API``.

### Edit Mode ###

Caching results can cause frustration for users trying to see the immedate effect of their content changes.  To help with this issue, a user can enter and exit "edit mode" by pointing their browser to ``http://<DOMAIN>/wordpress`` and clicking the appropriate option.  Edit mode is governed by a simple ``Session::put('wordpress_edit_mode', true);`` variable, and thus is user specific.