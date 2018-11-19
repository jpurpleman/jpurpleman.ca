			<footer class="site" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="rational-widgets footer-copyright">
<?php							if ( !dynamic_sidebar( 'footer-copyright' ) ) {
									printf(
										'<p>&copy; %s %d %s | %s</p>',
										__( 'Copyright', 'rational-start' ),
										date( 'Y' ),
										get_bloginfo( 'name' ),
										__( 'All Rights Reserved', 'rational-start' )
									);
								}
?>							</div>
						</div>
						<div class="col-md-6">
						</div>
					</div>
					<div class="row">
						<ul class="rational-widgets footer row">
						</ul>
					</div>
				</div>
			</footer>
			<a href="#top" class="back-to-top btn btn-default btn-inverse"><i class="fa fa-angle-up"></i> <span class="sr-only"><?php _e( 'Back to Top', 'rational-start' ); ?></span></a>
			<script>
				var backToTop = document.querySelector('.back-to-top');
				var headroom = new Headroom(backToTop);
				headroom.init();
			</script>
			<div class="overlay"></div>
			<div class="modal modal-share">
				<button class="btn btn-link modal-close"><i class="fa fa-times"></i><span class="screen-reader-text">Close</span></button>
				<div class="modal-frame">
					<h3><?php _e( 'Share', 'rational-start' ); ?></h3>
					<div class="content"></div>
				</div>
			</div>
		<?php wp_footer(); ?>
	</body>
</html>
