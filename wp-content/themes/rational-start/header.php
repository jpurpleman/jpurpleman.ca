<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		wp_head();
?>	</head>
	<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
		<a href="#content" class="btn btn-default off-screen"><?php _e( 'Skip to Content', 'rational-start' ); ?></a>
		<a name="top" id="top"></a>
		<div class="container">
			<ul class="rational-widgets top">
<?php			dynamic_sidebar( 'top' );
?>			</ul>
		</div>
		<header class="site" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
			<div class="container">
				<div class="row">
					<button class="nav-site-toggle btn btn-block"><i class="fa fa-bars"></i> <span class="sr-only"><?php _e( 'Menu', 'rational-start' ); ?></span></button>
					<nav class="site col-sm-8" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation" aria-label="<?php _e( 'Primary Navigation', 'rational-start' ); ?>">
<?php					if ( has_nav_menu( 'nav-site' ) ) {
							wp_nav_menu( array(
								'theme_location'	=> 'nav-site',
								'container'			=> false,
								'depth'				=> 3
							) );
						} else {
?>							<ul>
<?php							wp_list_pages( array(
									'title_li' 	=> false,
									'depth'		=> 3,
									'walker'	=> new Rational_Walker_Page(),
								) );
?>							</ul>
<?php					}
?>					</nav>
					<a class="logo col-sm-4" href="<?php echo esc_url( site_url() ); ?>">
						<div class="h3" itemprop="headline"><?php bloginfo( 'name' ); ?></div>
<?php					if ($tagline = get_bloginfo(  'description' ) ) {
?>							<p itemprop="description"><?php echo $tagline; ?></p>
<?php					}
?>					</a>
				</div>
			</div>
		</header>
		<div class="container">
<?php		rational_breadcrumb();
?>		</div>