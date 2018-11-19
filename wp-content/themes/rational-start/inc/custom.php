<?php
/**
 * Comments link
 *
 * @param string class Any additional classes to be appended to the anchor element
 * @param string before_text Text or HTML to be placed before the text of the link
 * @param string after_text Text or HTML to be placed after the text of the link
 * @param boolean print Echo the output (default) or return it (false).
 *
 * @return string Nothing returned or, if 'false' is passed to 'print' the string is returned
 */
if ( !function_exists( 'rational_comments_link' ) ) {
	function rational_comments_link( $class = '', $before_text = '', $after_text = '', $print = true ) {
		$count = intval( get_comments_number() );
		$permalink = get_permalink();
		$text = ' Comment';
		if ( $count !== 1 ) {
			$text .= 's';
		}
		$title = $count . $text;
		$output = '<a class="' . $class . '" href="' . $permalink . '#comments" title="' . $title . '"><i class="fa fa-comments-o"></i> ' . $count . $before_text . $text . $after_text . '</a>';
		if ( $print ) {
			echo $output;
		} else {
			return $output;
		}
	}
}

/**
 * Extras nav
 */
if ( !function_exists( 'rational_nav_extras' ) ) {
	function rational_nav_extras() {
?>		<nav class="extras">
<?php		if ( comments_open() || get_comments_number() ) {
				rational_comments_link( 'comments', '<span class="sr-only">', '</span>' );
			}
?>			<button class="share fa fa-share-alt" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"> <span class="sr-only"><?php _e( 'Share', 'rational-start' ); ?></span></button>
<?php		edit_post_link( '<i class="fa fa-pencil"></i><span class="screen-reader-text">' . __( 'Edit Post', 'rational-start' ) . '</span>' );
?>			</ul>
		</nav>		
<?php
	}
}

/**
 * Builds the pagination
 *
 * @param array args {
 * 		@param string	pages			Number of pages. If a custom loop: $custom_loop->max_num_pages
 * 		@param int		range			Number of links to display, before and after "current". Default: 2
 * 		@param string	container		Container element. Default: 'nav'
 * 		@param string	container_class	Container element class. Default: 'pagination'
 * 		@param string	list_class		Class for the 'ul' element
 * 		@param string	first_text		Text for 'first' link. Default: '&laquo; First'
 * 		@param string	previous_text	Text for 'previous' link. Default: '&lsaquo; Previous'
 * 		@param string	next_text		Text for 'next' link. Default: 'Next &rsaquo;'
 * 		@param string	last_text		Text for 'last' link. Default: 'Last &raquo;'
 * 		@param boolean	display_status	Whether or not to display "Page x of y"
 * 		@param boolean	echo			Echo the pagination or return as string. Default: true (echo)
 * }
 *
 * @return mixed False if 'echo' is set to true, pagination element if echo is set to false
 */
