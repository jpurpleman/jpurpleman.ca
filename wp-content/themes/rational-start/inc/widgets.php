<?php
/**
 * Filter for the categories widget to add a custom walker.
 *
 * @param array args Previously defined arguments
 *
 * @return array Arguments with the custom walker specified
 */
if ( !function_exists( 'rational_filter_widget_categories' ) ) {
	function rational_filter_widget_categories( $args ) {
		$category_popularity = boolval( get_theme_mod( 'category_popularity', false ) );
		if 	( $category_popularity !== true ) {
			$args['walker'] = new Rational_Walker_Category();
		}
		return $args;
	}
	add_filter( 'widget_categories_args', 'rational_filter_widget_categories', 10, 1 );
}

/**
 * Modifies HTML list of categories.
 *
 * @uses Walker_Category
 */
class Rational_Walker_Category extends Walker_Category {
	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int    $depth    Depth of category in reference to parents. Default 0.
	 * @param array  $args     An array of arguments. @see wp_list_categories()
	 * @param int    $id       ID of the current category.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);
		
		$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filter the category description for display.
			 *
			 * @param string $description Category description.
			 * @param object $category    Category object.
			 */
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= '<span class="text">' . $cat_name;

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' <span class="count">(' . number_format_i18n( $category->count ) . ')</span>';
		}

		$post_count = number_format_i18n( $category->count );
		$link .= '</span><span class="popularity" data-post-count="' . $post_count . '"></span>' . "\n";

		$link .= '</a>';

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				$alt = ' alt="' . sprintf( __( 'Feed for all posts filed under %s', 'rational-start' ), $cat_name ) . '"';
			} else {
				$alt = ' alt="' . $args['feed'] . '"';
				$name = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( ! empty( $args['current_category'] ) ) {
				$_current_category = get_term( $args['current_category'], $category->taxonomy );
				if ( $category->term_id == $args['current_category'] ) {
					$class .=  ' current-cat';
				} elseif ( $category->term_id == $_current_category->parent ) {
					$class .=  ' current-cat-parent';
				}
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

/**
 * See if there are child pages and, if so, display them
 *
 * @param string title Sets the 'title_li' argument
 * @param boolean echo Display content or return boolean true/false if there are child pages
 *
 * @return mixed	If 'echo' is true, display menu and return false
 * 					If 'echo' is false, see if there are children. If there are, return 'true' else return 'false'
 */
if ( !function_exists( 'rational_child_pages' ) ) {
	function rational_child_pages( $title = false, $echo = true ) {
		global $post, $wpdb;
		$child_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE post_parent = {$post->ID} AND post_status = 'publish' AND post_type = 'page'" );
		if ( $echo && intval( $child_count ) > 0 ) {
?>			<div class="rational-widgets sidebar-subpages">
				<div class="widget widget_subpages">
				<ul>
<?php				if ( !$title ) {
						$title = __( 'Subpages', 'rational-start' );
					}
					wp_list_pages( array(
						'child_of'	=> $post->ID,
						'depth'		=> 1,
						'title_li'	=> ( $title ) ? '<h2 class="h3">' . $title . '</h2>' : '',
					) );
?>				</ul>
				</div>
			</div>
<?php		return false;
		} elseif ( intval( $child_count ) > 0 ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Generates the default widgets in various sidebars
 *
 * @param string widget Which widget to place
 */
if ( !function_exists( 'rational_widget_defaults' ) ) {
	function rational_widget_defaults( $widget = 'recent_posts' ) {
		switch ( $widget ) {
			case 'recent_posts':
				$recent_posts = wp_get_recent_posts( array(
					'numberposts' => 5,
					'post_status' => 'publish'
				) );
				echo '<h2 class="h3">' . __( 'Recent Posts', 'rational-start' ) . '</h2><ul>';
				foreach ( $recent_posts as $recent_post ) {
					printf(
						'<li><a href="%s">%s</a></li>',
						get_permalink( $recent_post['ID'] ),
						$recent_post['post_title']
					);
				}
				echo '</ul>';
				break;
			case 'recent_comments':
				$recent_comments = get_comments( array(
					'number' => 5,
					'status' => 'approve'
				) );
				echo '<h2 class="h3">' . __( 'Recent Comments', 'rational-start' ) . '</h2><ul>';
				foreach ( $recent_comments as $recent_comment ) {
					printf(
						'<li>%s %s <a href="%s">%s</a></li>',
						$recent_comment->comment_author,
						__( 'on', 'rational-start' ),
						get_the_permalink( $recent_comment->comment_post_ID ),
						get_the_title( $recent_comment->comment_post_ID )
					);
				}
				echo '</ul>';
				break;
			case 'categories':
				echo '<h2 class="h3">' . __( 'Categories', 'rational-start' ) . '</h2><ul>';
				$args['title'] = false;
				$category_popularity = boolval( get_theme_mod( 'category_popularity', false ) );
				if 	( $category_popularity !== true ) {
					$args['walker'] = new Rational_Walker_Category();
				}
				wp_list_categories( $args );
				echo '</ul>';
				break;
			case 'pages':
				echo '<h2 class="h3">' . __( 'Pages', 'rational-start' ) . '</h2><ul>';
				wp_list_pages( array(
					'title_li' => false
				) );
				echo '</ul>';
				break;
			case 'links':
				global $rational_links;
				echo '<h2 class="h3">' . __( 'Links', 'rational-start' ) . '</h2><ul>';
				foreach ( $rational_links as $link_title => $link_url ) {
					printf(
						'<li><a href="%s" target="_blank">%s</a></li>',
						$link_url,
						$link_title
					);
				}
				echo '</ul>';
				break;
		}
	}
}

