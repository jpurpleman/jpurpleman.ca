<div class="col-sm-4 sidebar sidebar-post" itemscope="itemscope" itemtype="http://schema.org/WPSideBar" role="complementary">
<?php
	if ( rational_child_pages( '', false ) ) {
		rational_child_pages();
	}
?>	<div class="rational-widgets sidebar-post">
<?php	if ( !dynamic_sidebar( 'sidebar-post' ) ) {
		}
?>	</div>
	<div class="rational-widgets sidebar-blog">
<?php	if ( !dynamic_sidebar( 'sidebar-blog' ) ) {
?>			<div class="widget widget_search">
				<h2 class="h3"><?php _e( 'Search', 'rational-start' ); ?></h2>
<?php			get_search_form();
?>			</div>
			<div class="widget widget_recent_entries">
<?php			rational_widget_defaults( 'recent_posts' );
?>			</div>
			<div class="widget widget_recent_comments">
<?php			rational_widget_defaults( 'recent_comments' );
?>			</div>
			<div class="widget widget_categories">
<?php			rational_widget_defaults( 'categories' );
?>			</div>
<?php	}
?>	</div>
	<div class="rational-widgets sidebar-global">
<?php	if ( !dynamic_sidebar( 'sidebar-global' ) ) {
		}
?>	</div>
</div>