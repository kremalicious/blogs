<?php
if (!function_exists('ap_core_register_sidebars')) {
    function ap_core_register_sidebars() {
        register_sidebar(array(
        	'name' => __('Sidebar','museum-core'),
        	'description' => __('This is the regular, widgetized sidebar','museum-core'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
        	'name' => __('Left Footer Box','museum-core'),
        	'description' => __('This is the left box in the footer.','museum-core'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
    		'name' => __('Center Footer Box','museum-core'),
        	'description' => __('This is the center box in the footer.','museum-core'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
        register_sidebar(array(
    		'name' => __('Right Footer Box','museum-core'),
        	'description' => __('This is the right box in the footer.','museum-core'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>'
        ));
    }
    add_action('widgets_init','ap_core_register_sidebars');
}

/**
 * clear shortcode
 * @since 0.1
 * @author Chris Reynolds
 * @uses add_shortcode
 * a quick shortcode that clears floats
 * usage example: [clear]
 */
if (!function_exists('ap_core_clear')) {
    function ap_core_clear() {
    	return '<div class="clear"></div>';
    }
    add_shortcode('clear','ap_core_clear');
}

/**
 * load scripts
 * @since 0.1
 * @author Chris Reynolds
 * @uses wp_register_script()
 * @uses wp_enqueue_script()
 * @uses wp_register_style()
 * @uses wp_enqueue_style
 * loads all the styles and scripts for the theme
 * twitter_anywhere = loads the twitter @anywhere framework
 * twitter_hovercards = loads twitter hovercards from @anywhere
 * suckerfish = loads suckerfish from the theme's /js files
*/
if (!function_exists('ap_core_load_scripts')) {
    function ap_core_load_scripts() {
      if ( !is_admin() ) { // instruction to only load if it is not the admin area
        if ( function_exists( 'wp_get_theme' ) ) {
             $theme = wp_get_theme();
        } else {
      	     $theme  = get_theme( get_current_theme() );
         }
        // load the theme options and defaults
        $defaults = ap_core_get_theme_defaults();
        $options = get_option( 'ap_core_theme_options' );
        if ( isset( $options['hovercards'] ) ) {
            if ( $options['hovercards'] != false ) {
                // this loads the twitter anywhere framework
                wp_register_script('twitter_anywhere','http://platform.twitter.com/anywhere.js?id=3O4tZx3uFiEPp5fk2QGq1A',false,$theme['Version'] );
                wp_enqueue_script('twitter_anywhere');
                // this loads twitter hovercards, dependent upon twitter anywhere
                wp_register_script('twitter_hovercards',get_bloginfo('template_directory').'/js/hovercards.js','twitter_anywhere',$theme['Version']);
                wp_enqueue_script('twitter_hovercards');
            }
        }
        // this loads suckerfish.js the dropdown menus
        wp_register_script('suckerfish',get_bloginfo('template_directory').'/js/suckerfish.js',false,$theme['Version']);
        wp_enqueue_script('suckerfish');
        // this loads jquery (for formalize, among other things)
        wp_enqueue_script('jquery');
        // this loads the formalize js
        wp_register_script('formalize',get_bloginfo('template_directory').'/js/jquery.formalize.min.js',false,$theme['Version']);
        wp_enqueue_script('formalize');
        // loads modernizr for BPH5
        wp_register_script('modernizr',get_bloginfo('template_directory').'/js/modernizr-2.5.3.min.js',false,'2.5.3');
        wp_enqueue_script('modernizr');
        // register fonts
        wp_register_style('droidsans','http://fonts.googleapis.com/css?family=Droid+Sans',false,$theme['Version']);
        wp_register_style('ptserif','http://fonts.googleapis.com/css?family=PT+Serif&subset=latin,cyrillic',false,$theme['Version']);
        wp_register_style('inconsolata','http://fonts.googleapis.com/css?family=Inconsolata',false,$theme['Version']);
        wp_register_style('ubuntu','http://fonts.googleapis.com/css?family=Ubuntu&subset=latin,cyrillic-ext,greek,greek-ext,latin-ext,cyrillic',false,$theme['Version']);
        wp_register_style('lato','http://fonts.googleapis.com/css?family=Lato',false,$theme['Version'] );
        // only enqueue fonts that are actually being used
        $corefonts = array( $options['heading'], $options['body'], $options['alt'] );
        //var_dump($corefonts);
        // if any of these fonts are selected, load their stylesheets
        if ( in_array( 'Droid Sans', $corefonts ) ) {
            wp_enqueue_style( 'droidsans' );
        }
        if ( in_array( 'PT Serif', $corefonts ) ) {
            wp_enqueue_style( 'ptserif' );
        }
        if ( in_array( 'Inconsolata', $corefonts ) ) {
            wp_enqueue_style( 'inconsolata' );
        }
        if ( in_array( 'Ubuntu', $corefonts ) ) {
            wp_enqueue_style( 'ubuntu' );
        }
        if ( in_array( 'Lato', $corefonts ) ) {
            wp_enqueue_style( 'lato' );
        }
        // this loads the style.css
        wp_register_style('corecss',get_bloginfo('stylesheet_url'),false,$theme['Version']);
        wp_enqueue_style('corecss');
        // loads the comment reply script
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
      }
    }
    add_action( 'wp_enqueue_scripts', 'ap_core_load_scripts' );
}

/**
 * setup AP Core
 * @uses add_theme_support()
 * @uses register_nav_menus()
 * @uses set_post_thumbnail_size()
 * @uses add_custom_background()
 * @uses add_custom_image_header()
 * @since 0.2
 * adds core WordPress theme functionality and adds some tweaks
 */
if (!function_exists('ap_core_setup')) {
    function ap_core_setup() {

        define( "AP_CORE_OPTIONS", get_template_directory() . '/inc/load-options.php' );
        // load up the theme options
        require_once ( get_template_directory() . '/inc/theme-options.php' );

        // i18n stuff
        load_theme_textdomain('museum-core', get_template_directory() .'/lang');

        // post thumbnail support
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 ); // 150 pixels wide by 150 pixels tall, box resize mode
        // post formats
        // register all post formats -- child themes can remove some post formats as they so desire
        add_theme_support('post-formats',array('aside','gallery','link','image','quote','status','video','audio','chat'));

        // automatic feed links
        add_theme_support('automatic-feed-links');

    	if ( ! isset( $content_width ) ) $content_width = 1140;

        // custom nav menus
        // This theme uses wp_nav_menu() in three (count them, three!) locations.
        register_nav_menus( array(
        	'top' => __( 'Top Header Navigation', 'museum-core' ),
        	'main' => __( 'Main Navigation', 'museum-core' ),
        	'footer' => __( 'Footer Navigation', 'museum-core' ),
        ) );

        // This adds a home link option in the Menus
        if (!function_exists('ap_core_home_page_menu_args')) {
            function ap_core_home_page_menu_args( $args ) {
                $args['show_home'] = true;
                return $args;
            }
            add_filter( 'wp_page_menu_args', 'ap_core_home_page_menu_args' );
        }

        // This theme allows users to set a custom background
        if ( function_exists( 'get_custom_header' ) ) { // if we're using 3.4, do this the new way (this will be removed with 3.5) -- this is borrowed from p2

            add_theme_support( 'custom-background', array() );  // 'nuff said. there are no defaults here, so we'll move on to headers

            add_theme_support( 'custom-header', array(
                // default header image
                'default-image' => get_template_directory_uri() . '/images/headers/nature.jpg',
                // header text? no, because we're doing it a different way (though it would probably be good to fix this later)
                'header-text' => false,
                // header image width
                'width' => 1140,
                // flexible height?  sure
                'flex-height' => true,
                // header image height
                'height' => 200,
                // admin head callback
                'admin-head-callback' => 'core_admin_header_style'
                )
            );

        } else {

         // if we're using 3.3, do this the old way
            add_custom_background();

            // this theme has a custom header thingie
            define( 'HEADER_TEXTCOLOR', '' );
            // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
            define( 'HEADER_IMAGE', '%s/images/headers/smoke.jpg' );

            // The height and width of your custom header. You can hook into the theme's own filters to change these values.
            define( 'HEADER_IMAGE_WIDTH', apply_filters( 'core_header_image_width', 1140 ) );
            define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'core_header_image_height', 200 ) );

            // We'll be using post thumbnails for custom header images on posts and pages.
            // We want them to be 1140 pixels wide by 200 pixels tall.
            // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
            set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

            // Don't support text inside the header image.
            define( 'NO_HEADER_TEXT', true );

            // Add a way for the custom header to be styled in the admin panel that controls
            // custom headers. See twentyten_admin_header_style(), below.
            add_custom_image_header( '', 'core_admin_header_style' );

            // ... and thus ends the changeable header business.

        }

            // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
            register_default_headers( array(
            	'nature' => array(
            		'url' => '%s/images/headers/nature.jpg',
            		'thumbnail_url' => '%s/images/headers/nature-thumbnail.jpg',
            		/* translators: header image description */
            		'description' => __( 'Nature', 'museum-core' )
            	),
            	'smoke' => array(
            		'url' => '%s/images/headers/smoke.jpg',
            		'thumbnail_url' => '%s/images/headers/smoke-thumbnail.jpg',
            		/* translators: header image description */
            		'description' => __( 'Smoke', 'museum-core' )
            	),
            	'lights1' => array(
        			'url' => '%s/images/headers/lights1.jpg',
            		'thumbnail_url' => '%s/images/headers/lights1-thumbnail.jpg',
            		/* translators: header image description */
            		'description' => __( 'Lights 1', 'museum-core' )
        		),
                'lights2' => array(
                    'url' => '%s/images/headers/lights2.jpg',
                    'thumbnail_url' => '%s/images/headers/lights2-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __( 'Lights 2', 'museum-core' )
                ),
            	'lights3' => array(
            		'url' => '%s/images/headers/lights3.jpg',
        			'thumbnail_url' => '%s/images/headers/lights3-thumbnail.jpg',
            		/* translators: header image description */
            		'description' => __( 'Lights 3', 'museum-core' )
            	)
            ) );

            function core_admin_header_style() {
                // I don't have any custom header styles...yet.
            }


    	// this changes the output of the comments
        if (!function_exists('ap_core_comment')) {
        	function ap_core_comment($comment, $args, $depth) {
                $GLOBALS['comment'] = $comment; ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
                <div id="comment-<?php comment_ID(); ?>" class="the_comment">
                    <div class="comment-author vcard">
                        <?php echo get_avatar($comment,$size='64',$default='' ); ?>
                        <?php echo sprintf(__('On %1$s at %2$s %3$s said:','museum-core'), get_comment_date(), get_comment_time(), get_comment_author_link()) ?>
                    </div>
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em><?php _e('Your comment is awaiting moderation.', 'museum-core') ?></em>
                        <br />
                    <?php endif; ?>
                    <?php comment_text() ?>
                    <div class="comment-meta commentmetadata"><?php edit_comment_link(__('(Edit)', 'museum-core'),'  ','') ?></div>
                    <?php if ( comments_open() ) { ?>
                        <div class="reply"><button>
                        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'reply_text' => __('Respond to this','museum-core'), 'max_depth' => $args['max_depth']))) ?>
                        </button></div>
                    <?php } ?>
                </div>
                <?php
            }
        }

    	// this changes the default [...] to be a read more hyperlink
        if (!function_exists('ap_core_new_excerpt_more')) {
        	function ap_core_new_excerpt_more($more) {
                global $post;
        		return '...&nbsp;(<a href="'. get_permalink($post->ID) . '">' . __('read more','museum-core') . '</a>)';
        	}
        	add_filter('excerpt_more', 'ap_core_new_excerpt_more');
        }

    }
    add_action('after_setup_theme','ap_core_setup');
}

