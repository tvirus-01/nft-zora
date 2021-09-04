<?php
/** 
 * Trigger this file on uninstall
*/

if (! defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

global $wpdb;
$prefix = $wpdb->prefix
$wpdb->query("DELECT FROM {$prefix}postmeta WHERE post_id IN (SELECT ID FROM {$prefix}posts WHERE post_type = 'nft') ")
$wpdb->query("DELETE FROM {$prefix}posts WHERE post_type = 'nft'; ")