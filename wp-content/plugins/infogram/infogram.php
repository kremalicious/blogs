<?php
/*
  Plugin Name: Infogr.am
  Plugin URI: https://blog.infogr.am/new-infogram-wordpress-plugin/
  Description: It allows you to insert graphics from the site infogr.am
  Version: 1.4.4
  Text Domain: infogram
  Tags: infogram, shortcode, iframe, insert, rest api, json
*/

// Add setings page and register settings
add_action('admin_menu', 'infogr_add_pages');
add_action('wp_ajax_infogram_dialog', 'infogr_ajax_dialog');

function infogr_ajax_dialog() {
  global $infogram;
  ($infogram->check_is_valid()) ? infogr_add_media_popup() : infogr_message_popup();

  wp_die();
}

function infogr_add_pages() {
  //create new top-level menu
  add_options_page('Infogr.am v1.4.4', 'Infogr.am settings', 'level_0', 'infogram', 'infogr_page');

  //call register settings function
  add_action('admin_init', 'register_infogr_settings');
}

function register_infogr_settings() {
  //register our settings
  register_setting('my-infogr-settings', 'infogr_api_key');
  register_setting('my-infogr-settings', 'infogr_api_secret');
  register_setting('my-infogr-settings', 'infogr_username');
}

function infogr_page() {
  global $infogram;
?>
  <div class="wrap">
    <h2>Infogram</h2>
    <?php $infogram->plugin_status(); ?>
    <form method="post" action="options.php">
      <?php settings_fields('my-infogr-settings'); ?>
      <?php do_settings_sections('my-infogr-settings'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><?php _e('Your Api key:', 'infogram'); ?></th>
          <td><input type="text" name="infogr_api_key" size="40" value="<?php echo esc_attr( get_option('infogr_api_key') ); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><?php _e('Your Api secret:', 'infogram'); ?></th>
          <td><input type="text" name="infogr_api_secret" size="40" value="<?php echo esc_attr( get_option('infogr_api_secret') ); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><?php _e('User name:', 'infogram'); ?></th>
          <td><input type="text" name="infogr_username" value="<?php echo esc_attr( get_option('infogr_username') ); ?>" /></td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}

function infogr_create_object() {
  // Load Api config file
  require_once('core/autoload.php');
  // Load main Infogram class
  require_once('class/class-infogram.php');
  // Load media button function
  require_once('button/add_button.php');

  global $infogram;

  $options = array(
    'api_key' => get_option('infogr_api_key'),
    'api_secret' => get_option('infogr_api_secret'),
    'username' => get_option('infogr_username')
  );

  if ( !$infogram ) {
    $infogram = new Infogram($options);
  }
}

// out infographic
function infogr_add_infographics($atts) {
  $atts = shortcode_atts(array(
    'id' => '',
    'prefix' => '',
    'format' => ''
  ), $atts, 'id');

  if($atts['id']) {
    if($atts['format'] && $atts['format'] == 'image') {
      return '<script>!function(e,t,i,n,r,d){function o(e,i,n,r){t[s].list.push({id:e,title:r,container:i,type:n})}var a="script",s="InfogramEmbeds",c=e.getElementsByTagName(a),l=c[0];if(/^\/{2}/.test(i)&&0===t.location.protocol.indexOf("file")&&(i="http:"+i),!t[s]){t[s]={script:i,list:[]};var m=e.createElement(a);m.async=1,m.src=i,l.parentNode.insertBefore(m,l)}t[s].add=o;var p=c[c.length-1],f=e.createElement("div");p.parentNode.insertBefore(f,p),t[s].add(n,f,r,d)}(document,window,"//e.infogr.am/js/dist/embed-loader-min.js","'.$atts['id'].'","image","");</script>';
    } else {
      return '<script>!function(e,t,i,n,r,d){function o(e,i,n,r){t[s].list.push({id:e,title:r,container:i,type:n})}var a="script",s="InfogramEmbeds",c=e.getElementsByTagName(a),l=c[0];if(/^\/{2}/.test(i)&&0===t.location.protocol.indexOf("file")&&(i="http:"+i),!t[s]){t[s]={script:i,list:[]};var m=e.createElement(a);m.async=1,m.src=i,l.parentNode.insertBefore(m,l)}t[s].add=o;var p=c[c.length-1],f=e.createElement("div");p.parentNode.insertBefore(f,p),t[s].add(n,f,r,d)}(document,window,"//e.infogr.am/js/dist/embed-loader-min.js","'.$atts['id'].'","interactive","");</script>';
    }
  } else {
    return 'This code is broken or not exists!';
  }
}

add_shortcode('infogram', 'infogr_add_infographics');

// Global Infogram activation hook
function infogr_handle_activation() {}

// Global Infogram deactivation hook
function infogr_handle_deactivation() {}

// Activation hooks for some basic initialization
register_activation_hook(__FILE__, 'infogr_handle_activation');
register_deactivation_hook(__FILE__, 'infogr_handle_deactivation');

// Main Infogram activation hook
if ( is_admin() ) {
  add_action('plugins_loaded', 'infogr_create_object');
};