/**
 * customized wp_title
 * @since 1.0.5
 * @author Chris Reynolds
 * @uses wp_title
 * @link http://wordpress.stackexchange.com/questions/32622/when-calling-wp-title-do-you-have-to-create-some-kind-of-title-php-file
 * replaces default wp_title with a modified version
 */
if (!function_exists('ap_core_wp_title')) {
    function ap_core_wp_title( $title ) {
        if ( !is_404() )
            $category = get_the_category(); // get the category only if we aren't looking at a 404 page
        $name = get_bloginfo('name');
        $description = get_bloginfo('description');

        // if we're on the home page...
        if ( is_home() ) {
            $ap_core_title = $name;
        }

        // if we're on a category archive page...
        elseif ( is_category() ) {
            $ap_core_title = single_cat_title( '', false ) . ' | ' . $name;
        }

        // if we're on a single post...
        elseif ( is_single() ) {
            $ap_core_title = single_post_title( '', false ) . ' | ' . $category[0]->cat_name;
        }

        // if we're on a page...
        elseif ( is_page() ) {
            $ap_core_title = single_post_title( '', false );
        }

        // if we're on a 404...
        elseif ( is_404() ) {
            $ap_core_title = 'Page not found | ' . $name;
        }
        // for everything else...
        else {
            $ap_core_title = $name;
        }

        $ap_core_title .= ' | ' . $description;

        // return new title
        return $ap_core_title;
    }
    add_filter( 'wp_title', 'ap_core_wp_title' );
}

