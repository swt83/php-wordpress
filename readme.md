# Wordpress for LaravelPHP #

This package allows you to interface with any Wordpress installation via a RESTful API.  It requires the [JSON API plugin](http://wordpress.org/extend/plugins/json-api/).  You can build websites w/ Laravel while serving content from a remote Wordpress installation.

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

For multisite functionality, you have to modify the Wordpress plugin itself.  In the ``json-api.php`` file add the following after the includes:

```php
// add multisite option
if (isset($_GET['site_id']))
{
	switch_to_blog($_GET['site_id']);
}
```

## Usage ##

Use any method from the API, and pass optional params as a single array:

```php
// get recent posts
$posts = WP::get_recent_posts(array('count'=>10, 'page'=>1));
```

See the [API docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a full list of allowable methods and associated params.