if ( !function_exists( 'rational_pagination' ) ) {
	function rational_pagination( $args = array() ) {
		$defaults = array(
			'pages'				=> '',
			'range'				=> 2,
			'container'			=> 'nav',
			'container_class'	=> 'pagination',
			'list_class'		=> '',
			'first_text'		=> __( '&laquo; First', 'rational-start' ),
			'previous_text'		=> __( '&lsaquo; Previous', 'rational-start' ),
			'next_text'			=> __( 'Next &rsaquo;', 'rational-start' ),
			'last_text'			=> __( 'Last &raquo;', 'rational-start' ),
			'display_status'	=> true,
			'echo'				=> true
		);
		$args = wp_parse_args( $args, $defaults );
		
		// Gathering data
		$showitems = ( $args['range'] * 2 ) + 1 ;
		global $paged;
		if ( empty( $paged ) ) {
			$paged = 1;
		}
		if ( $args['pages'] == '' ) {
			global $wp_query;
			$args['pages'] = $wp_query->max_num_pages;
	
			if ( !$args['pages'] ) {
				$args['pages'] = 1;
			}
		}
	
		// Building
		$output = sprintf(
			'<%s class="%s"><ul %s>',
			$args['container'],
			$args['container_class'],
			( isset( $args['list_class'] ) && !empty( $args['list_class'] ) ) ? 'class="' . $args['list_class'] . '"' : ''
		);	
		if ( 1 != $args['pages'] ) {
			if ( $args['display_status'] ) {
				$output .= sprintf(
					'<li class="status">Page %d of %d</li>',
					$paged,
					$args['pages']
				);
			}
			if ( $paged > 2 && $paged > $args['range'] + 1 ) {
				$output .= sprintf(
					'<li class="first"><a href="%s" title="%s">%s</a></li>',
					get_pagenum_link( 1 ),
					__( 'First Page', 'rational-start' ),
					$args['first_text']
				);
			}
			if ( $paged > 1 ) {
				$output .= sprintf(
					'<li class="previous"><a href="%s" title="%s">%s</a></li>',
					get_pagenum_link( $paged - 1 ),
					__( 'Previous Page', 'rational-start' ),
					$args['previous_text']
				);
			}
			for ( $i = 1; $i <= $args['pages']; $i++ ) {
				if ( 1 != $args['pages'] && ( !( $i >= $paged + $args['range'] + 1 || $i <= $paged - $args['range'] - 1 ) || $args['pages'] <= $showitems ) ) {
					if ( $paged == $i ) {
						$output .= sprintf(
							'<li class="current"><span class="faux-anchor" title="%s">%d</span></li>',
							__( 'Current Page', 'rational-start' ),
							$i
						);
					} else {
						$output .= sprintf(
							'<li class="page-link"><a href="%s" title="%s %d">%d</a></li>',
							get_pagenum_link( $i ),
							__( 'Page', 'rational-start' ),
							$i,
							$i
						);
					}
				}
			}
			if ( $paged < $args['pages'] ) {
				$output .= sprintf(
					'<li class="next"><a href="%s" title="%s">%s</a></li>',
					get_pagenum_link( $paged + 1 ),
					__( 'Next Page', 'rational-start' ),
					$args['next_text']
				);
			}
			if ( $paged < $args['pages'] - 1 && $paged + $args['range'] - 1 < $args['pages'] ) {
				$output .= sprintf(
					'<li class="last"><a href="%s" title="%s">%s</a></li>',
					get_pagenum_link($args['pages']),
					__( 'Last Page', 'rational-start' ),
					$args['last_text']
				);
			}
		}
		$output .= '</nav>';
		
		if ( $args['echo'] ) {
			echo $output;
			return false;
		} else {
			return $output;
		}
	}
}

/**
 * Generates the post format label for the post meta section
 *
 * @param	string	format	The post format
 * @param	boolean	echo 	Echo the result or return it
 *
 * @return	mixed			If 'echo' is true it echoes the output and returns false, if
 *							'echo' is false it returns the output.
 */
if ( !function_exists( 'rational_format_label' ) ) {
	function rational_format_label($format = false, $echo = true) {
		if ( $format ) {
			switch ( $format ) {
				case 'audio':
					$icon = 'headphones';
					break;
				case 'aside':
					$icon = 'hand-o-right';
					break;
				case 'chat':
					$icon = 'comments-o';
					break;
				case 'gallery':
				case 'image':
					$icon = 'picture-o';
					break;
				case 'quote':
					$icon = 'quote-left';
					break;
				case 'status':
					$icon = 'info-circle';
					break;
				case 'video':
					$icon = 'video-camera';
					break;
				default:
					$icon = 'square';
			}
			$output = sprintf(
				'<i class="fa fa-%s"></i> %s',
				$icon,
				ucwords( $format )
			);
			if ( $echo ) {
				echo $output;
				return false;
			} else {
				return $output;
			}
		}
	}
}

/**
 * Generate post categories for post meta
 *
 * @param	array	categories	The post's categories
 * @param	string	separator	The HTML used to separate the categories
 * @param	boolean	echo		Echo the result or return it
 *
 * @return	mixed				If 'echo' is true it echoes the output and returns false, if
 *								'echo' is false it returns the output.
 */
if ( !function_exists( 'rational_categories' ) ) {
	function rational_categories( $categories, $separator = ', ', $echo = true ) {
		$output = '';
		$i = 1;
		foreach ( $categories as $category ) {
			$category = get_category( $category );
			$output .= sprintf(
				'<a class="category category-%s" href="%s">%s</a>%s',
				$category->slug,
				get_category_link( $category->term_id ),
				$category->name,
				( $i < count( $categories ) ) ? $separator : ''
			);
			$i++;
		}
		if ( $echo ) {
			echo $output; 
			return false;
		} else {
			return $output;
		}
	}
}

/**
 * Generate post tags for post meta
 *
 * @param	array	tags		The post's tags
 * @param	string	separator	The HTML used to separate the categories
 * @param	boolean	echo		Echo the result or return it
 *
 * @return	mixed				If 'echo' is true it echoes the output and returns false, if
 *								'echo' is false it returns the output.
 */
