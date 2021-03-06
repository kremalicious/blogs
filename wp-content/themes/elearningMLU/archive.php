<?php get_header(); ?>
<div class="main">
	
	<?php include ('column-one.php'); ?>

		<div class="content">
			<div class="column two">
				<div class="edge-alt"></div>
				
		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle">Archiv f&uuml;r die &#8216;<?php single_cat_title(); ?>&#8217; Kategorie</h1>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Archiv f&uuml;r<?php the_time('F jS, Y'); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Archiv f&uuml;r <?php the_time('F, Y'); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Archiv f&uuml;r <?php the_time('Y'); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Autor Archiv</h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Blog Archiv</h1>
 	  <?php } ?>



		<?php while (have_posts()) : the_post(); ?>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
											
	                <div class="entry-thumb">
	                	<?php if (function_exists('images')) images('1', '82', '82', '', false); ?>
	                </div>
					<div class="entry">
<p class="meta"><?php the_time('j. F Y') ?> - <span class="category"><?php the_category(', '); ?></span> <?php edit_post_link('Bearbeiten', ' - ', ''); ?></p>


						<?php the_excerpt(); ?>
						<p class="more"><a href="<?php the_permalink() ?>">Weiterlesen</a></p>


					</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; &Auml;ltere Beitr&auml;ge') ?></div>
			<div class="alignright"><?php previous_posts_link('Neuere Beitr&auml;ge &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Nicht gefunden</h2>

	<?php endif; ?>

	</div><!-- end column -->

</div><!-- end content -->
<?php get_footer(); ?>