<?php
/**
 * Page Template
 *
 * Displays posts that are designated as "Pages"
 *
 * @package     Desk_Mess_Mirrored
 * @since       1.0
 *
 * @link        http://buynowshop.com/themes/desk-mess-mirrored/
 * @link        https://github.com/Cais/desk-mess-mirrored/
 * @link        http://wordpress.org/extend/themes/desk-mess-mirrored/
 *
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2009-2013, Edward Caissie
 *
 * @version     2.0
 * @date        December 11, 2012
 *
 * @version     2.1
 * @date        December 3, 2012
 * Added 'DMM No Posts Found' function to replace repetitive code
 */

get_header(); ?>

<div id="maintop"></div>
<div id="wrapper">
    <div id="content">

        <div id="main-blog">
            <div class="clear">&nbsp;</div>
            <!-- Hack: the non-breaking space keeps the content below the menu when menus contain many top-level items -->
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    get_template_part( 'desk-mess-mirrored', get_post_format() );
                } /** End while - have posts */
            } else {
                dmm_no_posts_found();
            } /** End if - have posts */ ?>
        </div><!-- #main blog -->

        <?php get_sidebar(); ?>

        <div class="clear"></div>

    </div><!-- #content -->
</div><!-- #wrapper -->

<?php get_footer();