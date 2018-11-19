<div class="col-sm-4 sidebar sidebar-page" itemscope="itemscope" itemtype="http://schema.org/WPSideBar" role="complementary">
<?php
	if ( rational_child_pages( '', false ) ) {
		rational_child_pages();
	}
?>	<div class="rational-widgets sidebar-page">
<?php	if ( !dynamic_sidebar( 'sidebar-page' ) ) {

		}
?>	</div>
	<div class="rational-widgets sidebar-global">
<?php	if ( !dynamic_sidebar( 'sidebar-global' ) ) {
			get_search_form();
		}
?>	</div>
</div>