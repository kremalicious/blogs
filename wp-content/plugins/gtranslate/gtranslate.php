<?php
/*
Plugin Name: GTranslate
Plugin URI: http://gtranslate.net/?xyz=998
Description: Makes your website <strong>multilingual</strong> and available to the world using Google Translate. For support visit <a href="http://gtranslate.net/forum/">GTranslate Forum</a>.
Version: 2.0.5
Author: Edvard Ananyan
Author URI: http://gtranslate.net

*/

/*  Copyright 2010 - 2015 Edvard Ananyan  (email : edo888@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('widgets_init', array('GTranslate', 'register'));
register_activation_hook(__FILE__, array('GTranslate', 'activate'));
register_deactivation_hook(__FILE__, array('GTranslate', 'deactivate'));
add_action('admin_menu', array('GTranslate', 'admin_menu'));
add_action('init', array('GTranslate', 'enqueue_scripts'));
add_shortcode('GTranslate', array('GTranslate', 'get_widget_code'));
add_shortcode('gtranslate', array('GTranslate', 'get_widget_code'));

if(is_admin()) {
    global $pagenow;
    if('plugins.php' === $pagenow) {
        add_action('in_plugin_update_message-' . basename(dirname( __FILE__ )) . '/' . basename(__FILE__), array('GTranslate', 'update_message'), 20, 2);
    }
}

class GTranslate extends WP_Widget {
    function activate() {
        $data = array(
            'gtranslate_title' => 'Website Translator',
        );
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        add_option('GTranslate', $data);
    }

    function deactivate() {
        // delete_option('GTranslate');
    }

    function update_message($plugin_data, $r) {
        return print '<div style="color:#f33;">It is highly recommended to update to the latest version! <img src="//gtranslate.net/wp-logo.png" style="height:13px;vertical-align:middle;" border="0" title="GTranslate - your window to the world" alt="GTranslate"></div>';
    }

    function control() {
        $data = get_option('GTranslate');
        ?>
        <p><label>Title: <input name="gtranslate_title" type="text" class="widefat" value="<?php echo $data['gtranslate_title']; ?>"/></label></p>
        <p>Please go to Settings -> GTranslate for configuration.</p>
        <?php
        if (isset($_POST['gtranslate_title'])){
            $data['gtranslate_title'] = attribute_escape($_POST['gtranslate_title']);
            update_option('GTranslate', $data);
        }
    }

    function enqueue_scripts() {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);
        $wp_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );

        wp_enqueue_style('gtranslate-style', $wp_plugin_url.'/gtranslate-style'.$data['flag_size'].'.css');
        wp_enqueue_script('jquery');
    }

    function widget($args) {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];
        if(empty($data['widget_code']))
            echo '<b>Notice:</b> Please configure GTranslate from WP-Admin -> Settings -> GTranslate to see it in action.';
        else
            echo $data['widget_code'];
        echo $args['after_widget'];
    }

    function get_widget_code($atts) {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        if(empty($data['widget_code']))
            return '<b>Notice:</b> Please configure GTranslate from WP-Admin -> Settings -> GTranslate to see it in action.';
        else
            return $data['widget_code'];
    }

    function register() {
        wp_register_sidebar_widget('gtranslate', 'GTranslate', array('GTranslate', 'widget'), array('description' => __('Google Automatic Translations')));
        wp_register_widget_control('gtranslate', 'GTranslate', array('GTranslate', 'control'));
    }

    function admin_menu() {
        add_options_page('GTranslate Options', 'GTranslate', 'administrator', 'gtranslate_options', array('GTranslate', 'options'));
    }

    function options() {
        ?>
        <div class="wrap">
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><img src="//gtranslate.net/wp-logo.png" border="0" title="GTranslate - your window to the world" alt="GTranslate"></h2>
        <?php
        if($_POST['save'])
            GTranslate::control_options();
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        $site_url = site_url();
        $wp_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );

        extract($data);

        #unset($data['widget_code']);
        #echo '<pre>', print_r($data, true), '</pre>';

$script = <<<EOT

var languages = ['Afrikaans','Albanian','Arabic','Armenian','Aurebesh','Azerbaijani','Basque','Belarusian','Bengali','Bosnian','Bulgarian','Burmese','Catalan','Cebuano','Chichewa','Chinese (Simplified)','Chinese (Traditional)','Croatian','Czech','Danish','Dutch','English','Esperanto','Estonian','Filipino','Finnish','French','Galician','Georgian','German','Greek','Gujarati','Haitian Creole','Hausa','Hebrew','Hindi','Hmong','Hungarian','Icelandic','Igbo','Indonesian','Irish','Italian','Japanese','Javanese','Kannada','Kazakh','Khmer','Korean','Lao','Latin','Latvian','Lithuanian','Macedonian','Malagasy','Malay','Malayalam','Maltese','Maori','Marathi','Mongolian','Nepali','Norwegian','Persian','Polish','Portuguese','Punjabi','Romanian','Russian','Serbian','Sesotho','Sinhalese','Slovak','Slovenian','Somali','Spanish','Sundanese','Swahili','Swedish','Tajik','Tamil','Telugu','Thai','Turkish','Ukrainian','Urdu','Uzbek','Vietnamese','Welsh','Yiddish','Yoruba','Zulu'];
var language_codes = ['af','sq','ar','hy','qab','az','eu','be','bn','bs','bg','my','ca','ceb','ny','zh-CN','zh-TW','hr','cs','da','nl','en','eo','et','tl','fi','fr','gl','ka','de','el','gu','ht','ha','iw','hi','hmn','hu','is','ig','id','ga','it','ja','jw','kn','kk','km','ko','lo','la','lv','lt','mk','mg','ms','ml','mt','mi','mr','mn','ne','no','fa','pl','pt','pa','ro','ru','sr','st','si','sk','sl','so','es','su','sw','sv','tg','ta','te','th','tr','uk','ur','uz','vi','cy','yi','yo','zu'];
var languages_map = {en_x: 0, en_y: 0, ar_x: 100, ar_y: 0, bg_x: 200, bg_y: 0, zhCN_x: 300, zhCN_y: 0, zhTW_x: 400, zhTW_y: 0, hr_x: 500, hr_y: 0, cs_x: 600, cs_y: 0, da_x: 700, da_y: 0, nl_x: 0, nl_y: 100, fi_x: 100, fi_y: 100, fr_x: 200, fr_y: 100, de_x: 300, de_y: 100, el_x: 400, el_y: 100, hi_x: 500, hi_y: 100, it_x: 600, it_y: 100, ja_x: 700, ja_y: 100, ko_x: 0, ko_y: 200, no_x: 100, no_y: 200, pl_x: 200, pl_y: 200, pt_x: 300, pt_y: 200, ro_x: 400, ro_y: 200, ru_x: 500, ru_y: 200, es_x: 600, es_y: 200, sv_x: 700, sv_y: 200, ca_x: 0, ca_y: 300, tl_x: 100, tl_y: 300, iw_x: 200, iw_y: 300, id_x: 300, id_y: 300, lv_x: 400, lv_y: 300, lt_x: 500, lt_y: 300, sr_x: 600, sr_y: 300, sk_x: 700, sk_y: 300, sl_x: 0, sl_y: 400, uk_x: 100, uk_y: 400, vi_x: 200, vi_y: 400, sq_x: 300, sq_y: 400, et_x: 400, et_y: 400, gl_x: 500, gl_y: 400, hu_x: 600, hu_y: 400, mt_x: 700, mt_y: 400, th_x: 0, th_y: 500, tr_x: 100, tr_y: 500, fa_x: 200, fa_y: 500, af_x: 300, af_y: 500, ms_x: 400, ms_y: 500, sw_x: 500, sw_y: 500, ga_x: 600, ga_y: 500, cy_x: 700, cy_y: 500, be_x: 0, be_y: 600, is_x: 100, is_y: 600, mk_x: 200, mk_y: 600, yi_x: 300, yi_y: 600, hy_x: 400, hy_y: 600, az_x: 500, az_y: 600, eu_x: 600, eu_y: 600, ka_x: 700, ka_y: 600, ht_x: 0, ht_y: 700, ur_x: 100, ur_y: 700};

function RefreshDoWidgetCode() {
    var new_line = "\\n";
    var widget_preview = '<!-- GTranslate: http://gtranslate.net/ -->'+new_line;
    var widget_code = '';
    var translation_method = 'onfly'; //jQuery('#translation_method').val();
    var widget_look = jQuery('#widget_look').val();
    var default_language = jQuery('#default_language').val();
    var flag_size = jQuery('#flag_size').val();
    var pro_version = jQuery('#pro_version:checked').length > 0 ? true : false;
    var enterprise_version = jQuery('#enterprise_version:checked').length > 0 ? true : false;
    var new_window = jQuery('#new_window:checked').length > 0 ? true : false;
    var analytics = jQuery('#analytics:checked').length > 0 ? true : false;

    if(pro_version || enterprise_version) {
        translation_method = 'redirect';
        jQuery('#new_window_option').show();
    } else {
        jQuery('#new_window_option').hide();
    }

    if(widget_look == 'dropdown' || widget_look == 'flags_dropdown') {
        jQuery('#dropdown_languages_option').show();
    } else {
        jQuery('#dropdown_languages_option').hide();
    }

    if(widget_look == 'flags' || widget_look == 'flags_dropdown' || widget_look == 'dropdown_with_flags') {
        jQuery('#flag_languages_option').show();
    } else {
        jQuery('#flag_languages_option').hide();
    }

    if(widget_look == 'flags' || widget_look == 'dropdown' || widget_look == 'dropdown_with_flags') {
        jQuery('#line_break_option').hide();
    } else {
        jQuery('#line_break_option').show();
    }

    if(widget_look == 'dropdown_with_flags' || widget_look == 'dropdown') {
        jQuery('#flag_size_option').hide();
    } else {
        jQuery('#flag_size_option').show();
    }

    if(pro_version && enterprise_version)
        pro_version = false;

    if(translation_method == 'google_default') {
        included_languages = '';
        jQuery.each(languages, function(i, val) {
            lang = language_codes[i];
            if(jQuery('#incl_langs'+lang+':checked').length) {
                lang_name = val;
                included_languages += ','+lang;
            }
        });

        widget_preview += '<div id="google_translate_element"></div>'+new_line;
        widget_preview += '<script type="text/javascript">'+new_line;
        widget_preview += 'function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: \'';
        widget_preview += default_language;
        widget_preview += '\', layout: google.translate.TranslateElement.InlineLayout.SIMPLE';
        widget_preview += ', autoDisplay: false';
        widget_preview += ', includedLanguages: \'';
        widget_preview += included_languages;
        widget_preview += "'}, 'google_translate_element');}"+new_line;
        widget_preview += '<\/script>';
        widget_preview += '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"><\/script>'+new_line;
    } else if(translation_method == 'on_fly' || translation_method == 'redirect' || translation_method == 'onfly') {
        // Adding flags
        if(widget_look == 'flags' || widget_look == 'flags_dropdown' /* jQuery('#show_flags:checked').length */) {
            //console.log('adding flags');
            jQuery.each(languages, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#fincl_langs'+lang+':checked').length) {
                    lang_name = val;
                    flag_x = languages_map[lang.replace('-', '')+'_x'];
                    flag_y = languages_map[lang.replace('-', '')+'_y'];

                    var href = '#';
                    if(pro_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(0, 3).join('/'), '$site_url'.split('/').slice(0, 3).join('/')+'/'+lang);
                    else if(enterprise_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(2, 3)[0].replace('www.', ''), lang + '.' + '$site_url'.split('/').slice(2, 3)[0].replace('www.', '')).replace('://www.', '://');

                    widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');return false;" title="'+lang_name+'" class="gflag nturl" style="background-position:-'+flag_x+'px -'+flag_y+'px;"><img src="{$site_url}/wp-content/plugins/gtranslate/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                }
            });
        }

        // Adding dropdown
        if(widget_look == 'dropdown' || widget_look == 'flags_dropdown' /* jQuery('#show_dropdown:checked').length */) {
            //console.log('adding dropdown');
            if(/* jQuery('#show_flags:checked').length*/ (widget_look == 'flags' || widget_look == 'flags_dropdown') && jQuery('#add_new_line:checked').length)
                widget_preview += '<br />';
            else
                widget_preview += ' ';
            widget_preview += '<select onchange="doGTranslate(this);">';
            widget_preview += '<option value="">Select Language</option>';
            jQuery.each(languages, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#incl_langs'+lang+':checked').length) {
                    lang_name = val;
                    widget_preview += '<option value="'+default_language+'|'+lang+'">'+lang_name+'</option>';
                }
            });
            widget_preview += '</select>';
        }

        // Adding onfly html and css
        if(translation_method == 'onfly') {
            //console.log('adding onfly html, css and javascript');

            widget_code += '<style type="text/css">'+new_line;
            widget_code += '<!--'+new_line;
            widget_code += "#goog-gt-tt {display:none !important;}"+new_line;
            widget_code += ".goog-te-banner-frame {display:none !important;}"+new_line;
            widget_code += ".goog-te-menu-value:hover {text-decoration:none !important;}"+new_line;
            widget_code += "body {top:0 !important;}"+new_line;
            widget_code += "#google_translate_element2 {display:none!important;}"+new_line;
            widget_code += '-->'+new_line;
            widget_code += '</style>'+new_line+new_line;
            widget_code += '<div id="google_translate_element2"></div>'+new_line;
            widget_code += '<script type="text/javascript">'+new_line;
            widget_code += 'function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: \'';
            widget_code += default_language;
            widget_code += '\',autoDisplay: false';
            widget_code += "}, 'google_translate_element2');}"+new_line;
            widget_code += '<\/script>';
            widget_code += '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"><\/script>'+new_line;
        }

        if(widget_look == 'dropdown_with_flags') {
            // Adding slider html
            widget_preview += '<div class="switcher notranslate">'+new_line;
            widget_preview += '<div class="selected">'+new_line;
            widget_preview += '<a href="#" onclick="return false;"><span class="gflag" style="background-position:-'+languages_map[default_language.replace('-', '')+'_x']+'px -'+languages_map[default_language.replace('-', '')+'_y']+'px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+default_language+'" /></span>'+languages[language_codes.indexOf(default_language)]+'</a>'+new_line;
            widget_preview += '</div>'+new_line;
            widget_preview += '<div class="option">'+new_line;
            jQuery.each(languages, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#fincl_langs'+lang+':checked').length) {
                    lang_name = val;
                    flag_x = languages_map[lang.replace('-', '')+'_x'];
                    flag_y = languages_map[lang.replace('-', '')+'_y'];

                    var href = '#';
                    if(pro_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(0, 3).join('/'), '$site_url'.split('/').slice(0, 3).join('/')+'/'+lang);
                    else if(enterprise_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(2, 3)[0].replace('www.', ''), lang + '.' + '$site_url'.split('/').slice(2, 3)[0].replace('www.', '')).replace('://www.', '://');

                    widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');jQuery(this).parent().parent().find(\'div.selected a\').html(jQuery(this).html());return false;" title="'+lang_name+'" class="nturl'+(default_language == lang ? ' selected' : '')+'"><span class="gflag" style="background-position:-'+flag_x+'px -'+flag_y+'px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+lang+'" /></span>'+lang_name+'</a>';
                }
            });

            widget_preview += '</div>'+new_line;
            widget_preview += '</div>'+new_line;

            // Adding slider javascript
            widget_preview += '<script type="text/javascript">'+new_line;
            widget_preview += "jQuery('.switcher .selected').click(function() {if(!(jQuery('.switcher .option').is(':visible'))) {jQuery('.switcher .option').stop(true,true).delay(50).slideDown(800);}});"+new_line;
            widget_preview += "jQuery('body').not('.switcher .selected').mousedown(function() {if(jQuery('.switcher .option').is(':visible')) {jQuery('.switcher .option').stop(true,true).delay(300).slideUp(800);}});"+new_line;
            widget_preview += '<\/script>'+new_line;

            // Adding slider css
            widget_preview += '<style type="text/css">'+new_line;
            widget_preview += '<!--'+new_line;
            widget_preview += 'span.gflag {font-size:16px;padding:1px 0;background-repeat:no-repeat;background-image:url($wp_plugin_url/16.png);}'+new_line;
            widget_preview += 'span.gflag img {border:0;margin-top:2px;}'+new_line;
            widget_preview += '.switcher {font-family:Arial;font-size:10pt;text-align:left;cursor:pointer;overflow:hidden;width:163px;line-height:16px;}'+new_line;
            widget_preview += '.switcher a {text-decoration:none;display:block;font-size:10pt;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;}'+new_line;
            widget_preview += '.switcher a span.gflag {margin-right:3px;padding:0;display:block;float:left;}'+new_line;
            widget_preview += '.switcher .selected {background:#FFFFFF url($wp_plugin_url/switcher.png) repeat-x;position:relative;z-index:9999;}'+new_line;
            widget_preview += '.switcher .selected a {border:1px solid #CCCCCC;background:url($wp_plugin_url/arrow_down.png) 146px center no-repeat;color:#666666;padding:3px 5px;width:151px;}'+new_line;
            widget_preview += '.switcher .selected a:hover {background:#F0F0F0 url($wp_plugin_url/arrow_down.png) 146px center no-repeat;}'+new_line;
            widget_preview += '.switcher .option {position:relative;z-index:9998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;background-color:#EEEEEE;display:none;width:161px;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;}'+new_line;
            widget_preview += '.switcher .option a {color:#000;padding:3px 5px;}'+new_line;
            widget_preview += '.switcher .option a:hover {background:#FFC;}'+new_line;
            widget_preview += '.switcher .option a.selected {background:#FFC;}'+new_line;
            widget_preview += '#selected_lang_name {float: none;}'+new_line;
            widget_preview += '.l_name {float: none !important;margin: 0;}'+new_line;
            widget_preview += '-->'+new_line;
            widget_preview += '</style>'+new_line+new_line;
        }

        // Adding javascript
        //console.log('adding doGTranslate javascript');

        widget_code += new_line+new_line;
        widget_code += '<script type="text/javascript">'+new_line;
        widget_code += '/* <![CDATA[ */'+new_line;
        if(pro_version && translation_method == 'redirect' && new_window) {
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')openTab(location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search);else openTab(location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search);}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')openTab(location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search);else openTab(location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search);}"+new_line;
        } else if(pro_version && translation_method == 'redirect') {
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;}"+new_line;
        } else if(enterprise_version && translation_method == 'redirect' && new_window) {
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'doGTranslate', lang, location.hostname+location.pathname+location.search]);var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';openTab(location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search);}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';openTab(location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search);}"+new_line;
        } else if(enterprise_version && translation_method == 'redirect') {
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'doGTranslate', lang, location.hostname+location.pathname+location.search]);var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';location.href=location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search;}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';location.href=location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search;}"+new_line;
        } else if(translation_method == 'redirect' && new_window) {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')openTab(unescape(gfg('u')));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href));else openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u')));}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')openTab(unescape(gfg('u')));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href));else openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u')));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
        } else if(translation_method == 'redirect') {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;var lang=lang_pair.split('|')[1];if(typeof _gaq=='undefined')alert('Google Analytics is not installed, please turn off Analytics feature in GTranslate');else _gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')location.href=unescape(gfg('u'));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href);else location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u'));}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')location.href=unescape(gfg('u'));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href);else location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u'));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
        } else if(translation_method == 'onfly') {
            widget_code += "function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(sel[i].className=='goog-te-combo')teCombo=sel[i];if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}"+new_line;
            if(widget_look == 'dropdown_with_flags') {
                widget_code += "function GTranslateGetCurrentLang() {var keyValue = document.cookie.match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}"+new_line;
                widget_code += "if(GTranslateGetCurrentLang() != null)jQuery(document).ready(function() {jQuery('div.switcher div.selected a').html(jQuery('div.switcher div.option').find('span.gflag img[alt=\"'+GTranslateGetCurrentLang()+'\"]').parent().parent().html());});"+new_line;
            }
        }

        widget_code += '/* ]]> */'+new_line;
        widget_code += '<\/script>'+new_line;

    }

    widget_code = widget_preview + widget_code;

    jQuery('#widget_code').val(widget_code);

    ShowWidgetPreview(widget_preview);

}