/**
 * Meta generator
 * @since 0.4.5
 * @author Chris Reynolds
 * @uses get_theme() (deprecated)
 * @uses get_current_theme() (deprecated)
 * @uses wp_get_theme()
 * returns a generator meta tag that is added in the header which pulls automatically from the theme version
 * (replaces the original method which was updating this generator tag manually)
 * generator tag is used for troubleshooting to identify what version of the theme people are using by looking at the source
 */
if (!function_exists('ap_core_generator')) {
    function ap_core_generator() {
        if ( function_exists( 'wp_get_theme' ) ) {
            $theme = wp_get_theme();
            $ap_core_version = '<meta name="generator" content="' . $theme['Name'] . ' ' . $theme['Version'] . '">';
        } else {
            $theme  = get_theme( get_current_theme() );
            $ap_core_version = '<meta name="generator" content="' . get_current_theme() . ' ' . $theme['Version'] . '">';
        }
        echo $ap_core_version;
    }
    $options = get_option( 'ap_core_theme_options' );
    if ($options['generator'] == true) {
        add_action( 'wp_head', 'ap_core_generator' );
    }
}

/**
 * Get default options
 * @since 0.4.0
 * @author Chris Reynolds
 * defines the options and some defaults
 */
if (!function_exists('ap_core_get_theme_defaults')) {
    function ap_core_get_theme_defaults(){
        // default options settings
        $defaults = array(
            // sidebar
        	'sidebar' => 'left',
            // theme tracking
            'presstrends' => false,
        	// typography options
        	'heading' => 'PT Serif',
        	'body' => 'Droid Sans',
        	'alt' => 'Ubuntu',
            // link color
            'link' => '#486D96',
            'hover' => '#333333',
            // excerpts or full posts
            'excerpts' => true,
            // use alt for h1?
            'alth1' => false,
            // footer text
            'footer' => sprintf( __( '%1$s %2$s %3$s', 'museum-core' ), '&copy;',  date('Y'), get_bloginfo('title') ) . ' . ' . sprintf( __( 'Museum Core by %1$sMuseum Themes%2$s is proudly powered by %3$sWordPress%2$s.', 'museum-core' ), '<a href="http://museumthemes.com/" target="_blank" title="Museum Themes">', '</a>', '<a href="http://wordpress.org" target="_blank">' ),
            // advanced settings
            'meta' => false,
            'author' => false,
            'generator' => false,
            'archive-excerpt' => true,
            'hovercards' => true,
            'favicon' => '',
            'css' => '',
            'site-title' => true,
            'post-author' => true
        );
        return $defaults;
    }
}

