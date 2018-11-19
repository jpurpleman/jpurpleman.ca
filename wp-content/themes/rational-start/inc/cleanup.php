<?php
/**
 * Change the excerpt for password protected posts
 *
 * @param string excerpt The standard excerpt
 *
 * @return string New excerpt
 */
if ( !function_exists( 'rational_protected_excerpt' ) ) {
	function rational_protected_excerpt( $excerpt ) {
		if ( post_password_required() ) {
			$excerpt = '<p class="alert alert-warning">' . __( 'Password protected.', 'rational-start' ) . '</p>';
		}
		return $excerpt;
	}
	add_filter( 'the_excerpt', 'rational_protected_excerpt' );
}

/**
 * Change the 'more' content appended to excerpts
 *
 * @param string more Default 'more' text
 *
 * @return string New 'more' text
 */
if ( !function_exists( 'rational_excerpt_more' ) ) {
	function rational_excerpt_more( $more ) {
		return '&hellip;';
	}
	add_filter( 'excerpt_more', 'rational_excerpt_more' );
}

/**
 * Change the content and styling of the "protected" form
 */
if ( !function_exists( 'rational_password_form' ) ) {
	function rational_password_form() {
		global $post;
		$id = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
		$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
		<p class="alert alert-warning">' . __( 'Password protected content. Please enter the password to continue.', 'rational-start' ) . '</p>
		<p><label><span class="sr-only">' . __( 'Password:', 'rational-start' ) . '</span> <input name="post_password" id="' . $id . '" type="password" /></label> <input class="btn btn-default btn-inverse" type="submit" name="Submit" value="' . esc_attr__( 'Submit', 'rational-start' ) . '" /></p></form>
		';
		return $output;
	}
}
add_filter( 'the_password_form', 'rational_password_form' );

/**
 * Wrap the automatic embeds in a div I can control
 */
if ( !function_exists( 'rational_embed_wrapper' ) ) {
	function rational_embed_wrapper( $html, $url, $attr, $post_id ) {
		if ( !preg_match( '/twitter.com/', $url ) && !preg_match( '/\/status\//', $url ) ) {
			$output = sprintf(
				'<div class="video-wrapper">%s</div><a href="%s" target="_blank">Open in a new window &nbsp;<sup><i class="fa fa-external-link"></i></sup></a>',
				$html,
				$url
			);
			return $output;
		} else {
			return $html;
		}
	}
	add_filter( 'embed_oembed_html', 'rational_embed_wrapper', 99, 4 );
}

