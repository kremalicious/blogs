<div class="separator"></div><?phpif ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) die ('Please do not load this page directly. Thanks!');if (!empty($post->post_password)) { 	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {?><h2>This Post is Password Protected!</h2><p>Please enter the password to view Comments.</p><?php return;	}}?><?php $altcomment = 'alt'; ?><?php if ($comments) : ?>		<h2>Comments</h2>	<ul id="comments">		<?php foreach ($comments as $comment) : ?>			<li class="<?php echo $altcomment; ?>" id="comment-<?php comment_ID(); ?>">
			
			<div class="comment-wrapper">				<div class="comment-meta">
					<?php if (function_exists('get_avatar')) {						echo get_avatar(get_comment_author_email(),'40');				  	} ?>
					<h3><?php comment_author_link(); ?></h3>					<a href="#comment-<?php comment_ID(); ?>">						<?php comment_date('M jS, Y'); ?>					</a>
				</div>                				<div class="comment-content">					<?php comment_text(); ?>				</div>
			</div>
			<div class="spacer"></div>			</li>						<?php				if ($altcomment == 'alt') {					$altcomment = 'even';				} else {					$altcomment = 'alt';				}			?>		<?php endforeach; ?>	</ul><?php else : ?>	<?php if ($post->comment_status == 'open') : ?>		<p>There are no comments yet, add one below.</p>	<? else : ?>		<p>Comments are closed.</p>	<?php endif; ?>    <?php endif; ?><?php if ('open' == $post->comment_status) : ?>	<div class="separator"></div>	<h2>Leave a Comment</h2>	<br />	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>	<p>You must be <a href="<?php bloginfo('url'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>	<?php else : ?>	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">		<?php if ( $user_ID ) : ?>			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.			<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout</a></p>		<?php else : ?>			<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" class="input" />			<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>			<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="50" class="input" />			<label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label></p>			<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="50"  class="input"/>			<label for="url"><small>Website</small></label></p>		<?php endif; ?>				<p><textarea name="comment" id="data" cols="60" rows="7" tabindex="4"></textarea></p>		<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />		</p>		<?php do_action('comment_form', $post->ID); ?>	</form><?php endif; ?><?php endif; ?>