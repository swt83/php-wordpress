# Wordpress for LaravelPHP #

This package allows you to interface with any Wordpress installation via a RESTful API.  You will need to install the [JSON API plugin](http://wordpress.org/extend/plugins/json-api/).  This allows us to build websites w/ Laravel while serving content from a remote Wordpress installation.

## Installation ##

Amend your bundles.php config file:

```php
'wordpress' => array(
    'autoloads' => array(
        'map' => array(
            'WP' => '(:bundle)/wp.php',
        ),
    ),
),
```

## Usage ##

Use any method from the API, and pass optional params as a single array.

```php
// get recent posts
$params = array(
	'count' => 10,
	'page' => 2,
);
$posts = WP::get_recent_posts($params);
```

See the [API docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a list of allowable methods and associated params.