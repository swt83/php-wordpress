# Wordpress for LaravelPHP #

This package allows us to interface with any Wordpress installation via a RESTful API.  It requires the [JSON API plugin](http://wordpress.org/extend/plugins/json-api/).  We can build websites w/ Laravel while serving content from a remote Wordpress installation.

## Installation ##

Amend the bundles.php config file:

```php
'wordpress' => array(
    'autoloads' => array(
        'map' => array(
            'WP' => '(:bundle)/wp.php',
        ),
    ),
),
```

Copy the ``config/wp-sample.php`` file and rename it to ``config/wp.php``.  Input the proper information:

```php
'url' => 'http://mydomain.com/',
'site_id' => null,
```

## Usage ##

Use any method from the API, and pass optional params as a single array:

```php
// get recent posts
$posts = WP::get_recent_posts(array('count'=>10, 'page'=>1));
```

See the [API docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a full list of allowable methods and associated params.

## Limitations ##

For handling multisite installs, my understanding is that a custom change has to be made to the plugin itself.  I will post that information in this readme in the near future.