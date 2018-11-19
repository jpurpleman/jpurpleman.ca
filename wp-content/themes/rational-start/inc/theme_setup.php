<?php
/**
 * Content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140;
}

/**
 * Add editor style
 */
function rational_add_editor_style() {
	add_editor_style( 'editor.css' );
}
add_action( 'admin_init', 'rational_add_editor_style' );

/**
 * Theme setup
 */
if ( !function_exists( 'rational_start_setup' ) ) {
	function rational_start_setup() {
		// Enable RSS
		add_theme_support( 'automatic-feed-links' );
		
		// Title tag
		add_theme_support( 'title-tag' );
		
		// Post thumbnails
		add_theme_support( 'post-thumbnails' );
		
		// HTML5
		add_theme_support( 'html5', array(
			'caption', 'comment-list', 'comment-form', 'gallery', 'search-form', 'widgets'
		) );
		
		// Post formats
		add_theme_support( 'post-formats', array(
			'aside', 'audio', 'chat', 'gallery', 'quote', 'image', 'link', 'status', 'video'
		) );
		
		// Nav menus
		register_nav_menus( array(
			'nav-site' => __( 'Main Site Navigation', 'rational-start' ),
		) );
		
		// Image sizes
		add_image_size( 'rational-start-post-full', 1400, 577, true );
		add_image_size( 'rational-start-post-blog', 750, 374, true );
		
		// Custom background
		add_theme_support( 'custom-background', array(
			'default-color'	=> '#f2f2f2',
		) );
	}
}
add_action( 'after_setup_theme', 'rational_start_setup' );

/**
 * Theme scripts
 *
 * @todo Merge files
 */
if ( !function_exists( 'rational_start_scripts' ) ) {
	function rational_start_scripts() {
		if ( !is_admin() ) {
			// Google Font
			wp_register_style( 'google-font', '//fonts.googleapis.com/css?family=Raleway:400,700|Inconsolata|Source+Sans+Pro', false, '0.1' );
			wp_enqueue_style( 'google-font');
			// Theme style
			wp_register_style( 'rational-start-theme-style', get_bloginfo( 'stylesheet_url' ), false, '1' );
			wp_enqueue_style( 'rational-start-theme-style' );

			// Theme scripts
			wp_enqueue_script( 'jquery' );			
			$separate_scripts = boolval( get_theme_mod( 'separate_scripts', false ) );
			if 	( $separate_scripts !== true ) {
				// Compiled, minified theme script
				wp_register_script( 'rational-start-scripts', get_template_directory_uri() . '/js/scripts.min.js', array( 'jquery' ), '0.1' );
				wp_enqueue_script( 'rational-start-scripts' );
			} else {
				// Separate, headroom script
				wp_register_script( 'headroom', get_template_directory_uri() . '/js/headroom.js', false, '1' );
				wp_enqueue_script( 'headroom' );
	
				// Separate theme script
				wp_register_script( 'rational-start-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery', 'headroom' ), '0.1' );
				wp_enqueue_script( 'rational-start-scripts' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'rational_start_scripts' );

/**
 * Widgits
 */
if ( !function_exists( 'rational_widgets_init' ) ) {
	function rational_widgets_init() {
		register_sidebar( array(
			'name' => __( 'Top (Above Header)', 'rational-start' ),
			'id' => 'top',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar (Global)', 'rational-start' ),
			'id' => 'sidebar-global',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar (Page)', 'rational-start' ),
			'id' => 'sidebar-page',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar (Post)', 'rational-start' ),
			'id' => 'sidebar-post',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
		) );
		register_sidebar( array(
			'name' => __( 'Sidebar (Blog)', 'rational-start' ),
			'id' => 'sidebar-blog',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer (Copyright)', 'rational-start' ),
			'id' => 'footer-copyright',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer (Beside Copyright)', 'rational-start' ),
			'id' => 'footer-beside-copyright',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
		) );
		register_sidebar( array(
			'name' => __( 'Footer', 'rational-start' ),
			'id' => 'footer',
			'before_widget' => '<li id="%1$s" class="widget %2$s col-sm-4">',
			'after_widget'  => '</li>',
			'before_title' => '<h2 class="h3">',
			'after_title' => '</h2>',
		) );
	}
	add_action( 'widgets_init', 'rational_widgets_init' );
}