/**
 * Sidebar settings
 * @since 0.4.0
 * @author Chris Reynolds
 * this is the array for the sidebar setting
 */
if (!function_exists('ap_core_sidebar')) {
    function ap_core_sidebar() {
        $ap_core_sidebar = array(
            'left' => array(
                'value' => 'left',
                'label' => __('Left Sidebar','museum-core')),
            'right' => array(
                'value' => 'right',
                'label' => __('Right Sidebar','museum-core'))
        );
        return $ap_core_sidebar;
    }
}

/**
 * Font settings
 * @since 0.4.4
 * @author Chris Reynolds
 * this array handles the font selection
 */
if (!function_exists('ap_core_fonts')) {
    function ap_core_fonts() {
        $ap_core_fonts = array(
            'ptserif' => array(
                'value' => 'PT Serif',
                'label' => 'PT Serif',
                'link' => 'http://www.fontsquirrel.com/fonts/pt-serif'
            ),
            'inconsolata' => array(
                'value' => 'Inconsolata',
                'label' => 'Inconsolata',
                'link' => 'http://www.fontsquirrel.com/fonts/inconsolata'
            ),
            'droidsans' => array(
                'value' => 'Droid Sans',
                'label' => 'Droid Sans',
                'link' => 'http://www.fontsquirrel.com/fonts/droid-sans'
            ),
            'ubuntu' => array(
                'value' => 'Ubuntu',
                'label' => 'Ubuntu',
                'link' => 'http://www.fontsquirrel.com/fonts/ubuntu'
            ),
            'lato' => array(
                'value' => 'Lato',
                'label' => 'Lato',
                'link' => 'http://www.fontsquirrel.com/fonts/lato'
            )

        );
        return $ap_core_fonts;
    }
}

