<div class="col-sm-4 sidebar sidebar-blog" itemscope="itemscope" itemtype="http://schema.org/WPSideBar" role="complementary">
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