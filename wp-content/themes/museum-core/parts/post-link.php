	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<time datetime=<?php the_time('Y-m-d'); ?>></time>
		<section class="entry">
			<?php the_content(__('Read more &raquo;','museum-core')); ?>
			<div class="clear"></div>
			<?php wp_link_pages(); ?>
		</section>
		<section class="postmetadata">
			<span class="human-time-diff alt"><?php echo sprintf(__('%1$s ago','museum-core'), human_time_diff( get_the_time('U'), current_time('timestamp') )); ?></span>
		</section>
	</article>
    <div class="clear"></div>