function ShowWidgetPreview(widget_preview) {
    widget_preview = widget_preview.replace(/javascript:doGTranslate/g, 'javascript:void')
    widget_preview = widget_preview.replace('onchange="doGTranslate(this);"', '');
    widget_preview = widget_preview.replace('if(jQuery.cookie', 'if(false && jQuery.cookie');

    jQuery('head').append( jQuery('<link rel="stylesheet" type="text/css" />').attr('href', '$wp_plugin_url/gtranslate-style'+jQuery('#flag_size').val()+'.css') );
    jQuery('#widget_preview').html(widget_preview);
    if(jQuery('#widget_look').val() == 'dropdown_with_flags')
        jQuery('#widget_preview').prepend('<p style="color:#f44;margin-top:5px;">This look is new, if you are having issues, please post on <a href="http://gtranslate.net/forum/" target="_blank">GTranslate Forum</a></p>');
}

jQuery('#pro_version').attr('checked', '$pro_version'.length > 0);
jQuery('#enterprise_version').attr('checked', '$enterprise_version'.length > 0);
jQuery('#new_window').attr('checked', '$new_window'.length > 0);
jQuery('#analytics').attr('checked', '$analytics'.length > 0);
jQuery('#load_jquery').attr('checked', '$load_jquery'.length > 0);
jQuery('#add_new_line').attr('checked', '$add_new_line'.length > 0);
//jQuery('#show_dropdown').attr('checked', '$show_dropdown'.length > 0);
//jQuery('#show_flags').attr('checked', '$show_flags'.length > 0);

