<?php
/**
 * @package WordPress
 * @subpackage Spectrum
 */

get_header();
?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="mainTitle">
				<h3><?php the_title(); ?></h3>
				<div class="postDate">
					<span class="month"><?php the_time('m') ?></span>
					<span class="day"><?php the_time('d') ?></span>
					<span class="year"><?php the_time('y') ?>'</span>
				</div>
			</div>
			<?php if(get_post_meta($post->ID, "postImage", true)){ ?>
			<div class="postImage">
				<img src="<?php echo get_post_meta($post->ID, "postImage", true) ?>" alt="<?php the_title(); ?>" />
			</div>
			<?php } ?>
			<div class="postMeta postAuthorAndComments">
				<p class="author">Written by <strong><?php the_author() ?></strong></p>
				<p class="commentNumber"><?php comments_popup_link('<strong>0</strong> Comments', '<strong>1</strong> Comment', '<strong>%</strong> Comments'); ?></p>
			</div>
			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>
			<div class="postMeta postCategory">
				<p class="postCategory-title"><strong>Category:</strong></p>
				<p class="postCategory-elements"><?php the_category(', '); ?></p>
			</div>
			<div class="postMeta postTags">
				<p><strong>Tagged with:</strong></p>
				<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
			</div>
			<div class="postMeta postShare">
				<p><strong>Share it:</strong></p>
				<ul>
					<li class="share-Email"><a rel="nofollow" href="mailto:?subject=An%20interesting%20post%20on%<?php bloginfo('name'); ?>&amp;body=Check%20out%20%22<?php the_title(); ?>%22%20from%20<?php bloginfo('name'); ?>: <?php the_permalink(); ?>" title="Send a link to this post by email">Share this post by E-mail</a></li>
					<li class="share-Delicious"><a rel="nofollow" href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" title="Bookmark this post on Delicious" target="_blank">Share this post on Delicious</a></li>
					<li class="share-Digg"><a rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Share this post on Digg" target="_blank">Share this post on Digg</a></li>
					<li class="share-Facebook"><a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php the_permalink() ?>" title="Share this post on Facebook" target="_blank">Share this post on Facebook</a></li>
					<li class="share-Myspace"><a rel="nofollow" href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u=<?php the_permalink() ?>" title="Share this post on Mysace" target="_blank">Share this post on Myspace</a></li>
					<li class="share-Google"><a rel="nofollow" href="http://www.google.co.uk/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>" title="Bookmark this post on Google" target="_blank">Share this post on Google</a></li>
					<li class="share-Linkedin"><a rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>&amp;summary=&amp;source=<?php bloginfo('name'); ?>">Share this post on LinkedIn</a></li>
					<li class="share-Twitter"><a rel="nofollow" href="http://twitter.com/home?status=<?php the_title(); ?>+<?php the_permalink() ?>" title="Share this post on Twitter" target="_blank">Share this post on Twitter</a></li>
					<li class="share-Reddit"><a rel="nofollow" href="http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title($id)); ?>" title="Share this post on Reddit" target="_blank">Share this post on Reddit</a></li>
					<li class="share-Stumbleupon"><a rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" title="Share this post on Stumbleupon" target="_blank">Share this post on Stumbleupon</a></li>
					<li class="share-Newsvine"><a rel="nofollow" href="http://www.newsvine.com/_tools/seed&amp;save?u=<?php the_permalink() ?>&amp;h=<?php the_title(); ?>" title="Share this post on Newsvine" target="_blank">Share this post on Newsvine</a></li>
					<li class="share-Technoratti"><a rel="nofollow" href="http://technorati.com/faves?add=<?php the_permalink() ?>" title="Share this post on Technorati" target="_blank">Share this post on Technorati</a></li>
				</ul>
			</div>
			<div class="postMeta postNav">
				<p class="prevPost"><?php previous_post_link('%link', '<strong>Previous post</strong>'); ?></p>
				<p class="nextPost"><?php next_post_link('%link', '<strong>Next post</strong>'); ?></p>
			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

	<p>Sorry, no posts matched your criteria.</p>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>