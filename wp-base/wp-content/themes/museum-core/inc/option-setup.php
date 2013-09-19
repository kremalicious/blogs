<?php

/**
 * set up the tabs
 * @since 1.1
 * @author Chris Reynolds
 * @uses screen_icon
 * @uses jquery-ui-tabs
 * this sets up the tabs on the options page
 */
if (!function_exists('ap_core_tab_setup')) {
	function ap_core_tab_setup() {
		ob_start();
		?>
			<div class="tab-wrap">
				<ul class="nav-tab-wrapper">
					<li><?php screen_icon(); ?></li>
					<li><h2><a class="nav-tab" href="#tabs-1"><?php _e('General','museum-core'); ?></a></h2></li>
					<li><h2><a class="nav-tab" href="#tabs-2"><?php _e('Typography & Fonts','museum-core'); ?></a></h2></li>
					<li><h2><a class="nav-tab" href="#tabs-3"><?php _e('Advanced','museum-core'); ?></a></h2></li>
				</ul>
			</div>
		<?php
		$tabs = ob_get_contents();
		ob_end_clean();
		echo $tabs;
	}
}

/**
 * Sidebar settings
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_sidebar
 * adds the sidebar settings which is called in ap_core_do_theme_options
 */
if (!function_exists('ap_core_sidebar_option')) {
	function ap_core_sidebar_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Sidebar', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[sidebar]">
					<?php
						$selected = $options['sidebar'];
						foreach ( ap_core_sidebar() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						}
					?>
					</select>
				</td>
			</tr>
		<?php
		$sidebar = ob_get_contents();
		ob_end_clean();
		echo $sidebar;
	}
}

/**
 * Show full posts or excerpts
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_show_excerpts
 * adds the excerpts setting which is called in ap_core_do_theme_options
 */
if (!function_exists('ap_core_posts_excerpts_option')) {
	function ap_core_posts_excerpts_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Full posts or excerpts?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[excerpts]">
					<?php
						$selected = $options['excerpts'];
						foreach ( ap_core_show_excerpts() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[excerpts]"><?php _e( 'Select whether you want full posts on the blog page or post excerpts with post thumbnails.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$excerpts = ob_get_contents();
		ob_end_clean();
		echo $excerpts;
	}
}

/**
 * Footer text
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses wp_kses
 * adds the footer text which is called in ap_core_do_theme_options
 */
