=== RainyShots ===
Contributors: rainypixels
Donate link: http://rainypixels.com/writings/journal/rainyshots-a-dribbble-plugin/
Tags: dribble, template tag, designer, developer, social media
Requires at least: 2.9
Tested up to: 3.1
Stable tag: 1.0
License: GPLv2 or later

Adds a template function — rs_shots() — that returns an array of the 15 latest Dribbble shots by a player.

== Description ==

This plugin adds a function `rs_shots()` to Wordpress that returns an array of the 15 latest Dribbble shots by a player. The return type of the function is [JSON in appropriate PHP type](http://php.net/manual/en/function.json-decode.php). 

The plugin adds an admin screen under Settings > RainyShots that provides a few options such as specifying a player and caching preferences. 

**Features**

* Specify the player 
* Returned shots variable is cached for a day by default; this cache duration may be updated in admin settings
* You can manually reset the cache through the admin at any time. This is useful if you post a shot and want it to immediately show up in your template. 

Read more about it on [my blog](http://rainypixels.com/writings/journal/rainyshots-a-dribbble-plugin/).


== Installation ==

1. Upload the rainyshots folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set the player under Settings > RainyShots before you use the tag; optionally, update the caching preferences.


== Screenshots ==

1. screenshot-1.gif

== Frequently Asked Questions ==

= Does the ws_shots() function output any html or css? =

Nope. It returns the [json with values encoded as PHP types](http://php.net/manual/en/function.json-decode.php). You can loop through the object as follows: 

`$shots = rs_shots();

foreach ($shots as $shot)
{
    echo "<img src='" . $shot->{"image_teaser_url"} . "' alt='" . $shot->{"title"} . "' />";
}
`

= May I access only "image_teaser_url" or are any other shot properties accessible? =

You may access all the properties available in the response to [this API call](http://dribbble.com/api#get_player_shots). All the plugin does is return the json_decoded result of the API call along with caching benefits. 

== Changelog ==

= 1.0 =
* Iz in ur v1