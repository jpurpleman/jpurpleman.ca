<?php
/**
 * Links used in default footers
 */
$rational_links = array(
	'Rational Themes' => 'http://jeremyhixon.com',
	'WordPress.org' => 'http://wordpress.org'
);

/**
 * Theme options
 */
$rational_theme_options = get_option( '_rational_theme_settings_options' );

require_once( 'inc/theme_setup.php' );

require_once( 'inc/cleanup.php' );

require_once( 'inc/widgets.php' );

require_once( 'inc/custom.php' );

require_once( 'inc/theme_settings.php' );