jQuery('#default_language').val('$default_language');
//jQuery('#translation_method').val('$translation_method');
jQuery('#widget_look').val('$widget_look');
jQuery('#flag_size').val('$flag_size');

if(jQuery('#pro_version:checked').length || jQuery('#enterprise_version:checked').length)
    jQuery('#new_window_option').show();

if('$widget_look' == 'dropdown' || '$widget_look' == 'flags_dropdown') {
    jQuery('#dropdown_languages_option').show();
} else {
    jQuery('#dropdown_languages_option').hide();
}

if('$widget_look' == 'flags' || '$widget_look' == 'flags_dropdown' || '$widget_look' == 'dropdown_with_flags') {
    jQuery('#flag_languages_option').show();
} else {
    jQuery('#flag_languages_option').hide();
}

if('$widget_look' == 'flags' || '$widget_look' == 'dropdown' || '$widget_look' == 'dropdown_with_flags') {
    jQuery('#line_break_option').hide();
} else {
    jQuery('#line_break_option').show();
}

if('$widget_look' == 'dropdown_with_flags' || '$widget_look' == 'dropdown') {
    jQuery('#flag_size_option').hide();
} else {
    jQuery('#flag_size_option').show();
}

if(jQuery('#widget_code').val() == '')
    RefreshDoWidgetCode();