if ( !function_exists( 'rational_tags' ) ) {
	function rational_tags( $tags, $separator = ', ', $echo = true ) {
		$output = '';
		$i = 1;
		foreach ( $tags as $tag ) {
			$output .= sprintf(
				'<a class="tag tag-%s" href="%s">%s</a>%s',
				$tag->slug,
				get_tag_link( $tag->term_id ),
				$tag->name,
				( $i < count( $tags ) ) ? $separator : ''
			);
			$i++;
		}
		if ( $echo ) {
			echo $output; 
			return false;
		} else {
			return $output;
		}
	}
}

/**
 * Just makes the 'link_pages' function smaller in the themes
 */
if ( !function_exists( 'rational_link_pages' ) ) {
	function rational_link_pages() {
		wp_link_pages( array(
			'next_or_number'	=> 'next',
			'before'			=> '<nav class="pagination pagination-page"><ul><li>',
			'after'				=> '</li></ul></nav>',
			'separator'			=> '</li><li>',
			'nextpagelink'		=> __( 'Next', 'rational-start' ) . ' &nbsp;<i class="fa fa-angle-right"></i>',
			'previouspagelink'	=> '<i class="fa fa-angle-left"></i>&nbsp; ' . __( 'Previous', 'rational-start' ),
		) );
	}
}