if (!function_exists('ap_core_footer_option')) {
	function ap_core_footer_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Footer Text', 'museum-core' ); ?></th>
				<td>
					<textarea id="ap_core_theme_options[footer]" class="large-text" cols="50" rows="10" name="ap_core_theme_options[footer]"><?php if ($options['footer'] != '') {
						echo wp_kses( $options['footer'], array('a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array() ) );
					} else {
						echo wp_kses( $defaults['footer'], array('a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array() ) );
					} ?></textarea>
					<label class="description" for="ap_core_theme_options[footer]"><?php _e( 'Add your own footer text or leave blank for no text in the footer.  Allowed HTML is <code>&lt;a&gt;</code>, <code>&lt;br&gt;</code>, <code>&lt;em&gt;</code> & <code>&lt;strong&gt;</code>', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$footer = ob_get_contents();
		ob_end_clean();
		echo $footer;
	}
}

/**
 * Presstrends setting
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_true_false
 * adds the Presstrends opt-in which is called in ap_core_do_theme_options
 */
if (!function_exists('ap_core_presstrends_option')) {
	function ap_core_presstrends_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Send usage data?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[presstrends]">
					<?php
						$selected = $options['presstrends'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[presstrends]"><?php _e( 'PressTrends allows theme developers to see how their themes are being used so they can better address the needs of their users. For more information visit <a href="http://presstrends.io/faq">PressTrends</a> or check out the <a href="http://wordpress.org/extend/plugins/presstrends/">plugin</a>.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$presstrends = ob_get_contents();
		ob_end_clean();
		echo $presstrends;
	}
}

/**
 * Display fonts
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_fonts
 * displays the available fonts
 */
if (!function_exists('ap_core_display_fonts')) {
	function ap_core_display_fonts() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Museum Core Fonts', 'museum-core' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e( 'Fonts', 'museum-core' ); ?></span></legend>
						<?php
							foreach ( ap_core_fonts() as $option ) {
								$label = $option['label'];
								$link = $option['link'];
								$value = $option['value']; ?>
								<label class="description"><span style="font-family: '<?php echo esc_attr($value); ?>'; font-size: 1.7em; padding-right: 20px;"><?php echo esc_attr($label); ?><span style="font-size: 10px; font-family: sans-serif;"> <a href="<?php echo esc_attr($link); ?>" target="_blank"><?php _e('[link]','museum-core'); ?></a></span></span></label>
							<?php } ?>
					</fieldset>
				</td>
			</tr>
		<?php
		$fonts = ob_get_contents();
		ob_end_clean();
		echo $fonts;
	}
}

/**
 * Headings font
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_fonts
 * adds the heading font option
 */
if (!function_exists('ap_core_heading_option')) {
	function ap_core_heading_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Headings Font', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[heading]">
					<?php
						$selected = $options['heading'];
						foreach ( ap_core_fonts() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[heading]"><?php _e( 'Used for <code>&lt;h1&gt;</code>, <code>&lt;h2&gt;</code>, and <code>&lt;h3&gt;</code> tags.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$heading = ob_get_contents();
		ob_end_clean();
		echo $heading;
	}
}

/**
 * Body font
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_fonts
 * adds the body font option
 */
if (!function_exists('ap_core_body_option')) {
	function ap_core_body_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Body Font', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[body]">
					<?php
						$selected = $options['body'];
						foreach ( ap_core_fonts() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[body]"><?php _e( 'Used for all body text.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$body = ob_get_contents();
		ob_end_clean();
		echo $body;
	}
}

/**
 * alternate font options
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_fonts
 * @uses ap_core_true_false
 * adds alt font options. displays both the alt font selection and the true/false option to set alt font as the H1
 */
if (!function_exists('ap_core_alt_option')) {
	function ap_core_alt_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Alternate Font', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[alt]">
					<?php
						$selected = $options['alt'];
						foreach ( ap_core_fonts() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[alt]"><?php _e( 'Used for dates, sub-headings, <code>&lt;h4&gt;</code>, <code>&lt;h5&gt;</code> and <code>&lt;h6&gt;</code> tags and anywhere the <code>.alt</code> class is used in a <code>&lt;span&gt;</code> or a <code>&lt;div&gt;</code>.', 'museum-core' ); ?></label>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Use alternate font for H1?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[alth1]">
					<?php
						$selected = $options['alth1'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[alth1]"><?php _e( 'If set to "Yes", the alternate font will be used on the <code>&lt;h1&gt;</code> tag in the header and the heading font will be used for the description.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$alt = ob_get_contents();
		ob_end_clean();
		echo $alt;
	}
}

/**
 * Link colors
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses farbtastic
 * @uses ap_core_color_picker
 * adds color pickers for link colors. adds both the regular link color and the hover color because it's pretty useless to have one without the other.
 */
if (!function_exists('ap_core_link_options')) {
	function ap_core_link_options() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'museum-core' ); ?></th>
				<td><?php if ( !isset($options['link']) ) { $options['link'] == $defaults['link']; } ?>
					<input class="medium-text" type="text" name="ap_core_theme_options[link]" value="<?php echo esc_attr($options['link']); ?>" onfocus="if (this.value == '#'){this.value = '#';} if (this.value == ''){this.value='#';}" onblur="if (this.value == '') {this.value = '#';}" id="link-color" />
					<div id="colorpicker-link"></div>
					<br /><label class="description" for="ap_core_theme_options[link]"><?php _e( 'Set your desired link color.', 'museum-core' ); ?></label>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Hover Color', 'museum-core' ); ?></th>
				<td><?php if ( !isset($options['hover']) ) { $options['hover'] == $defaults['hover']; } ?>
					<input class="medium-text" type="text" name="ap_core_theme_options[hover]" value="<?php echo esc_attr($options['hover']); ?>" onfocus="if (this.value == '#'){this.value = '#';} if (this.value == ''){this.value='#';}" onblur="if (this.value == '') {this.value = '#';}" id="hover-color" />
					<div id="colorpicker-hover"></div>
					<br /><label class="description" for="ap_core_theme_options[hover]"><?php _e( 'Set your desired link hover color.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$link = ob_get_contents();
		ob_end_clean();
		echo $link;
	}
}

/**
 * Favicon
 * @since 1.1
 * @author Chris Reynolds
 * @uses get_option
 * @uses thickbox
 * @uses media-upload
 * @uses ap_core_uploader
 */
if (!function_exists('ap_core_favicon_option')) {
	function ap_core_favicon_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Custom favicon', 'museum-core' ); ?></th>
				<td>
					<input id="upload_image" type="text" size="36" name="ap_core_theme_options[favicon]" value="<?php echo esc_attr($options['favicon']); ?>" />
					<input id="upload_image_button" type="button" class="button" value="<?php esc_attr_e('Upload Image','museum-core'); ?>" />
					<br />
					<label class="description" for="ap_core_theme_options[favicon]"><?php _e( 'Use the uploader to upload a PNG or ICO file to use as a favicon for your site.  If left blank, no favicon will be used. (Other image formats will work but may not be browser-supported.)', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$favicon = ob_get_contents();
		ob_end_clean();
		echo $favicon;
	}
}

/**
 * HTML meta
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_true_false
 * adds options to add meta content to the header.  dumping all this stuff together because it's related.
 */
if (!function_exists('ap_core_meta_options')) {
	function ap_core_meta_options() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Use meta description?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[meta]">
					<?php
						$selected = $options['meta'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[meta]"><?php _e( 'If Yes, meta tags for description will be loaded in the header (pulled from post excerpt for single posts and pages or from the description for tags and categories).  Use this if you don\'t plan on using an SEO plugin to handle your meta descriptions.','museum-core'); ?><br /><?php _e( 'If No, no meta description tags will be loaded.  Use this if you plan on using something to take care of your meta description.', 'museum-core' ); ?>  <a href="http://yoast.com/meta-description-seo-social/" target="_blank"><?php _e('More info','museum-core'); ?></label>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Use meta author?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[author]">
					<?php
						$selected = $options['author'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[author]"><?php _e( 'If Yes, meta author tags will be used on all pages (except 404 pages).','museum-core'); ?><br /><?php _e( 'If No, meta author tags will be disabled.', 'museum-core' ); ?></label>
				</td>
			</tr>
			<tr valign="top"><th scope="row"><?php _e( 'Use meta generator tag?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[generator]">
					<?php
						$selected = $options['generator'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[generator]"><?php _e( 'If Yes, the theme name and version will be added to a meta generator tag.  This is useful in identifying which version of the theme you are using for troubleshooting purposes.  This should be enabled if you need to contact us for support.','museum-core'); ?></label>
				</td>
			</tr>
		<?php
		$meta = ob_get_contents();
		ob_end_clean();
		echo $meta;
	}
}

/**
 * Archive excerpts
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_show_excerpts
 * adds an option to display full posts or excerpts on archive pages
 */
if (!function_exists('ap_core_archive_excerpts_option')) {
	function ap_core_archive_excerpts_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Full posts or excerpts on archive pages?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[archive-excerpt]">
					<?php
						$selected = $options['archive-excerpt'];
						foreach ( ap_core_show_excerpts() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[archive-excerpt]"><?php _e( 'Select whether you want full posts on archive pages or excerpts with post thumbnails.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$archive = ob_get_contents();
		ob_end_clean();
		echo $archive;
	}
}

/**
 * Twitter Hovercards
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_true_false
 * adds an option to display or hide Twitter hovercards
 */
if (!function_exists('ap_core_hovercards_option')) {
	function ap_core_hovercards_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Use Twitter hovercards?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[hovercards]">
					<?php
						$selected = $options['hovercards'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[hovercards]"><?php echo sprintf( __( 'Twitter hovercards display information about a particular Twitter user when the @ symbol is used.  See the %1$sTwitter developer documentation for more information%2$s', 'museum-core' ), '<a href="https://dev.twitter.com/docs/anywhere/welcome#hovercards" target="_blank">', '</a>' ); ?>
				</td>
			</tr>
		<?php
		$hovercards = ob_get_contents();
		ob_end_clean();
		echo $hovercards;
	}
}

/**
 * Custom CSS
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses wp_kses
 * adds a textarea for users to enter their own custom css
 */
if (!function_exists('ap_core_css_option')) {
	function ap_core_css_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Custom CSS', 'museum-core' ); ?></th>
				<td>
					<?php
						$css_basetext = '/* ' . __( 'add your custom css here', 'museum-core' ) . ' */';
					?>
					<textarea id="ap_core_theme_options[css]" class="large-text" cols="50" rows="10" name="ap_core_theme_options[css]" onfocus="if (this.value == '<?php echo esc_attr($css_basetext); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo esc_attr($css_basetext); ?>';}"><?php if ($options['css'] != '') {
						echo wp_kses( $options['css'], array() );
					} else {
						echo esc_attr($css_basetext);
					} ?></textarea>
					<label class="description" for="ap_core_theme_options[css]"><?php _e( 'Add custom CSS overrides to your theme.  Intended for advanced users with a good working knowledge of <abbr title="Cascading Style Sheets">CSS</abbr>.', 'museum-core' ); ?></label>
				</td>
			</tr>
		<?php
		$css = ob_get_contents();
		ob_end_clean();
		echo $css;
	}
}

/**
 * Hide site title
 * @since 1.1.1
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_true_false
 * adds an option to hide the site title
 */
if (!function_exists('ap_core_hide_site_title_option')) {
	function ap_core_hide_site_title_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Display site title?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[site-title]">
					<?php
						$selected = $options['site-title'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[site-title]"><?php _e( 'Set to "No" to hide the site title and tagline.  Use this if you would rather display the header image with no site title.', 'museum-core' ); ?>
				</td>
			</tr>
		<?php
		$hovercards = ob_get_contents();
		ob_end_clean();
		echo $hovercards;
	}
}

/**
 * Show post author
 * @since 1.1.3
 * @author Chris Reynolds
 * @uses ap_core_get_theme_defaults
 * @uses get_option
 * @uses ap_core_true_false
 * adds an option to hide the site title
 */
if (!function_exists('ap_core_show_author_option')) {
	function ap_core_show_author_option() {
		$defaults = ap_core_get_theme_defaults();
		$options = get_option( 'ap_core_theme_options', $defaults );

		ob_start();
		?>
			<tr valign="top"><th scope="row"><?php _e( 'Display post author?', 'museum-core' ); ?></th>
				<td>
					<select name="ap_core_theme_options[post-author]">
					<?php
						$selected = $options['post-author'];
						foreach ( ap_core_true_false() as $option ) {
							$label = $option['label'];
							$value = $option['value'];
							echo '<option value="' . esc_attr($value) . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
						} ?>
					</select><br />
					<label class="description" for="ap_core_theme_options[post-author]"><?php _e( 'If this is set to "Yes", the post author will be displayed in the post meta and link to an author archive page.', 'museum-core' ); ?>
				</td>
			</tr>
		<?php
		$hovercards = ob_get_contents();
		ob_end_clean();
		echo $hovercards;
	}
}

/**
 * General settings
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_sidebar_option
 * @uses ap_core_posts_excerpts_option
 * @uses ap_core_footer_option
 * @uses ap_core_presstrends_option
 * loads the options that appear on the General tab
 */
if (!function_exists('ap_core_general_settings')) {
	function ap_core_general_settings() {
		$options_before = '<table class="form-table" id="tabs-1">';
		$options_after = '</table>';

		echo $options_before;
		ap_core_sidebar_option();
		ap_core_posts_excerpts_option();
		ap_core_footer_option();
		ap_core_presstrends_option();
		echo $options_after;
	}
}

/**
 * Typography settings
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_display_fonts
 * @uses ap_core_heading_option
 * @uses ap_core_body_option
 * @uses ap_core_alt_option
 * @uses ap_core_link_options
 * loads the options that appear on the Typgraphy & Fonts tab
 */
if (!function_exists('ap_core_typography_settings')) {
	function ap_core_typography_settings() {
		$options_before = '<table class="form-table" id="tabs-2">';
		$options_after = '</table>';

		echo $options_before;
		ap_core_display_fonts();
		ap_core_heading_option();
		ap_core_body_option();
		ap_core_alt_option();
		ap_core_link_options();
		echo $options_after;
	}
}

/**
 * Advanced settings
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_favicon_option
 * @uses ap_core_meta_options
 * @uses ap_core_archive_excerpts_option
 * @uses ap_core_hovercards_option
 * @uses ap_core_css_option
 * @uses ap_core_hide_site_title_option
 * loads the options that appear on the Advanced tab
 */
if (!function_exists('ap_core_advanced_settings')) {
	function ap_core_advanced_settings() {
		$options_before = '<table class="form-table" id="tabs-3">';
		$options_after = '</table>';

		echo $options_before;
		ap_core_favicon_option();
		ap_core_hide_site_title_option();
		ap_core_show_author_option();
		ap_core_meta_options();
		ap_core_archive_excerpts_option();
		ap_core_hovercards_option();
		ap_core_css_option();
		echo $options_after;
	}
}

/**
 * Do theme option stuff
 * @since 1.1
 * @author Chris Reynolds
 * @uses ap_core_tab_setup
 * @uses ap_core_general_settings
 * @uses ap_core_typography_settings
 * @uses ap_core_advanced_settings
 * this  makes it easier to use each individual setting modularly, which will make it easier to develop child themes that use *some* of the settings from the parent theme, but not others
 */
if (!function_exists('ap_core_do_theme_options')) {
	function ap_core_do_theme_options() {
		ap_core_tab_setup();
		ap_core_general_settings();
		ap_core_typography_settings();
		ap_core_advanced_settings();
	}
}
?>