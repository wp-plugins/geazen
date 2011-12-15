<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function geazen_delete_plugin() {
	global $wpdb;

	delete_option( 'gz_user' );
	delete_option( 'gz_pass' );
	delete_option( 'gz_aid' );
	delete_option( 'gz_htmllinks' );
	delete_option( 'gz_htmlproducts' );
	delete_option( 'gz_autolink_keywords' );
	delete_option( 'gz_autolink_htmllinks' );

}

geazen_delete_plugin();

?>