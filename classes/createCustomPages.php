<?php

global $wpdb;

if (null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'nft-shop'")) {
	
	$nz_shop_page = array(
	    'post_title'    => 'Nft Shop',
	    'post_status'   => 'publish',
	    'post_author'   => 1,
	    'post_name'   => 'nft-shop',
	    'post_type' => 'page',
	);

	$post_id = wp_insert_post( $nz_shop_page );

	add_post_meta($post_id, '_wp_page_template', 'templates/custom-wc-shop.php');
}


if (null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'nft-details'")) {
	
	$nz_shop_page = array(
	    'post_title'    => 'Nft Details',
	    'post_status'   => 'publish',
	    'post_author'   => 1,
	    'post_name'   => 'nft-details',
	    'post_type' => 'page',
	);

	$post_id = wp_insert_post( $nz_shop_page );

	add_post_meta($post_id, '_wp_page_template', 'templates/custom-wc-nft-details.php');
}

