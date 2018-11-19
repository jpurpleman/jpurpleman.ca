<?php
function rational_customize_register( $wp_customize ) {
	// Theme options panel
	$wp_customize->add_panel( 'rational_panel', array(
		'capability'	=> 'edit_theme_options',
		'title'			=> __( 'Theme Settings', 'rational-start' ),
	) );
		// Misc section
		$wp_customize->add_section( 'rational_misc', array(
			'capability'	=> 'edit_theme_options',
			'title'			=> __( 'Misc', 'rational-start' ),
			'panel'			=> 'rational_panel',
		) );
			// Category popularity
			$wp_customize->add_setting( 'category_popularity', array(
				'default'			=> '',
				'capability'		=> 'edit_theme_options',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'sanitize_callback'	=> 'rational_sanitize_checkbox',
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'category_popularity_control',
				array(
					'label'			=> __( 'Category Popularity', 'rational-start' ),
					'description'	=> __( 'Disable the bar graph style category popularity indicator.', 'rational-start' ),
					'section'		=> 'rational_misc',
					'settings'		=> 'category_popularity',
					'type'			=> 'checkbox',
				)
			) );
			// Meta on pages
			$wp_customize->add_setting( 'meta_on_pages', array(
				'default'			=> '',
				'capability'		=> 'edit_theme_options',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'sanitize_callback'	=> 'rational_sanitize_checkbox',
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'meta_on_pages_control',
				array(
					'label'			=> __( 'Meta on Pages', 'rational-start' ),
					'description'	=> __( 'Do not display meta information, such as the date posted, on pages.', 'rational-start' ),
					'section'		=> 'rational_misc',
					'settings'		=> 'meta_on_pages',
					'type'			=> 'checkbox',
				)
			) );
		// Speed section
		$wp_customize->add_section( 'rational_speed', array(
			'capability'	=> 'edit_theme_options',
			'title'			=> __( 'Speed', 'rational-start' ),
			'panel'			=> 'rational_panel',
		) );
			// Separate Scripts
			$wp_customize->add_setting( 'separate_scripts', array(
				'default'			=> '',
				'capability'		=> 'edit_theme_options',
				'transport'			=> 'refresh',
				'type'				=> 'theme_mod',
				'sanitize_callback'	=> 'rational_sanitize_checkbox',
			) );
			$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'separate_scripts_control',
				array(
					'label'			=> __( 'Separate Scripts', 'rational-start' ),
					'description'	=> __( 'If checked the theme will use individual script files instead of the combined, minified scripts.<br><br>Not recommended: Combined, minified scripts load faster. Might be useful for debugging.', 'rational-start' ),
					'section'		=> 'rational_speed',
					'settings'		=> 'separate_scripts',
					'type'			=> 'checkbox',
				)
			) );
}
add_action( 'customize_register', 'rational_customize_register' );

function rational_sanitize_checkbox( $value ) {
	$value = ( $value == true ) ? true : false;
	return $value;
}