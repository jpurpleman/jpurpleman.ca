<?php
if ( post_password_required() ) {
	return;
}
?>
<div class="comments-area"><a name="comments" id="comments"></a>
<?php
	if ( have_comments() ) {
?>		<h2 class="comments-title">
<?php		printf(
				_nx(
					'One thought on &ldquo;%2$s&rdquo;',
					'%1$s thoughts on &ldquo;%2$s&rdquo;',
					get_comments_number(),
					'comments title',
					'rational-start'
				),
				number_format_i18n( get_comments_number() ),
				get_the_title()
			);
?>		</h2>
		<nav class="pagination pagination-comments">
<?php		paginate_comments_links( array(
				'prev_text' => '<i class="fa fa-angle-left"></i>&nbsp; ' . __( 'Previous', 'rational-start' ),
				'next_text' => __( 'Next', 'rational-start' ) . ' &nbsp;<i class="fa fa-angle-right"></i>',
			) );
?> 		</nav>
		<ol class="comment-list list-unstyled">
<?php		wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 35,
			) );
?>		</ol>
		<nav class="pagination pagination-comments">
<?php		paginate_comments_links( array(
				'prev_text' => '<i class="fa fa-angle-left"></i>&nbsp; ' . __( 'Previous', 'rational-start' ),
				'next_text' => __( 'Next', 'rational-start' ) . ' &nbsp;<i class="fa fa-angle-right"></i>',
			) );
?> 		</nav>
<?php
	}
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
?>		<p class="no-comments"><?php _e( 'Comments are closed.', 'rational-start' ); ?></p>
<?php
	}
	?><h2 class="h3"><?php comment_form_title(); ?></h2><?php
	comment_form( array(
		'class_submit'	=> 'btn btn-default btn-inverse',
		'title_reply'	=> null,
	) );
?>
</div>
