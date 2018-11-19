<?php get_header(); ?>
	<div class="container">
<?php	if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
?>				<article id="content" <?php post_class(); ?> itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">					
<?php				if ( has_post_thumbnail() ) {
						$url = wp_get_attachment_url( get_post_thumbnail_id(), 'rational-start-post-full' );
?>						<div class="post-thumbnail" style="background-image:url('<?php echo $url; ?>');" itemprop="image">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
						</div>
<?php				}
?>					<header class="article">
<?php					the_title( '<h1 itemprop="headline">', '</h1>' );
?>					</header>
<?php				$adjustment = ( the_title( '', '' ,false ) ) ? 'negative-margin' : '';
					$meta_on_pages = boolval( get_theme_mod( 'meta_on_pages', false ) );
					if 	( $meta_on_pages !== true ) {
?>						<footer class="article <?php echo $adjustment; ?>" role="contentinfo">
							<ul class="list-unstyled article-meta">
								<li><i class="fa fa-calendar"></i>
									<time datetime="<?php echo get_the_time( 'Y-m-d H:i' ); ?>" itemprop="datePublished"><?php the_time( 'F j, Y' ); ?></time>
								</li>
								<li itemprop="author"><i class="fa fa-user"></i>
									<?php the_author_posts_link(); ?>
								</li>
<?php							if ( $format = get_post_format() ) {
?>									<li><?php rational_format_label( $format ); ?></li>
<?php							}
								$categories = wp_get_post_categories( $post->ID );
								if ( count( $categories ) > 0 ) {
?>									<li><i class="fa fa-folder-open"></i>
<?php									rational_categories( $categories );
?>									</li>
<?php							}
								$tags = wp_get_post_tags( $post->ID );
								if ( count( $tags ) > 0 ) {
?>									<li><i class="fa fa-tags"></i>
<?php									if ( function_exists( 'rational_tags' ) ) {
											rational_tags( $tags );
										} else {
											the_tags();
										}
?>									</li>
<?php							}
?>							</ul>
						</footer>
<?php				}
					the_content();
					rational_link_pages();
					rational_nav_extras();
?>				</article>
<?php			if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
		}
?>	</div>
<?php get_footer(); ?>