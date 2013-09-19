		<?php
		$options = get_option( 'ap_core_theme_options' );
		$defaults = ap_core_get_theme_defaults();
		?>
		<footer class="row">
			<div class="span-4" id="leftbox">
				<ul>
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Footer Box') ) : ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="span-4" id="middlebox">
				<ul>
					 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Center Footer Box') ) : ?>
					 <?php endif; ?>
				</ul>
			</div>
			<div class="span-4 last" id="rightbox">
				<ul>
					 <?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Footer Box') ) : ?>
					 <?php endif; ?>
				</ul>
			</div>
			<div class="spacer-10"></div>
			<?php wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'footernav', 'theme_location' => 'footer', 'fallback_cb' => false, 'depth' => 1 ) ); ?>
			<div class="credit">
				<?php if ( $options['footer'] != '' ) {
				echo stripcslashes($options['footer']);
				} else {
					echo $defaults['footer'];
				} ?>
			</div>
		</footer>
	</div><!-- closes .container -->

		<?php wp_footer(); ?>
</body>
</html>
