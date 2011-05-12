<?php
/*
Description: This template constructs and handles the page for RainyShots settings in the Wordpress Admin.
Version: 1.0
*/
?>
<!-- If options form has been submitted, extract POST data and store -->
<?php  
    if($_POST['rsAdmin_hidden'] == 'Y') 
	{
		// get post variables and save in WP db
		$rsPlayer = $_POST['rsAdmin_Player'];  
		update_option('rsAdmin_Player', $rsPlayer);  
		$rsCacheDur = $_POST['rsAdmin_CacheDur'];  
		update_option('rsAdmin_CacheDur', $rsCacheDur);  
		
		// user-generated update implies that the user wants to wipe cache
		delete_transient ('cached_dribbble_shots');
?>

<!-- Show a message that the options have been updated -->
<div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>	

<!-- If reset cache button is submitted, reset the cache -->		
<?php  
	} 
	elseif ($_POST['rsAdminCache_hidden'] == 'Y')
	{
		// flush the cache
		delete_transient ('cached_dribbble_shots');
?>
	
<!-- Show a message that the cache has been wiped -->	
<div class="updated"><p><strong><?php _e('The cache has been cleared.'); ?></strong></p></div>

<!-- Else get stored options, if any so they can be loaded as default form values -->
<?php 		
	}

	$rsPlayer = get_option ('rsAdmin_Player');
	$rsCacheDur = get_option ('rsAdmin_CacheDur');
?>

<!-- UI for Admin settings-->
<div class="wrap">
	<h2>RainyShots Plugin Settings</h2>
	<h3>Usage</h3>
	<p>RainyShots adds a template tag — <code>rs_shots()</code> — that returns an array of the recent 15 shots so you can do stuff like this within your templates — </p>
	<blockquote>
		<code>
			$shots = rs_shots();<br />
			<br />
			foreach ($shots as $shot)<br />
			{<br />
			&nbsp;&nbsp;&nbsp;&nbsp;echo &quot;&lt;img src='" . $shot->{&quot;image_teaser_url&quot;} . &quot;' alt='" . $shot->{&quot;title&quot;} . &quot;' /&gt;&quot;;<br />
			}<br />
		</code>
	</blockquote> 
	<p>You can access other properties of each shot in the loop by replacing <code>image_teaser_url</code> with any of the available attributes returned in the JSON as specified by the corresponding <a href="http://dribbble.com/api#get_player_shots">Dribbble API call</a>.</p>
	
	<h3>General Options</h3>
	
	<form name="rsAdmin_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="rsAdmin_hidden" value="Y">
		
		<p><?php _e("ID of Dribbble player*: " ); ?><input type="text" name="rsAdmin_Player" value="<?php echo $rsPlayer; ?>" size="10"><em><?php _e(" ex: rainypixels" ); ?></em></p>
		
		<p><?php _e("Cache Duration (secs): " ); ?><input type="text" name="rsAdmin_CacheDur" value="<?php if ($rsCacheDur != "") echo $rsCacheDur; else echo '86400'; ?>" size="10"><em><?php _e(" ex: 1hr = 3600, 1day = 86400 (default)" ); ?></em></p>
		
		<p class="submit">  
			<input type="submit" name="Submit" value="<?php _e('Update Options', 'rsAdmin_trdom' ) ?>" />  
		</p>
	</form>
	
	<h3>Flush Cache</h3>
	<p>If you'd like to flush the cache, <em>i.e. reset it immediately</em>, click this button —	
	<form name="rsAdmin_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="rsAdminCache_hidden" value="Y">
		<span class="submit"><input type="submit" name="Submit" value="<?php _e('Reset Cache', 'rsAdmin_trdom' ) ?>" /> </span> 
	</form>
	</p>
	
</div>