<div id="sidebar"><ul>

<!-- Logo and Feed -->
<li class="feedicon">
<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Entries (RSS)','avenue')?>">
<img src="<?php bloginfo('template_directory'); ?>/images/logo.jpg" alt="<?php _e('Entries (RSS)','avenue')?>" /></a>
</li>

<!-- Search -->
<?php include(TEMPLATEPATH . '/sidebar/search.php'); ?>


<!-- Dynamic Sidebar (Widgets) -->
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>


<!-- Feed Teaser -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/teaser.php'); ?><?php } ?>

<!-- RSS Feeds -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/feed.php'); ?><?php } ?>

<!-- Sidestep -->
<?php if ( is_single() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/sidestep.php'); ?><?php } ?>

<!-- Kalender -->
<?php if ( is_archive() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/calendar.php'); ?><?php } ?>

<!-- The Pages -->
<?php if ( is_home() || is_page() || is_404() || is_search() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/pages.php'); ?><?php } ?>

<!-- The Categorys -->
<?php include(TEMPLATEPATH . '/sidebar/categories.php'); ?>

<!-- Aktuelle Beiträge -->
<?php if ( is_single()|| is_page() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/topical.php'); ?><?php } ?>

<!-- Support -->
<?php //include(TEMPLATEPATH . '/sidebar/pad.php'); ?>

<!-- The Archive -->
<?php if ( is_archive() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/history.php'); ?><?php } ?>

<!-- The Blogroll -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/blogroll.php'); ?><?php } ?>

<!-- Neue Kommentare -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/last.php'); ?><?php } ?>

<!-- Meist kommentiert -->
<?php if ( is_single() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/most.php'); ?><?php } ?>

<!-- Statistics -->
<?php if ( is_archive() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/statistics.php'); ?><?php } ?>

<!-- Blogbutton -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/button.php'); ?><?php } ?>

<!-- Blog Control -->
<?php if ( is_home() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/control.php'); ?><?php } ?>

<!-- Tag Cloud -->
<?php if ( is_home() || is_single() || is_archive() ) { ?>
<?php include(TEMPLATEPATH . '/sidebar/cloud.php'); ?><?php } ?>

<?php endif; ?></ul>
<!-- End Dynamic Sidebar -->

</div><!-- End Sidebar -->