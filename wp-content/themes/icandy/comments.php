<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
    <?php $commentscount = 0; if ( ! empty($comments_by_type['comment']) ) {
	$commentscount = count($comments_by_type['comment']); } ?>
    <?php $pingscount = 0; if ( ! empty($comments_by_type['pings']) ) {
	$pingscount = count($comments_by_type['pings']); } ?>
	<div id="comments"><span><?php _e('Comments'); ?></span></div> <!-- Dummy Anchor for comments -->
	<ul class="candy_tabs">
	    <li id="commentstab" class="candytab selected" onclick="showComments()"><?php _e('Comments'); ?> (<?php _e($commentscount); ?>)</li>
	    <li id="pingstab" class="candytab" onclick="showTrackbacks()"><?php _e('Trackbacks'); ?> (<?php _e($pingscount); ?>)</li>
	    <li id="commentsrsstab"><a href="<?php bloginfo('comments_rss2_url'); ?>" class="commentsrss"><span><?php _e('rss'); ?></span></a></li>
	    <li id="writetab"><a href="#respond"><?php _e('Leave a comment'); ?></a></li>
	</ul>
	<div class="clear"></div>
	<div class="tab_content" id="comments_section">
	    <?php if($commentscount > 0) { ?>
	    <ul class="commentslist">
		<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	    </ul>
	    <?php } else { ?>
	    <?php _e('<span class="emptycomments">No comments yet</span>'); ?>
	    <?php } ?>
	</div>
	<div class="tab_content" id="pings_section">
	    <?php if($pingscount > 0) { ?>
	    <ul class="commentslist">
		<?php wp_list_comments('type=pings&callback=mytheme_ping'); ?>
	    </ul>
	    <?php } else { ?>
	    <?php _e('<span class="emptycomments">No Trackbacks yet</span>'); ?>
	    <?php } ?>
	</div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond">
    <h2><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h2>
    <div class="cancel-comment-reply">
	<?php cancel_comment_reply_link(); ?>
    </div>

    <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
    <?php else : ?>

    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( is_user_logged_in() ) : ?>
	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
	<?php else : ?>
	<p><label for="author"><?php _e('Name'); ?> <?php if ($req) echo "(required)"; ?></label></p>
	<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></p>
	
	<p><label for="email"><?php _e('Mail (will not be published)'); ?> <?php if ($req) echo "(required)"; ?></label></p>
	<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></p>
	
	<p><label for="url"><?php _e('Website'); ?></label></p>
	<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" /></p>
    <?php endif; ?>
    <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
	<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>
	<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /><?php comment_id_fields(); ?></p>
	<?php do_action('comment_form', $post->ID); ?>
    </form>
    <?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
