# Wordpress for Laravel

This package allows you to fetch data from a Wordpress installation via a RESTful API.  It requires that the Wordpress installation include the [JSON API](http://wordpress.org/extend/plugins/json-api/) plugin.

## Install

In ``application/bundles.php`` add:

```php
'wordpress' => array('auto' => true),
```

### Configuration

Copy the sample config file to ``application/config/wordpress.php`` and input the proper information.

## Usage

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

See the [docs](http://wordpress.org/extend/plugins/json-api/other_notes/) for a full list of available methods.

## Filtering

The package includes a simple filtering method to use as you will, such as patching URLS for media queries:

```php
$content = Wordpress::filter($content);
```

The filtering rules are specified in the config file.

## Caching & Edit Mode

The package caches requests as specified in the config file.  You can optionally enter "edit mode", which turns off caching, by pointing your browser to ``http://<DOMAIN>/wordpress`` and clicking the appropriate option.  Edit mode is governed by a session variable and thus is user specific.

## Notes

- June 24, 2013 - Made updates to the package, which I felt was trying to do too much.  Cleaned up ``Wordpress`` code.  Removed ``API`` class entirely as unnecessary.  Removed json tinkering as recent updates to JSON API plugin to Wordpress resolved those issues.