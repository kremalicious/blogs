<?php get_header();?>

<!-- ************************************************************* -->
<?php if (have_posts()) : ?> 
		<h2 class="pagetitle">Search Results</h2>
<?php if (have_posts()) : while (have_posts()) : the_post();
	$feedback ='feedback';
	$type = 'excerpt';
	
	include (TEMPLATEPATH . "/inner_content.php");
endwhile; ?>

	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div><div style="clear:both;"></div>
	</div>
<?php else: ?>
	<div class="error"><?php _e('Sorry, no posts matched your criteria.'); ?></div>
<?php endif; ?>
<?php else: ?>
	<div class="error"><?php _e('Sorry, no posts matched your criteria.'); ?></div>
<?php endif; ?>

<!-- ************************************************************* -->
        </div>
    </div><!-- close innerContent -->
                    
<?php get_sidebar();?>
<?php get_footer(); ?>