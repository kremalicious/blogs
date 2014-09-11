	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<time datetime=<?php the_time('Y-m-d'); ?>></time>
			<h1 class="the_title"><?php the_title(); ?></h1>
            <div class="clear"></div>
			<section class="entry">
				<?php the_content(__('Read more &raquo;','museum-core')); ?>
				<div class="clear"></div>
				<?php wp_link_pages(); ?>
			</section>
			<section class="postmetadata">
				<p><?php edit_post_link(__('Edit this entry','museum-core'),'','.'); ?></p>
			</section>
    	<div class="clear"></div>
    	<section id="comments">
			<?php comments_template(); ?>
        </section>
		</article>

	<?php endwhile; endif; ?>