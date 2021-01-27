# Wordpress

A PHP library for working w/ the [Wordpress API plugin](https://wordpress.org/plugins/json-api/).

## Install

Normal install via Composer.

### Disable the Public Side of Wordpress

Since you are using the API, you should disable the public side of your Wordpress installation. One way to do that is to open the ``index.php`` file in your Wordpress directory and add this code to the top:

```php
if (!isset($_GET['json'])) die();
```

## Usage

Send a request by passing an endpoint, controller, method, and params:

```php
use Travis\Wordpress;

// set endpoint
$endpoint = 'http://yourwordpress.com/'; // ending slash is important

// get a page
$page = Wordpress::run($endpoint, 'core', 'get_page', [
    'post_type' => 'page',
    'slug' => 'about',
));

// get a post
$post = Wordpress::run($endpoint, 'core', 'get_post', [
    'post_type' => 'post',
    'id' => 100,
));

// get recent posts
$posts = Wordpress::run($endpoint, 'core', 'get_recent_posts', [
    'post_type' => 'post',
    'count' => 10,
    'page' => 1,
));
```

See the [documentation](https://github.com/dphiffer/wp-json-api) for a full list of available methods.