/**
 * Show excerpts
 * @since 0.5
 * @author Chris Reynolds
 * option to show excerpts or full posts
 */
if (!function_exists('ap_core_show_excerpts')) {
    function ap_core_show_excerpts() {
        $ap_core_show_excerpts = array(
            true => array(
                'value' => true,
                'label' => __('Show Post Excerpts','museum-core')
            ),
            false => array(
                'value' => false,
                'label' => __('Show Full Posts','museum-core')
            )
        );
        return $ap_core_show_excerpts;
    }
}

/**
 * True/False option
 * @since 1.0.2
 * @author Chris Reynolds
 * generic yes/no function used for true/false options
 */
if (!function_exists('ap_core_true_false')) {
    function ap_core_true_false() {
        $ap_core_true_false = array(
            true => array(
                'value' => true,
                'label' => __('Yes','museum-core')
            ),
            false => array(
                'value' => false,
                'label' => __('No','museum-core')
            )
        );
        return $ap_core_true_false;
    }
}

/**
 * Custom styles
 * @since 0.4.5
 * @author Chris Reynolds
 * this fetches the custom color options from the database and spits them out into the header
 */
if (!function_exists('ap_core_custom_styles')) {
    function ap_core_custom_styles() {
        $output = null;
        $output_heading = null;
        $output_alt = null;
        $output_body = null;
        $output_link = null;
        $output_hover = null;
        $heading = null;
        $body = null;
        $alt = null;
        $link = null;
        $hover = null;

        $defaults = ap_core_get_theme_defaults();
        $options = get_option( 'ap_core_theme_options' );
        // set the heading font
        if ( $options['heading'] != $defaults['heading'] ) {
            $heading = sanitize_text_field($options['heading']);
            $output_heading = "h1, h2, h3 { font-family: '$heading', sans-serif; }";
        }
        // set the body font
        if ( $options['body'] != $defaults['body'] ) {
            $body = sanitize_text_field($options['body']);
            $output_body = "body { font-family: '$body', sans-serif; }";
        }
        // set the alt font
        if ( $options['alt'] != $defaults['alt'] ) {
            $alt = sanitize_text_field($options['alt']);
            $output_alt = "h4, h5, h6, .alt, h3 time { font-family: '$alt', sans-serif; }";
        }
        // set the link color
        if ( $options['link'] && $options['link'] != $defaults['link'] ) {
            $link = sanitize_text_field($options['link']);
            $output_link = "a, a:link, a:visited { color: $link; text-decoration:none; -webkit-transition: all 0.3s ease!important; -moz-transition: all 0.3s ease!important; -o-transition: all 0.3s ease!important; transition: all  0.3s ease!important; }";
        }
        if ( $options['hover'] && $options['hover'] != $defaults['hover'] ) {
            $hover = sanitize_text_field($options['hover']);
            $output_hover = "a:hover, a:active { color: $hover; -webkit-transition: all 0.3s ease!important; -moz-transition: all 0.3s ease!important; -o-transition: all 0.3s ease!important; transition: all  0.3s ease!important; }";
        }
        $output = "<style type=\"text/css\" media=\"print,screen\">"; 
        $output .= $output_heading;
        $output .= $output_alt;
        $output .= $output_body;
        $output .= $output_link;
        $output .= $output_hover;

        if ( $options['site-title'] == false ) {
            $output .= ".headerimg hgroup h2, .headerimg hgroup h3 { float: left; position: absolute; left: -999em; height: 0px; }";
        }
        if ( !empty($options['css']) ) {
            $output .= sanitize_text_field($options['css']);
        }
        $output .= "</style>";
        if ( $heading || $body || $alt || $link || $hover || $options['site-title'] == false || $options['css'] ) {
            echo $output;
        }
    }
    add_action( 'wp_head', 'ap_core_custom_styles' );
}