if ( !function_exists( 'rational_get_the_excerpt' ) ) {
	function rational_get_the_excerpt( $text, $excerpt ) {
	    if ( $excerpt ) return $excerpt;
		
		$raw_excerpt = $text;
	    $text = strip_shortcodes( $text );
	
	    $text = apply_filters( 'the_content', $text );
	    $text = str_replace( ']]>', ']]&gt;', $text );
	    $text = strip_tags( $text );
	    $excerpt_length = apply_filters( 'excerpt_length', 55 );
	    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
	    $words = preg_split( "/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
	    if ( count( $words ) > $excerpt_length ) {
	            array_pop( $words );
	            $text = implode( ' ', $words );
	            $text = $text . $excerpt_more;
	    } else {
	            $text = implode( ' ', $words );
	    }
	
	    return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
	}
}

if ( !function_exists( 'rational_breadcrumb' ) ) {
	/**
	 * Builds the breadcrumb menu for the theme
	 * 
	 * @param array $args {
	 * 		Optional. Array for overriding defaults
	 * 
	 * 		@type	string	$separator			The divider between breadcrumb elements. Default is '/'
	 *		@type	string	$container			The main element for containing the breadcrumb menu. Default is 'nav'
	 *		@type	string	$container_class	The class for the main element. Default is 'breadcrumb'
	 * 		@type	string	$list_class			The class for the ul element. No default
	 * 		@type	string	$home_title			The title to be used for 'Home'. Default is 'Home'
	 * }
	 */
	function rational_breadcrumb( $args = array() ) {
		if ( ! is_front_page() ) {
			$defaults = array(
				'separator'			=> '/',
				'container'			=> 'nav',
				'container_class'	=> 'breadcrumb',
				'list_class'		=> false,
				'home_title'		=> 'Home'
			);
			$args = wp_parse_args( $args, $defaults );
			
			$type = rational_content_type();
			
			$formats = array(
				'parent'	=> '<li class="item-%s" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" title="%s">%s</a></li><li class="separator">%s</li>', // slug, url, title, title, separator
				'current'	=> '<li class="active item-%s" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" title="%s">%s</li>' // slug, title, title
			);
			
			$output = '';
			
			// Container open
			if ( $args['container'] ) {
				$output .= sprintf(
					'<%s %s>',
					$args['container'],
					( $args['container_class'] ) ? 'class="' . $args['container_class'] . '"' : ''
				);
			}
			
			// Unordered list open
			$output .= sprintf(
				'<ul %s>',
				( $args['list_class'] ) ? 'class="' . $args['list_class'] . '"' : ''
			);
			
			// Home
			$home_url = get_home_url();
			$output .= rational_breadcrumb_parent( $formats['parent'], 'home', $home_url, $args['home_title'], $args['separator'] );
			
			switch ( $type ) {
				case 'blog':
					global $paged;
					$blog_page = get_option( 'page_for_posts' );
					
					if ( $paged ) {
						$blog_page = get_option( 'page_for_posts' );
						$blog_page_title = get_the_title( $blog_page );
						$blog_page_url = get_permalink( $blog_page );
						$output .= rational_breadcrumb_parent( $formats['parent'], 'blog', $blog_page_url, $blog_page_title, $args['separator'] );
						
						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
					} else {
						$blog_page_title = get_the_title( $blog_page );
						// current
						$output .= rational_breadcrumb_current( $formats['current'], $type, $blog_page_title );
					}
					
					break;
				case 'single':
					global $page;
					$blog_page = get_option( 'page_for_posts' );
					$blog_page_title = get_the_title( $blog_page );
					$blog_page_url = get_permalink( $blog_page );
					
					// parent: blog
					$output .= rational_breadcrumb_parent( $formats['parent'], 'blog', $blog_page_url, $blog_page_title, $args['separator'] );
					
					$the_title = get_the_title();
					if ( $page > 1 ) {
						// root page
						$the_url = get_the_permalink();
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $the_url, $the_title, $args['separator'] );

						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $page );
					} else {
						// current
						$output .= rational_breadcrumb_current( $formats['current'], $type, $the_title );
					}
					break;
				case 'category':
					global $paged;
					$category = get_category( get_query_var( 'cat' ), false );
					
					// ancestor categories
					$ancestors = get_ancestors( $category->term_id, 'category' );
					$ancestors = array_reverse( $ancestors );
					foreach ( $ancestors as $ancestor ) {
						$ancestor_category = get_category( $ancestor, false );
						$ancestor_url = get_category_link( $ancestor );
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $ancestor_url, $ancestor_category->cat_name, $args['separator'] );
					}
					
					if ( $paged ) {
						$category_url = get_category_link( $category->term_id );
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $category_url, $category->cat_name, $args['separator'] );

						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
					} else {
						// current
						$output .= rational_breadcrumb_current( $formats['current'], $type, $category->cat_name );
					}
					break;
				case 'page':
					global $post, $page;

					// ancestor pages
					$ancestors = get_post_ancestors( $post->ID );
					$ancestors = array_reverse( $ancestors );
					foreach ( $ancestors as $ancestor ) {
						$ancestor_title = get_the_title( $ancestor );
						$ancestor_url = get_permalink( $ancestor );
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $ancestor_url, $ancestor_title, $args['separator'] );
					}
					
					$page_title = get_the_title();
					if ( $page > 1 ) {
						$page_link = get_the_permalink();
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $page_link, $page_title, $args['separator'] );
						
						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $page );
					} else {
			            // current
						$output .= rational_breadcrumb_current( $formats['current'], $type, $page_title );						
					}
					
					break;
				case 'tag':
					global $paged;
					
					if ( $paged ) {
						$tag_id = get_query_var( 'tag_id' );
						$tag = get_tag( $tag_id );
						$tag_url = get_tag_link( $tag_id );
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $tag_url, $tag->name, $args['separator'] );
						
						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
					} else {
						// current
						$tag_name = single_tag_title( '', false );
						$output .= rational_breadcrumb_current( $formats['current'], $type, $tag_name );
					}
					break;
				case 'day':
				case 'month':
				case 'year':
					$year = get_the_time('Y');
					$year_link = get_year_link( $year );
					$month_num = get_the_time('m');
					$month_text = get_the_time('F');
					$month_link = get_month_link( $year, $month_num );
					$day_num = get_the_time('j');
					$day_link = get_day_link( $year, $month_num, $day_num );
					global $paged;
					
					if ( $type === 'year' ) {
						
						if ( $paged ) {
							$output .= rational_breadcrumb_parent( $formats['parent'], $type, $year_link, $year, $args['separator'] );
							
							// page
							$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
						} else {
							// year
							$output .= rational_breadcrumb_current( $formats['current'], $type, $year );
						}

					} else {
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $year_link, $year, $args['separator'] );
						
						if ( $type === 'month' ) {
							
							if ( $paged ) {
								$output .= rational_breadcrumb_parent( $formats['parent'], $type, $month_link, $month_text, $args['separator'] );
								
								// page
								$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
							} else {
								// month
								$output .= rational_breadcrumb_current( $formats['current'], $type, $month_text );
							}
							
						} else {
							$output .= rational_breadcrumb_parent( $formats['parent'], $type, $month_link, $month_text, $args['separator'] );
							
							if ( $paged ) {
								$output .= rational_breadcrumb_parent( $formats['parent'], $type, $day_link, $day_num, $args['separator'] );
								
								// page
								$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
							} else {
								// day
								$output .= rational_breadcrumb_current( $formats['current'], $type, $day_num );
							}
						}
					}
					break;
				case 'author':
					global $author, $paged;
		            $userdata = get_userdata( $author );
		            
		            if ( $paged ) {
			            $author_url = get_author_posts_url( $author );
			            $output .= rational_breadcrumb_parent( $formats['parent'], $type, $author_url, $userdata->display_name, $args['separator'] );
			            
						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
		            } else {
						// current
						$output .= rational_breadcrumb_current( $formats['current'], $type, $userdata->display_name );
		            }
					break;
				case 'search':
					global $paged;
					$query = get_search_query();
					if ( $paged ) {
						$search_url = $home_url . '/?s=' . $query;
						$output .= rational_breadcrumb_parent( $formats['parent'], $type, $search_url, __( 'Results for', 'rational-start' ) . ': ' . $query, $args['separator'] );
						
						// page
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Page ', 'rational-start' ) . $paged );
					} else {
						$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Results for', 'rational-start' ) . ': ' . $query );
					}
					break;
				case '404':
					$output .= rational_breadcrumb_current( $formats['current'], $type, __( 'Error 404', 'rational-start' ) );
					break;
			}
			
			// Unordered list close
			$output .= '</ul>';
	
			// Container close
			if ( $args['container'] ) {
				$output .= '</' . $args['container'] . '>';
			}
			
			echo $output;
		}
	}
}
	
