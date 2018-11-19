<?php get_header(); ?>
	<div class="container">
		<article id="content" <?php post_class(); ?> itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">					
			<header class="article">
				<h1 itemprop="headline"><?php _e( '404: Page Not Found', 'rational-start' ); ?></h1>
			</header>
			<p><?php _e( 'Sorry, I can&rsquo;t find the page you&rsquo;re looking for. Maybe try searching for it?', 'rational-start' ); ?></p>
<?php		get_search_form();
?>		</article>
	</div>
<?php get_footer(); ?>