else
    ShowWidgetPreview(jQuery('#widget_code').val());
EOT;

// selected languages
if(count($incl_langs) > 0)
    $script .= "jQuery.each(languages, function(i, val) {jQuery('#incl_langs'+language_codes[i]).attr('checked', false);});\n";
if(count($fincl_langs) > 0)
    $script .= "jQuery.each(languages, function(i, val) {jQuery('#fincl_langs'+language_codes[i]).attr('checked', false);});\n";
foreach($incl_langs as $lang)
    $script .= "jQuery('#incl_langs$lang').attr('checked', true);\n";
foreach($fincl_langs as $lang)
    $script .= "jQuery('#fincl_langs$lang').attr('checked', true);\n";
?>

        <form id="gtranslate" name="form1" method="post" action="<?php echo admin_url() . '/options-general.php?page=gtranslate_options' ?>">

        <div class="postbox-container og_left_col">

        <div id="poststuff">
            <div class="postbox">
                <h3 id="settings">Widget options</h3>
                <div class="inside">
                    <table style="width:100%;" cellpadding="4">
                    <!--tr>
                        <td class="option_name">Translation method:</td>
                        <td>
                            <select id="translation_method" name="translation_method" onChange="RefreshDoWidgetCode()">
                                <option value="google_default">Google Default</option>
                                <option value="redirect">Redirect</option>
                                <option value="onfly">On Fly</option>
                            </select>
                        </td>
                    </tr-->
                    <tr>
                        <td class="option_name">Widget look:</td>
                        <td>
                            <select id="widget_look" name="widget_look" onChange="RefreshDoWidgetCode()">
                                <option value="flags_dropdown">Flags and dropdown</option>
                                <option value="dropdown_with_flags">Nice dropdown with flags</option>
                                <option value="dropdown">Dropdown</option>
                                <option value="flags">Flags</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="option_name">Default language:</td>
                        <td>
                            <select id="default_language" name="default_language" onChange="RefreshDoWidgetCode()">
                                <option value="af">Afrikaans</option>
                                <option value="sq">Albanian</option>
                                <option value="ar">Arabic</option>
                                <option value="hy">Armenian</option>
                                <option value="qab">Aurebesh</option>
                                <option value="az">Azerbaijani</option>
                                <option value="eu">Basque</option>
                                <option value="be">Belarusian</option>
                                <option value="bn">Bengali</option>
                                <option value="bs">Bosnian</option>
                                <option value="bg">Bulgarian</option>
                                <option value="my">Burmese</option>
                                <option value="ca">Catalan</option>
                                <option value="ceb">Cebuano</option>
                                <option value="ny">Chichewa</option>
                                <option value="zh-CN">Chinese (Simplified)</option>
                                <option value="zh-TW">Chinese (Traditional)</option>
                                <option value="hr">Croatian</option>
                                <option value="cs">Czech</option>
                                <option value="da">Danish</option>
                                <option value="nl">Dutch</option>
                                <option value="en" selected="selected">English</option>
                                <option value="eo">Esperanto</option>
                                <option value="et">Estonian</option>
                                <option value="tl">Filipino</option>
                                <option value="fi">Finnish</option>
                                <option value="fr">French</option>
                                <option value="gl">Galician</option>
                                <option value="ka">Georgian</option>
                                <option value="de">German</option>
                                <option value="el">Greek</option>
                                <option value="gu">Gujarati</option>
                                <option value="ht">Haitian Creole</option>
                                <option value="ha">Hausa</option>
                                <option value="iw">Hebrew</option>
                                <option value="hi">Hindi</option>
                                <option value="hmn">Hmong</option>
                                <option value="hu">Hungarian</option>
                                <option value="is">Icelandic</option>
                                <option value="ig">Igbo</option>
                                <option value="id">Indonesian</option>
                                <option value="ga">Irish</option>
                                <option value="it">Italian</option>
                                <option value="ja">Japanese</option>
                                <option value="jw">Javanese</option>
                                <option value="kn">Kannada</option>
                                <option value="kk">Kazakh</option>
                                <option value="km">Khmer</option>
                                <option value="ko">Korean</option>
                                <option value="lo">Lao</option>
                                <option value="la">Latin</option>
                                <option value="lv">Latvian</option>
                                <option value="lt">Lithuanian</option>
                                <option value="mk">Macedonian</option>
                                <option value="mg">Malagasy</option>
                                <option value="ms">Malay</option>
                                <option value="ml">Malayalam</option>
                                <option value="mt">Maltese</option>
                                <option value="mi">Maori</option>
                                <option value="mr">Marathi</option>
                                <option value="mn">Mongolian</option>
                                <option value="ne">Nepali</option>
                                <option value="no">Norwegian</option>
                                <option value="fa">Persian</option>
                                <option value="pl">Polish</option>
                                <option value="pt">Portuguese</option>
                                <option value="pa">Punjabi</option>
                                <option value="ro">Romanian</option>
                                <option value="ru">Russian</option>
                                <option value="sr">Serbian</option>
                                <option value="st">Sesotho</option>
                                <option value="si">Sinhalese</option>
                                <option value="sk">Slovak</option>
                                <option value="sl">Slovenian</option>
                                <option value="so">Somali</option>
                                <option value="es">Spanish</option>
                                <option value="su">Sundanese</option>
                                <option value="sw">Swahili</option>
                                <option value="sv">Swedish</option>
                                <option value="tg">Tajik</option>
                                <option value="ta">Tamil</option>
                                <option value="te">Telugu</option>
                                <option value="th">Thai</option>
                                <option value="tr">Turkish</option>
                                <option value="uk">Ukrainian</option>
                                <option value="ur">Urdu</option>
                                <option value="uz">Uzbek</option>
                                <option value="vi">Vietnamese</option>
                                <option value="cy">Welsh</option>
                                <option value="yi">Yiddish</option>
                                <option value="yo">Yoruba</option>
                                <option value="zu">Zulu</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="option_name">Analytics:</td>
                        <td><input id="analytics" name="analytics" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr>
                        <td class="option_name">Operate with Pro version:</td>
                        <td><input id="pro_version" name="pro_version" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr>
                        <td class="option_name">Operate with Enterprise version:</td>
                        <td><input id="enterprise_version" name="enterprise_version" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr id="new_window_option" style="display:none;">
                        <td class="option_name">Open in new window:</td>
                        <td><input id="new_window" name="new_window" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>

                    <!--tr>
                        <td class="option_name">Show flags:</td>
                        <td><input id="show_flags" name="show_flags" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr-->
                    <tr id="flag_size_option">
                        <td class="option_name">Flag size:</td>
                        <td>
                        <select id="flag_size"  name="flag_size" onchange="RefreshDoWidgetCode()">
                            <option value="16" selected>16px</option>
                            <option value="24">24px</option>
                            <option value="32">32px</option>
                        </select>
                        </td>
                    </tr>
                    <tr id="flag_languages_option" style="display:none;">
                        <td class="option_name" colspan="2">Flag languages:<br /><br />

                        <div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsaf" name="fincl_langs[]" value="af"><label for="fincl_langsaf">Afrikaans</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssq" name="fincl_langs[]" value="sq"><label for="fincl_langssq">Albanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsar" name="fincl_langs[]" value="ar"><label for="fincl_langsar">Arabic</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshy" name="fincl_langs[]" value="hy"><label for="fincl_langshy">Armenian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsaz" name="fincl_langs[]" value="az"><label for="fincl_langsaz">Azerbaijani</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langseu" name="fincl_langs[]" value="eu"><label for="fincl_langseu">Basque</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsbe" name="fincl_langs[]" value="be"><label for="fincl_langsbe">Belarusian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsbg" name="fincl_langs[]" value="bg"><label for="fincl_langsbg">Bulgarian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsca" name="fincl_langs[]" value="ca"><label for="fincl_langsca">Catalan</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langszh-CN" name="fincl_langs[]" value="zh-CN"><label for="fincl_langszh-CN">Chinese (Simplified)</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langszh-TW" name="fincl_langs[]" value="zh-TW"><label for="fincl_langszh-TW">Chinese (Traditional)</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshr" name="fincl_langs[]" value="hr"><label for="fincl_langshr">Croatian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langscs" name="fincl_langs[]" value="cs"><label for="fincl_langscs">Czech</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsda" name="fincl_langs[]" value="da"><label for="fincl_langsda">Danish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsnl" name="fincl_langs[]" value="nl"><label for="fincl_langsnl">Dutch</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsen" name="fincl_langs[]" value="en" checked><label for="fincl_langsen">English</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langset" name="fincl_langs[]" value="et"><label for="fincl_langset">Estonian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langstl" name="fincl_langs[]" value="tl"><label for="fincl_langstl">Filipino</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfi" name="fincl_langs[]" value="fi"><label for="fincl_langsfi">Finnish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfr" name="fincl_langs[]" value="fr" checked><label for="fincl_langsfr">French</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsgl" name="fincl_langs[]" value="gl"><label for="fincl_langsgl">Galician</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langska" name="fincl_langs[]" value="ka"><label for="fincl_langska">Georgian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsde" name="fincl_langs[]" value="de" checked><label for="fincl_langsde">German</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsel" name="fincl_langs[]" value="el"><label for="fincl_langsel">Greek</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsht" name="fincl_langs[]" value="ht"><label for="fincl_langsht">Haitian Creole</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsiw" name="fincl_langs[]" value="iw"><label for="fincl_langsiw">Hebrew</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshi" name="fincl_langs[]" value="hi"><label for="fincl_langshi">Hindi</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshu" name="fincl_langs[]" value="hu"><label for="fincl_langshu">Hungarian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsis" name="fincl_langs[]" value="is"><label for="fincl_langsis">Icelandic</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsid" name="fincl_langs[]" value="id"><label for="fincl_langsid">Indonesian</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsga" name="fincl_langs[]" value="ga"><label for="fincl_langsga">Irish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsit" name="fincl_langs[]" value="it" checked><label for="fincl_langsit">Italian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsja" name="fincl_langs[]" value="ja"><label for="fincl_langsja">Japanese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsko" name="fincl_langs[]" value="ko"><label for="fincl_langsko">Korean</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langslv" name="fincl_langs[]" value="lv"><label for="fincl_langslv">Latvian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langslt" name="fincl_langs[]" value="lt"><label for="fincl_langslt">Lithuanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsmk" name="fincl_langs[]" value="mk"><label for="fincl_langsmk">Macedonian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsms" name="fincl_langs[]" value="ms"><label for="fincl_langsms">Malay</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsmt" name="fincl_langs[]" value="mt"><label for="fincl_langsmt">Maltese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsno" name="fincl_langs[]" value="no"><label for="fincl_langsno">Norwegian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfa" name="fincl_langs[]" value="fa"><label for="fincl_langsfa">Persian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langspl" name="fincl_langs[]" value="pl"><label for="fincl_langspl">Polish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langspt" name="fincl_langs[]" value="pt" checked><label for="fincl_langspt">Portuguese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsro" name="fincl_langs[]" value="ro"><label for="fincl_langsro">Romanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsru" name="fincl_langs[]" value="ru" checked><label for="fincl_langsru">Russian</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssr" name="fincl_langs[]" value="sr"><label for="fincl_langssr">Serbian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssk" name="fincl_langs[]" value="sk"><label for="fincl_langssk">Slovak</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssl" name="fincl_langs[]" value="sl"><label for="fincl_langssl">Slovenian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langses" name="fincl_langs[]" value="es" checked><label for="fincl_langses">Spanish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssw" name="fincl_langs[]" value="sw"><label for="fincl_langssw">Swahili</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssv" name="fincl_langs[]" value="sv"><label for="fincl_langssv">Swedish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsth" name="fincl_langs[]" value="th"><label for="fincl_langsth">Thai</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langstr" name="fincl_langs[]" value="tr"><label for="fincl_langstr">Turkish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsuk" name="fincl_langs[]" value="uk"><label for="fincl_langsuk">Ukrainian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsur" name="fincl_langs[]" value="ur"><label for="fincl_langsur">Urdu</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsvi" name="fincl_langs[]" value="vi"><label for="fincl_langsvi">Vietnamese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langscy" name="fincl_langs[]" value="cy"><label for="fincl_langscy">Welsh</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsyi" name="fincl_langs[]" value="yi"><label for="fincl_langsyi">Yiddish</label><br />
                        </div>
                        </div>
                        <br /><br />
                        </td>
                    </tr>
                    <tr id="line_break_option" style="display:none;">
                        <td class="option_name">Line break after flags:</td>
                        <td><input id="add_new_line" name="add_new_line" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <!--tr>
                        <td class="option_name">Show dropdown:</td>
                        <td><input id="show_dropdown" name="show_dropdown" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr-->
                    <tr id="dropdown_languages_option" style="display:none;">
                        <td class="option_name" colspan="2">Dropdown languages:<br /><br />
                        <div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsaf" name="incl_langs[]" value="af" checked><label for="incl_langsaf">Afrikaans</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssq" name="incl_langs[]" value="sq" checked><label for="incl_langssq">Albanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsar" name="incl_langs[]" value="ar" checked><label for="incl_langsar">Arabic</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshy" name="incl_langs[]" value="hy" checked><label for="incl_langshy">Armenian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsqab" name="incl_langs[]" value="qab" checked><label for="incl_langsqab">Aurebesh</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsaz" name="incl_langs[]" value="az" checked><label for="incl_langsaz">Azerbaijani</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langseu" name="incl_langs[]" value="eu" checked><label for="incl_langseu">Basque</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbe" name="incl_langs[]" value="be" checked><label for="incl_langsbe">Belarusian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbn" name="incl_langs[]" value="bn" checked><label for="incl_langsbn">Bengali</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbs" name="incl_langs[]" value="bs" checked><label for="incl_langsbs">Bosnian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbg" name="incl_langs[]" value="bg" checked><label for="incl_langsbg">Bulgarian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmy" name="incl_langs[]" value="my" checked><label for="incl_langsmy">Burmese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsca" name="incl_langs[]" value="ca" checked><label for="incl_langsca">Catalan</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsceb" name="incl_langs[]" value="ceb" checked><label for="incl_langsceb">Cebuano</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsny" name="incl_langs[]" value="ny" checked><label for="incl_langsny">Chichewa</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langszh-CN" name="incl_langs[]" value="zh-CN" checked><label for="incl_langszh-CN">Chinese (Simplified)</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langszh-TW" name="incl_langs[]" value="zh-TW" checked><label for="incl_langszh-TW">Chinese (Traditional)</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshr" name="incl_langs[]" value="hr" checked><label for="incl_langshr">Croatian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langscs" name="incl_langs[]" value="cs" checked><label for="incl_langscs">Czech</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsda" name="incl_langs[]" value="da" checked><label for="incl_langsda">Danish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsnl" name="incl_langs[]" value="nl" checked><label for="incl_langsnl">Dutch</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsen" name="incl_langs[]" value="en" checked><label for="incl_langsen">English</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langseo" name="incl_langs[]" value="eo" checked><label for="incl_langseo">Esperanto</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langset" name="incl_langs[]" value="et" checked><label for="incl_langset">Estonian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langstl" name="incl_langs[]" value="tl" checked><label for="incl_langstl">Filipino</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfi" name="incl_langs[]" value="fi" checked><label for="incl_langsfi">Finnish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfr" name="incl_langs[]" value="fr" checked><label for="incl_langsfr">French</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsgl" name="incl_langs[]" value="gl" checked><label for="incl_langsgl">Galician</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langska" name="incl_langs[]" value="ka" checked><label for="incl_langska">Georgian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsde" name="incl_langs[]" value="de" checked><label for="incl_langsde">German</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsel" name="incl_langs[]" value="el" checked><label for="incl_langsel">Greek</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsgu" name="incl_langs[]" value="gu" checked><label for="incl_langsgu">Gujarati</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsht" name="incl_langs[]" value="ht" checked><label for="incl_langsht">Haitian Creole</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsha" name="incl_langs[]" value="ha" checked><label for="incl_langsha">Hausa</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsiw" name="incl_langs[]" value="iw" checked><label for="incl_langsiw">Hebrew</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshi" name="incl_langs[]" value="hi" checked><label for="incl_langshi">Hindi</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshmn" name="incl_langs[]" value="hmn" checked><label for="incl_langshmn">Hmong</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshu" name="incl_langs[]" value="hu" checked><label for="incl_langshu">Hungarian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsis" name="incl_langs[]" value="is" checked><label for="incl_langsis">Icelandic</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsig" name="incl_langs[]" value="ig" checked><label for="incl_langsig">Igbo</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsid" name="incl_langs[]" value="id" checked><label for="incl_langsid">Indonesian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsga" name="incl_langs[]" value="ga" checked><label for="incl_langsga">Irish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsit" name="incl_langs[]" value="it" checked><label for="incl_langsit">Italian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsja" name="incl_langs[]" value="ja" checked><label for="incl_langsja">Japanese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsjw" name="incl_langs[]" value="jw" checked><label for="incl_langsjw">Javanese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langskn" name="incl_langs[]" value="kn" checked><label for="incl_langskn">Kannada</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langskk" name="incl_langs[]" value="kk" checked><label for="incl_langskk">Kazakh</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langskm" name="incl_langs[]" value="km" checked><label for="incl_langskm">Khmer</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsko" name="incl_langs[]" value="ko" checked><label for="incl_langsko">Korean</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langslo" name="incl_langs[]" value="lo" checked><label for="incl_langslo">Lao</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsla" name="incl_langs[]" value="la" checked><label for="incl_langsla">Latin</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langslv" name="incl_langs[]" value="lv" checked><label for="incl_langslv">Latvian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langslt" name="incl_langs[]" value="lt" checked><label for="incl_langslt">Lithuanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmk" name="incl_langs[]" value="mk" checked><label for="incl_langsmk">Macedonian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmg" name="incl_langs[]" value="mg" checked><label for="incl_langsmg">Malagasy</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsms" name="incl_langs[]" value="ms" checked><label for="incl_langsms">Malay</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsml" name="incl_langs[]" value="ml" checked><label for="incl_langsml">Malayalam</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmt" name="incl_langs[]" value="mt" checked><label for="incl_langsmt">Maltese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmi" name="incl_langs[]" value="mi" checked><label for="incl_langsmi">Maori</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmr" name="incl_langs[]" value="mr" checked><label for="incl_langsmr">Marathi</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmn" name="incl_langs[]" value="mn" checked><label for="incl_langsmn">Mongolian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsne" name="incl_langs[]" value="ne" checked><label for="incl_langsne">Nepali</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsno" name="incl_langs[]" value="no" checked><label for="incl_langsno">Norwegian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfa" name="incl_langs[]" value="fa" checked><label for="incl_langsfa">Persian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langspl" name="incl_langs[]" value="pl" checked><label for="incl_langspl">Polish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langspt" name="incl_langs[]" value="pt" checked><label for="incl_langspt">Portuguese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langspa" name="incl_langs[]" value="pa" checked><label for="incl_langspa">Punjabi</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsro" name="incl_langs[]" value="ro" checked><label for="incl_langsro">Romanian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsru" name="incl_langs[]" value="ru" checked><label for="incl_langsru">Russian</label><br />
                        </div>
                        <div style="width:25%;float:left;">
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssr" name="incl_langs[]" value="sr" checked><label for="incl_langssr">Serbian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsst" name="incl_langs[]" value="st" checked><label for="incl_langsst">Sesotho</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssi" name="incl_langs[]" value="si" checked><label for="incl_langssi">Sinhalese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssk" name="incl_langs[]" value="sk" checked><label for="incl_langssk">Slovak</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssl" name="incl_langs[]" value="sl" checked><label for="incl_langssl">Slovenian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsso" name="incl_langs[]" value="so" checked><label for="incl_langsso">Somali</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langses" name="incl_langs[]" value="es" checked><label for="incl_langses">Spanish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssu" name="incl_langs[]" value="su" checked><label for="incl_langssu">Sundanese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssw" name="incl_langs[]" value="sw" checked><label for="incl_langssw">Swahili</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssv" name="incl_langs[]" value="sv" checked><label for="incl_langssv">Swedish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langstg" name="incl_langs[]" value="tg" checked><label for="incl_langstg">Tajik</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsta" name="incl_langs[]" value="ta" checked><label for="incl_langsta">Tamil</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langste" name="incl_langs[]" value="te" checked><label for="incl_langste">Telugu</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsth" name="incl_langs[]" value="th" checked><label for="incl_langsth">Thai</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langstr" name="incl_langs[]" value="tr" checked><label for="incl_langstr">Turkish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsuk" name="incl_langs[]" value="uk" checked><label for="incl_langsuk">Ukrainian</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsur" name="incl_langs[]" value="ur" checked><label for="incl_langsur">Urdu</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsuz" name="incl_langs[]" value="uz" checked><label for="incl_langsuz">Uzbek</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsvi" name="incl_langs[]" value="vi" checked><label for="incl_langsvi">Vietnamese</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langscy" name="incl_langs[]" value="cy" checked><label for="incl_langscy">Welsh</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsyi" name="incl_langs[]" value="yi" checked><label for="incl_langsyi">Yiddish</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsyo" name="incl_langs[]" value="yo" checked><label for="incl_langsyo">Yoruba</label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langszu" name="incl_langs[]" value="zu" checked><label for="incl_langszu">Zulu</label><br />
                        </div>
                        </div>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="poststuff">
            <div class="postbox">
                <h3 id="settings">Widget code</h3>
                <div class="inside">
                    <span style="color:red;">DO NOT COPY THIS INTO YOUR POSTS OR PAGES! Use [GTranslate] shortcode inside the post/page <br />or add a GTranslate widget into your sidebar from Appearance -> Widgets instead.</span><br /><br />
                    You can edit this if you wish:<br />
                    <textarea id="widget_code" name="widget_code" onchange="ShowWidgetPreview(this.value)" style="font-family:Monospace;font-size:11px;height:150px;width:565px;"><?php echo $widget_code; ?></textarea>
                </div>
            </div>
        </div>

        <?php wp_nonce_field('gtranslate-save'); ?>
        <p class="submit"><input type="submit" class="button-primary" name="save" value="<?php _e('Save Changes'); ?>" /></p>

        </div>

        </form>

        <div class="postbox-container og_right_col">
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings">Widget preview</h3>
                    <div class="inside">
                        <div id="widget_preview"></div>
                    </div>
                </div>
            </div>

            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings">Do you like GTranslate?</h3>
                    <div class="inside">
                        <p>Please write a review on <a href="https://wordpress.org/support/view/plugin-reviews/gtranslate?filter=5">WordPress.org</a>.</p>

                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=231165476898475";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-page" data-href="https://www.facebook.com/gtranslate" data-width="450" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/gtranslate"><a href="https://www.facebook.com/gtranslate">GTranslate</a></blockquote></div></div>

                    </div>
                </div>
            </div>

            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings">Useful info</h3>
                    <div class="inside">
                        Upgrade to <a href="http://gtranslate.net/features?p=wp&xyz=998" target="_blank">GTranslate Enterprise</a> to have the following features:
                        <ul style="list-style-type: square;padding-left:40px;">
                            <li>Enable search engine indexing</li>
                            <li>Search engine friendly (SEF) URLs</li>
                            <li>Meta data translation</li>
                            <li>Edit translations manually</li>
                            <li>URL translation</li>
                            <li>Language hosting</li>
                            <li>Seamless updates</li>
                            <li>SSL support</li>
                        </ul>

                        <a href="http://gtranslate.net/features?p=wp&xyz=998" target="_blank">More Info</a>
                    </div>
                </div>
            </div>
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings">GTranslate Tour Video</h3>
                    <div class="inside">
                        <iframe src="//player.vimeo.com/video/30132555?title=1&amp;byline=0&amp;portrait=0" width="568" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings">GTranslate Enterprise Video</h3>
                    <div class="inside">
                        <iframe src="//player.vimeo.com/video/38686858?title=1&amp;byline=0&amp;portrait=0" width="568" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript"><?php echo $script; ?></script>
        <style type="text/css">
        .postbox #settings {padding-left:12px;}
        .og_left_col {      width: 59%;     }
        .og_right_col {     width: 39%;     float: right;       }
        .og_left_col #poststuff,        .og_right_col #poststuff {      min-width: 0;       }
        table.form-table tr th,     table.form-table tr td {        line-height: 1.5;       }
        table.form-table tr th {        font-weight: bold;      }
        table.form-table tr th[scope=row] { min-width: 300px;       }
        table.form-table tr td hr {     height: 1px;        margin: 0px;        background-color: #DFDFDF;      border: none;       }
        table.form-table .dashicons-before {        margin-right: 10px;     font-size: 12px;        opacity: 0.5;       }
        table.form-table .dashicons-facebook-alt {      color: #3B5998;     }
        table.form-table .dashicons-googleplus {        color: #D34836;     }
        table.form-table .dashicons-twitter {       color: #55ACEE;     }
        table.form-table .dashicons-rss {       color: #FF6600;     }
        table.form-table .dashicons-admin-site,     table.form-table .dashicons-admin-generic {     color: #666;        }
        </style>
        <?php
    }

    function control_options() {
        check_admin_referer('gtranslate-save');

        $data = get_option('GTranslate');

        $data['pro_version'] = isset($_POST['pro_version']) ? $_POST['pro_version'] : '';
        $data['enterprise_version'] = isset($_POST['enterprise_version']) ? $_POST['enterprise_version'] : '';
        $data['new_window'] = isset($_POST['new_window']) ? $_POST['new_window'] : '';
        $data['analytics'] = isset($_POST['analytics']) ? $_POST['analytics'] : '';
        $data['load_jquery'] = isset($_POST['load_jquery']) ? $_POST['load_jquery'] : '';
        $data['add_new_line'] = isset($_POST['add_new_line']) ? $_POST['add_new_line'] : '';
        //$data['show_dropdown'] = isset($_POST['show_dropdown']) ? $_POST['show_dropdown'] : '';
        //$data['show_flags'] = isset($_POST['show_flags']) ? $_POST['show_flags'] : '';
        $data['default_language'] = $_POST['default_language'];
        $data['translation_method'] = $_POST['translation_method'];
        $data['widget_look'] = $_POST['widget_look'];
        $data['flag_size'] = $_POST['flag_size'];
        $data['widget_code'] = stripslashes($_POST['widget_code']);
        $data['incl_langs'] = $_POST['incl_langs'];
        $data['fincl_langs'] = $_POST['fincl_langs'];

        echo '<p style="color:red;">Changes Saved</p>';
        update_option('GTranslate', $data);
    }

    function load_defaults(& $data) {
        $data['pro_version'] = isset($data['pro_version']) ? $data['pro_version'] : '';
        $data['enterprise_version'] = isset($data['enterprise_version']) ? $data['enterprise_version'] : '';
        $data['new_window'] = isset($data['new_window']) ? $data['new_window'] : '';
        $data['analytics'] = isset($data['analytics']) ? $data['analytics'] : '';
        $data['load_jquery'] = isset($data['load_jquery']) ? $data['load_jquery'] : '1';
        $data['add_new_line'] = isset($data['add_new_line']) ? $data['add_new_line'] : '1';
        //$data['show_dropdown'] = isset($data['show_dropdown']) ? $data['show_dropdown'] : '1';
        //$data['show_flags'] = isset($data['show_flags']) ? $data['show_flags'] : '1';
        $data['default_language'] = isset($data['default_language']) ? $data['default_language'] : 'en';
        $data['translation_method'] = isset($data['translation_method']) ? $data['translation_method'] : 'onfly';
        if($data['translation_method'] == 'on_fly') $data['translation_method'] = 'redirect';
        $data['widget_look'] = isset($data['widget_look']) ? $data['widget_look'] : 'flags_dropdown';
        $data['flag_size'] = isset($data['flag_size']) ? $data['flag_size'] : '16';
        $data['widget_code'] = isset($data['widget_code']) ? $data['widget_code'] : '';
        $data['incl_langs'] = isset($data['incl_langs']) ? $data['incl_langs'] : array();
        $data['fincl_langs'] = isset($data['fincl_langs']) ? $data['fincl_langs'] : array();
    }
}
