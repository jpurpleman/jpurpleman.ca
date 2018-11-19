<?php get_header(); ?>
	<div id="content" class="container" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<?php	if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
?>				<article <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">					
<?php				if ( has_post_thumbnail() ) {
						$url = wp_get_attachment_url( get_post_thumbnail_id() );
?>						<div class="post-thumbnail" style="background-image:url('<?php echo $url; ?>');" itemprop="image">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
						</div>
<?php				}
?>					<header class="article">
<?php					the_title( '<h2 class="h1" itemprop="headline"><a href="' . get_permalink() . '">', '</a></h2>' );
?>					</header>
<?php				$adjustment = ( the_title( '', '' ,false ) ) ? 'negative-margin' : '';
?>					<footer class="article <?php echo $adjustment; ?>" role="contentinfo">
						<ul class="list-unstyled article-meta">
							<li><i class="fa fa-calendar"></i>
								<time datetime="<?php echo get_the_time( 'Y-m-d H:i' ); ?>" itemprop="datePublished"><?php the_time( 'F j, Y' ); ?></time>
							</li>
							<li itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author"><i class="fa fa-user"></i>
								<?php the_author_posts_link(); ?>
							</li>
<?php						if ( $format = get_post_format() ) {
?>								<li><?php rational_format_label( $format ); ?></li>
<?php						}
							$categories = wp_get_post_categories( $post->ID );
							if ( count( $categories ) > 0 ) {
?>								<li><i class="fa fa-folder-open"></i>
<?php								rational_categories( $categories );
?>								</li>
<?php						}
							$tags = wp_get_post_tags( $post->ID );
							if ( count( $tags ) > 0 ) {
?>								<li><i class="fa fa-tags"></i>
<?php								if ( function_exists( 'rational_tags' ) ) {
										rational_tags( $tags );
									} else {
										the_tags();
									}
?>								</li>
<?php						}
?>						</ul>
					</footer>
<?php				the_content('');
					rational_link_pages();
					rational_nav_extras();
?>				</article>
<?php			if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) ) {
					comments_template();
				}
			}
			if ( function_exists( 'rational_pagination' ) ) {
				rational_pagination( array(
					'first_text'	=> '<i class="fa fa-angle-double-left"></i> <span class="sr-only">&nbsp;' . __( 'First', 'rational-start' ) . '</span>',
					'previous_text'	=> '<i class="fa fa-angle-left"></i> <span class="sr-only">&nbsp;' . __( 'Previous', 'rational-start' ) . '</span>',
					'next_text'		=> '<span class="sr-only">' . __( 'Next', 'rational-start' ) . '&nbsp;</span> <i class="fa fa-angle-right"></i>',
					'last_text'		=> '<span class="sr-only">' . __( 'Last', 'rational-start' ) . '&nbsp;</span> <i class="fa fa-angle-double-right"></i>',
				) );
			} else {
?>				<nav class="pagination pagination-fallback">
					<ul>
						<li class="previous">
<?php						previous_posts_link( '<i class="fa fa-angle-left"></i> <span class="hidden-mobile">&nbsp;' . __( 'Previous', 'rational-start' ) . '</span>' );
?>						</li>
						<li class="next">
<?php						next_posts_link( '<span class="hidden-mobile">' . __( 'Next', 'rational-start' ) . '&nbsp;</span> <i class="fa fa-angle-right"></i>' );
?>						</li>
				</nav>
<?php		}
		} else {
?>			<p><?php _e( 'Nothing found.', 'rational-start' ); ?></p>
<?php	}
?>	</div>
<?php get_footer(); ?>