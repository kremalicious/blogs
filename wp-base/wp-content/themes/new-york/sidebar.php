	<div id="sidebar">
	
	<?php $newyork_ad_check = get_option('newyork_ad_check'); if($newyork_ad_check): ?>
		<div class="thumbs">
         <a href="<?php $newyork_ad1_link = get_option('newyork_ad1_link'); echo stripslashes($newyork_ad1_link); ?>" target="_blank"><img src="<?php $newyork_ad1 = get_option('newyork_ad1'); echo stripslashes($newyork_ad1); ?>" alt="" /></a>
         <a href="<?php $newyork_ad2_link = get_option('newyork_ad2_link'); echo stripslashes($newyork_ad2_link); ?>" target="_blank"><img src="<?php $newyork_ad2 = get_option('newyork_ad2'); echo stripslashes($newyork_ad2); ?>" alt="" /></a>
         <a href="<?php $newyork_ad3_link = get_option('newyork_ad3_link'); echo stripslashes($newyork_ad3_link); ?>" target="_blank"><img src="<?php $newyork_ad3 = get_option('newyork_ad3'); echo stripslashes($newyork_ad3); ?>" alt="" /></a>
         <a href="<?php $newyork_ad4_link = get_option('newyork_ad4_link'); echo stripslashes($newyork_ad4_link); ?>" target="_blank"><img src="<?php $newyork_ad4 = get_option('newyork_ad4'); echo stripslashes($newyork_ad4); ?>" alt="" /></a>
		</div>
	<div style="clear: both;margin:0 0 20px 0;"></div>
	<?php endif; ?>
	
		<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php if ( is_404() || is_category() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?> <li>

			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for the day <?php the_time('l, F jS, Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for <?php the_time('F, Y'); ?>.</p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for the year <?php the_time('Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
			for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>

			<?php } ?>
<br />
			</li> <?php }?>
			
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>

			<?php wp_list_pages('depth=0&title_li=<h2>Pages</h2>' ); ?>

			<li><h2>Archives</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<?php wp_list_categories('title_li=<h2>Categories</h2>'); ?>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>

				<li><h2>Meta</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>

			<?php endif; ?>
		</ul>
	</div>

