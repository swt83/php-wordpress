# Wordpress

A PHP library for working w/ the [Wordpress API plugin](https://wordpress.org/plugins/json-api/).

## Install

Normal install via Composer.

## Usage

Call any API method and pass params as a single array:

```php
use Travis\Wordpress;

// get a page
$page = Wordpress::get_page(array(
	'url' => 'http://yourwordpress.com/',
    'post_type' => 'page',
    'slug' => 'about',
));

// get a post
$post = Wordpress::get_post(array(
	'url' => 'http://yourwordpress.com/',
    'post_type' => 'post',
    'id' => 100,
));

// get recent posts
$posts = Wordpress::get_recent_posts(array(
	'url' => 'http://yourwordpress.com/',
    'post_type' => 'post',
    'count' => 10,
    'page' => 1,
));
```

You will need to include a ``url`` value in the payload that points to the address of your Wordpress installation. Be sure this address has an ending slash or you'll experience problems.

See the [documentation](https://wordpress.org/plugins/json-api/other_notes/) for a full list of available methods.

## Notes

I know there is newer API out there, found [here](http://wp-api.org), but I can't get it working properly.