	<?php if (have_posts()) :
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		/* If this is a category archive */ if (is_category()) { ?>
		    <h1 class="the_title"><?php single_cat_title( __('Posts filed under ','museum-core') ); ?></h1>
			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h1 class="the_title"><?php single_tag_title( __('Posts filed under ','museum-core') ); ?></h1>
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h1 class="the_title"><?php echo sprintf( __('Archive for %1$s','museum-core'), get_the_time('j F Y') ); ?></h1>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h1 class="the_title"><?php echo sprintf( __('Archive for %1$s','museum-core'), get_the_time('F Y') ); ?></h1>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h1 class="the_title"><?php echo sprintf( __('Archive for %1$s','museum-core'), get_the_time('Y') ); ?></h1>
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h1 class="the_title"><?php _e('Author Archive','museum-core'); ?></h1>
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h1 class="the_title"><?php _e('Blog Archives','museum-core'); ?></h1>
		<?php } ?>
	<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    	<h3 class="the_date"><time datetime=<?php the_time('Y-m-d'); ?>><?php the_time(get_option('date_format')) ?></time></h3>
		<?php $is_title_set = get_the_title();
		if ( empty( $is_title_set ) ) { ?>
			<h1 class="the_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf( __('Permanent Link to %1$s','museum-core'), the_title_attribute() ); ?>"><?php _e('(no title)', 'museum-core'); ?></a></h1>
		<?php } ?>
		<h1 class="the_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf( __('Permanent Link to %1$s','museum-core'), the_title_attribute() ); ?>"><?php the_title(); ?></a></h1>
		<section class="entry">
			<?php include( AP_CORE_OPTIONS );
			if ( $archive_excerpt == false ) {
				the_content(__('Read more &raquo;','museum-core'));
			} else {
				if(has_post_thumbnail()) { ?>
					<div class="alignleft span-2"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a></div>
				<?php }
				the_excerpt();
			} ?>
		</section>
		<section class="postmetadata">
			<?php
            	$categories = get_the_category_list( __(', ', 'museum-core') );
				$tags = get_the_tag_list( __('and tagged ', 'museum-core'),', ' );
				$author_name = get_the_author_meta('display_name');
				$author_ID = get_the_author_meta('ID');
				$author_link = '<a href="' . get_author_posts_url($author_ID) . '">' . $author_name . '</a>';
				$author = 'by ' . $author_link;
				if ( $options['post-author'] ) {
					$postmeta = __('Posted in %1$s %2$s %3$s', 'museum-core');
				} else {
					$postmeta = __('Posted in %1$s %2$s', 'museum-core');
				}
				printf( $postmeta, $categories, $tags, $author );
			?>
			<br />
            <?php comments_popup_link(__('No Comments &#187;','museum-core'), __('One Comment &#187;','museum-core'), __('% Comments &#187;','museum-core')); ?>
        </section>
    </article>
    <div class="spacer-10"></div>
	<?php endwhile; ?>

	<nav class="navigation clearfix">
		<?php  if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
		<div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries','museum-core')) ?></div>
		<div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;','museum-core')) ?></div>
		<?php } ?>
	</nav>
	<?php endif; ?>