/**
 * Header meta
 * @since 1.1.2
 * @author Chris Reynolds
 * serves up meta data if enabled
 */
if (!function_exists('ap_core_header_meta')) {
    function ap_core_header_meta() {
        global $post;
        $options = get_option( 'ap_core_theme_options' );

        /* meta description */
        if ($options['meta'] == true) {
            if ( is_tax() && term_description() ) {
                $term_description = term_description(); ?>
                <meta name="description" content="<?php echo sanitize_text_field($term_description); ?>">
            <?php } elseif ( is_category() && category_description() ) {
                $term_description = category_description(); ?>
                <meta name="description" content="<?php echo sanitize_text_field($term_description); ?>">
            <?php } elseif (( is_single() ) || ( is_page())) {
                $this_post = $post;
                $post_data = get_post($this_post);
                $post_excerpt = $post_data->post_excerpt;
                $trim_post_content = wp_trim_words( $post_data->post_content, 55 );
                if ( $post_excerpt ) {
                    $meta_description = $post_excerpt;
                } else {
                    $meta_description = $trim_post_content;
                } ?>
            <meta name="description" content="<?php echo sanitize_text_field($meta_description); ?>">
        <?php }
        }
        /* author meta */
        if ($options['author'] == true) {
            if (!is_404()) {
                // if there is no post author, this stuff doesn't exist
                $author_id = $post->post_author;
                $author = get_userdata($author_id);
            ?>
            <meta name="author" content="<?php echo sanitize_text_field($author->display_name); ?>">
            <?php }
        }
    }
    add_action( 'wp_head', 'ap_core_header_meta' );
}

/**
 * favicon
 * @since 1.1.2
 * @author Chris Reynolds
 * outputs the favicon if set in the options
 */
if (!function_exists('ap_core_favicon')) {
    function ap_core_favicon() {
        $options = get_option( 'ap_core_theme_options' );

        if ( isset($options['favicon']) ) {
            $favicon = esc_url($options['favicon']); ?>
            <link rel="Shortcut Icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
        <?php }
    }
    add_action( 'wp_head', 'ap_core_favicon' );
}

?>