# Wordpress for LaravelPHP #

This package allows you to fetch data from any Wordpress installation via a RESTful API.  It requires that the Wordpress installation include the [JSON API plugin](http://wordpress.org/extend/plugins/json-api/).

## Install ##

In ``application/bundles.php`` add:

```php
'wordpress' => array('auto' => true),
```

Copy the sample config file to ``application/config/wordpress.php`` and input the proper information.

### Multi-Site Functionality ###

For multi-site functionality you have to modify the Wordpress JSON API plugin.  In ``json-api.php`` add the following after the includes:

```php
// add multisite option
if (isset($_GET['site_id']))
{
	switch_to_blog($_GET['site_id']);
}
```

## Usage ##

Use any API method and pass params as a single array:

```php
// get recent posts
$posts = Wordpress::get_recent_posts(array('count'=>10, 'page'=>1));
```

See the [API docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a full list of methods.

## Recommendations ##

I recommend caching your API responses to prevent problems.