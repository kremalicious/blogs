<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>
			
			<header class="page-header">
				<?php 
				if ( is_home() && ! is_front_page() ) :
					olg_category_image();
					if ( is_category() ) { single_cat_title('<h1 class="page-title">'); echo '</h1>';
						} else { the_archive_title( '<h1 class="page-title">', '</h1>' );
					}
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				endif; 
				?>
			</header><!-- .page-header -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				if ( is_home() && ! is_front_page() ) :
				get_template_part( 'content', 'newslist' );
				else:
get_template_part( 'content', 'newslist' );
				//get_template_part( 'content', get_post_format() );
				endif;
			// End the loop.
			endwhile;
			

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;       

		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php get_footer(); ?>