if ( !function_exists( 'rational_breadcrumb_current' ) ) {
	function rational_breadcrumb_current( $format, $type, $title ) {
		$return = sprintf(
			$format,
			$type,
			$title,
			$title
		);
		return $return;
	}
}

if ( !function_exists( 'rational_breadcrumb_parent' ) ) {
	function rational_breadcrumb_parent( $format, $type, $url, $title, $separator ) {
		$return = sprintf(
			$format,
			$type,
			$url,
			$title,
			$title,
			$separator
		);
		return $return;
	}
}

if ( !function_exists( 'rational_content_type' ) ) {
	function rational_content_type() {
		$type = false;
		if ( is_home() ) {
			$type = 'blog';
		} elseif ( is_single() ) {
			$type = 'single';
		} elseif ( is_category() ) {
			$type = 'category';
		} elseif ( is_page() ) {
			$type = 'page';
		} elseif ( is_tag() ) {
			$type = 'tag';
		} elseif ( is_day() ) {
			$type = 'day';
		} elseif ( is_month() ) {
			$type = 'month';
		} elseif ( is_year() ) {
			$type = 'year';
		} elseif ( is_author() ) {
			$type = 'author';
		} elseif ( is_search() ) {
			$type = 'search';
		} elseif ( is_404() ) {
			$type = '404';
		}
		return $type;
	}
}

/**
 * Create HTML list of pages.
 *
 * @since 1.0
 * @uses Walker_Page
 */
class Rational_Walker_Page extends Walker_Page {
	/**
	 * @see Walker_Page::start_lvl()
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 * @param array $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='sub-menu'>\n"; // match wp_nav_menu output
	}

	/**
	 * @see Walker_Page::start_el()
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth ) {
			$indent = str_repeat( "\t", $depth );
		} else {
			$indent = '';
		}

		$css_class = array();
		// For storing the toggle button when needed
		if (
			isset( $args['pages_with_children'][ $page->ID ] ) &&
			(
				!$args['depth'] ||
				$depth < ( $args['depth'] - 1 )
			)
		) {
			$css_class[] = 'parent';
		}

		// Simplified classes
		if ( ! empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
				$css_class[] = 'current-ancestor';
			}
			if ( $page->ID == $current_page ) {
				$css_class[] = 'current';
			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
				$css_class[] = 'current-parent';
			}
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current-parent';
		}

		/**
		 * Filter the list of CSS classes to include with each page item in the list.
		 *
		 * @since 1.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array   $css_class    An array of CSS classes to be applied
		 *                             to each list item.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page, used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */
		if ( count( $css_class ) > 0 ) {
			$css_classes = 'class="' . implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) ) . '"';
		} else {
			$css_classes = '';
		}

		if ( '' === $page->post_title ) {
			$page->post_title = sprintf( __( '#%d (no title)', 'rational-start' ), $page->ID );
		}

		$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
		$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

		/** This filter is documented in wp-includes/post-template.php */
		$output .= $indent . sprintf(
			'<li %s><a href="%s">%s%s%s</a>',
			$css_classes,
			get_permalink( $page->ID ),
			$args['link_before'],
			apply_filters( 'the_title', $page->post_title, $page->ID ),
			$args['link_after']
		);

		if ( ! empty( $args['show_date'] ) ) {
			if ( 'modified' == $args['show_date'] ) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
			$output .= " " . mysql2date( $date_format, $time );
		}
	}
}
