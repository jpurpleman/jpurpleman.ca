<?php
$format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
if ( 'html5' == $format ) {
	$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
		<label>
			<span class="sr-only">' . _x( 'Search for:', 'label', 'rational-start' ) . '</span>
			<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder', 'rational-start' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label', 'rational-start' ) . '" />
		</label>
		<input type="submit" class="search-submit btn btn-primary" value="'. esc_attr_x( 'Search', 'submit button', 'rational-start' ) .'" />
	</form>';
} else {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
		<div>
			<label class="sr-only" for="s">' . _x( 'Search for:', 'label', 'rational-start' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" id="s" />
			<input type="submit" id="searchsubmit" value="'. esc_attr_x( 'Search', 'submit button', 'rational-start' ) .'" />
		</div>
	</form>';
}
echo $form;