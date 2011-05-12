<?php
/*
Plugin Name: RainyShots
Plugin URI: http://rainypixels.com/writings/journal/rainyshots-a-dribbble-plugin/
Description: Adds a template function — rs_shots() — that returns an array of 15 latest Dribbble shots by a player.
Version: 1.0
Author: Nishant Kothary
Author URI: http://rainypixels.com
License: GPLv2 or later
*/
?>
<?php
/*
 * Wordpress template tag that gets the shots recent shots
 */
function rs_shots ()
{
	// object we'll return 
	$shots = null;
	// dribbble api
	$rsAPIUrl = 'http://api.dribbble.com';
	// get user-defined player alias from the RainyShots admin
	$player = get_option ('rsAdmin_Player');
	// get user-defined cache duration from RainyShots admin
	$dur = get_option ('rsAdmin_CacheDur');
	// false unless you know what you're doing
	$rsProxyStatus = false; 
	// you'll know what to set this to if you know what you're doing :)
	$rsProxy = "http://itgproxy.redmond.corp.microsoft.com:80";

	// load shots from cache
	if (false === ($shots = get_transient('cached_dribbble_shots')) ) 
	{
		// if player has been defined by user, get shots and store in cache
		if ($player != "") 
		{
			//echo 'No cache. Loading from cloud.' . '<br /';
			$requesturl = "/players/" . $player . "/shots";
			$response = rsFetchUrl (($rsAPIUrl . $requesturl), $rsProxyStatus, $rsProxy);
			$json = json_decode($response);
			$shots = $json->{"shots"};
			set_transient('cached_dribbble_shots', $shots, $dur);
		}
		// interception
		else 
		{
			echo "You need to set a player in Settings > RainyShots > General Options<br />";
			return;
		}
	}
	
	// foul
	if ($shots == "")
		echo "Something went wrong. Maybe you have the wrong player alias?<br />";

	// dunk
	return $shots;
}

/* 
 * Helper function. Basically, curl through php
 */
function rsFetchUrl ($url, $proxystatus, $proxy) 
{	
	if (function_exists('curl_init')) 
	{
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		if ($proxystatus) curl_setopt($c, CURLOPT_PROXY, $proxy);		
		$result = curl_exec($c);
		curl_close($c);
		return $result;
	} 
	else 
	{
		return file_get_contents($url);
	}
}

/*
 * Register admin interface for plugin in Settings > RainyShots
 */
function rsAdminInit ()
{
	add_options_page("RainyShots Settings", "RainyShots", 1, "rainyshots", "rsAdmin");
}

/*
 * Builds the settings page UI
 */
function rsAdmin ()
{
	include('rainyshotsadmin.php');
}

// Initialize the admin menu via an action hook
add_action ('admin_menu', 'rsAdminInit');  
?>