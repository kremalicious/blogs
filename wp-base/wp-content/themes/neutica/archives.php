<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content">

<?php the_post() ?>
			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
				<div class="entry-content">
<?php the_content() ?>
					<p>

					<ul id="archives-page" class="xoxo">
						<li id="category-archives" class="content-column">
							<h3><?php _e('Archives by Category', 'sandbox') ?></h3>
							<ul>
								<?php wp_list_cats('sort_column=name&optioncount=1&feed=RSS') ?> 
							</ul>
						</li>
						<li id="monthly-archives" class="content-column">
							<h3><?php _e('Archives by Month', 'sandbox') ?></h3>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1') ?>
							</ul>
						</li>
					</ul>
<?php edit_post_link(__('Edit', 'sandbox'),'<span class="edit-link">','</span>') ?>

				</div>
				<div class="entry-meta">
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<ul class="meta-list">
					<?php printf(__('<li>Written by %1$s.</li><li>Posted on <abbr class="published green" title="%2$sT%3$s">%4$s</abbr>.</li>', 'sandbox'),
						'<span class="author vcard"><a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a></span>',
						get_the_time('Y-m-d'),
						get_the_time('H:i:sO'),
						the_date('', '', '', false),
						get_the_time(),
						get_the_category_list(', '),
						get_the_tag_list(''.__('<li>Tagged as').' ', ', ', '.</li>'),
						get_permalink(),
						wp_specialchars(get_the_title(), 'double'),
						comments_rss() ) ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\n\t\t\t\t\t<li class=\"edit-link\">", "</li>"); ?>
					</ul>
				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key/value of "comments" to enable comments on pages! ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>