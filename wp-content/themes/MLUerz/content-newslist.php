<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage MLUerz
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- #col3: bereich rechts -->
    <div class="col3">
      <div class="col3_content" class="clearfix" >
	<?php
		// Post thumbnail.
if ( is_single() ) {twentyfifteen_post_thumbnail();}
	?>
	</div></div>
	<div class="news-single-timedata"> <?php
		//news date
			the_time('d.m.Y');
	?></div>
	<header class="entry-header">

		<?php
			the_title( '<h2 class="entry-title">', '</h2>' );
           if ( is_single() ) { the_post_navigation();	}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content(__('Read more...'));

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->


	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link"><div class="genericon genericon-edit"></div>', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

