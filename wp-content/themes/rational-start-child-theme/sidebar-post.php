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
<?php	if ( !dynamic_sidebar( 'sidebar-blog' ) ) { ?>
<?php	}
?>	</div>
	<div class="rational-widgets sidebar-global">
<?php	if ( !dynamic_sidebar( 'sidebar-global' ) ) {
		}
?>	</div>
</div>
