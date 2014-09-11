	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h3 class="the_date"><time datetime=<?php the_time('Y-m-d'); ?>><?php the_time(get_option('date_format')) ?></time></h3>
		<?php $is_title_set = get_the_title();
		if ( empty( $is_title_set ) ) { ?>
			<h1 class="the_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf( __('Permanent Link to %1$s','museum-core'), the_title_attribute() ); ?>"><?php _e('(no title)', 'museum-core'); ?></a></h1>
		<?php } ?>
		<h1 class="the_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo sprintf( __('Permanent Link to %1$s','museum-core'), the_title_attribute() ); ?>"><?php the_title(); ?></a></h1>
        <div class="clear"></div>
		<section class="entry">
			<?php the_content(__('Read more &raquo;','museum-core')); ?>
			<div class="clear"></div>
			<?php wp_link_pages(); ?>
		</section>
		<section class="postmetadata">
			<?php
				$options = get_option( 'ap_core_theme_options' );
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
    <div class="clear"></div>