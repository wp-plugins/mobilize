<?php
/*
Plugin Name: Mobilize
Plugin URI: http://getbutterfly.com/wordpress-plugins-free/
Description: Mobilize adds a swipe menu to any site, when the width is lower than 720.
Version: 2.2
Author: Ciprian Popescu
Author URI: http://getbutterfly.com/
License: GPL3

Mobilize
Copyright (C) 2014, 2015 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define('MOBILIZE_PLUGIN_VERSION', '2.2');

register_activation_hook(__FILE__, 'mobilize_install');

function mobilize_install() {
    add_option('mobilize_flavour', '#333333');
    add_option('mobilize_text_flavour', '#ffffff');
    add_option('mobilize_button_flavour', '#116699');
    add_option('mobilize_font_size', 14);
    add_option('mobilize_line_height', 20);

    add_option('mobilize_menubar_minwidth', 480);
    add_option('mobilize_menubar_maxwidth', 320);

    // from 2.0
    delete_option('mobilize_menu_title');
    delete_option('mobilize_submenu_show');
    delete_option('mobilize_submenu_behaviour');
    delete_option('mobilize_menu_font_size');
    delete_option('mobilize_menu_line_height');
    delete_option('mobilize_menu_margin');
    delete_option('mobilize_menu_alignment');
}

register_nav_menus(array(
    'mobilize' => __('Mobilize Navigation', 'mobilize'),
));

add_action('admin_menu', 'mobilize_menu');
add_theme_support('html5', array('search-form'));

function mobilize_menu() {
    add_options_page('Mobilize', 'Mobilize', 'manage_options', 'mobilize_options', 'mobilize_options');
}

function mobilize_options() {
    ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Mobilize <small>(<b>Turn mobile!</b>)</small></h2>
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<h3>About Mobilize <small>(<a href="http://getbutterfly.com/wordpress-plugins/mobilize/" rel="external">official web site</a>)</small></h3>
				<div class="inside">
					<p>
                        <small>You are using <b>Mobilize</b> plugin version <strong><?php echo MOBILIZE_PLUGIN_VERSION; ?></strong>.</small><br>
                        <small>Dependencies: <a href="http://fontawesome.io/" rel="external">Font Awesome</a> 4.3.0.</small>
                    </p>

                    <h2>Usage</h2>
                    <p>Create a new menu and assign it to the "Mobilize" section. Or, if you want to duplicate the main menu, just assign it to the "Mobilize" section (tick the "Mobilize" checkbox).</p>

                    <form method="post">
                        <?php
                        if(isset($_POST['mmsubmit'])) {
                            update_option('mobilize_font_size', floatval($_POST['mobilize_font_size']));
                            update_option('mobilize_line_height', floatval($_POST['mobilize_line_height']));
                            update_option('mobilize_flavour', sanitize_text_field($_POST['mobilize_flavour']));
                            update_option('mobilize_text_flavour', sanitize_text_field($_POST['mobilize_text_flavour']));
                            update_option('mobilize_button_flavour', sanitize_text_field($_POST['mobilize_button_flavour']));
                            update_option('mobilize_menubar_minwidth', intval($_POST['mobilize_menubar_minwidth']));
                            update_option('mobilize_menubar_maxwidth', intval($_POST['mobilize_menubar_maxwidth']));

                           echo '<div id="setting-error-settings_updated" class="updated settings-error"> 
<p><strong>Settings saved.</strong></p></div>';
                        }
                        ?>
                        <h2>General Options</h2>
                        <p>
                            <input type="number" name="mobilize_font_size" id="mobilize_font_size" min="8" max="72" value="<?php echo get_option('mobilize_font_size'); ?>"> <label for="mobilize_font_size">Menu font size (px) (default is <b>14</b>)</label>
                            <br>
                            <input type="number" name="mobilize_line_height" id="mobilize_line_height" min="8" max="72" value="<?php echo get_option('mobilize_line_height'); ?>"> <label for="mobilize_line_height">Menu line height (px) (default is <b>20</b>)</label>
                        </p>

						<p>
							<label for="mobilize_flavour"><b>Mobilize</b> background colour</label>
							<br><input type="text" name="mobilize_flavour" class="mobilize_colorPicker" data-default-color="#333333" value="<?php echo get_option('mobilize_flavour'); ?>">
							<br><small>This is the colour of the menu container</small>
						</p>
						<p>
							<label for="mobilize_text_flavour"><b>Mobilize</b> text colour</label>
							<br><input type="text" name="mobilize_text_flavour" class="mobilize_colorPicker" data-default-color="#ffffff" value="<?php echo get_option('mobilize_text_flavour'); ?>">
							<br><small>This is the colour of the menu text</small>
						</p>
						<p>
							<label for="mobilize_button_flavour"><b>Mobilize</b> button hover colour</label>
							<br><input type="text" name="mobilize_button_flavour" class="mobilize_colorPicker" data-default-color="#116699" value="<?php echo get_option('mobilize_button_flavour'); ?>">
							<br><small>This is the colour of the menu button (when hover)</small>
						</p>

                        <h2>Menu button appearance</h2>
                        <p>
                            <input type="number" name="mobilize_menubar_minwidth" id="mobilize_menubar_minwidth" min="0" max="9999" value="<?php echo get_option('mobilize_menubar_minwidth'); ?>"> <label for="mobilize_menubar_minwidth">Minimum width for menu button (px) (default is <b>480</b>)</label>
                            <br>
                            <input type="number" name="mobilize_menubar_maxwidth" id="mobilize_menubar_maxwidth" min="0" max="9999" value="<?php echo get_option('mobilize_menubar_maxwidth'); ?>"> <label for="mobilize_menubar_maxwidth">Maximum width for menu button (px) (default is <b>320</b>)</label>
                            <br><small>Combine widths such as 720 with 480 or 480 with 320.</small>
                            <br><small>The former is recommended for tablets, while the latter is recommended for mobile devices. Select 480 with 320 as default.</small>
                        </p>

						<p>
							<input name="mmsubmit" type="submit" class="button-primary" value="Save Changes">
						</p>
                    </form>
				</div>
			</div>
            <div class="postbox">
                <div class="inside">
                    <p>For support, feature requests and bug reporting, please visit the <a href="//getbutterfly.com/" rel="external">official website</a>.</p>
                    <p>&copy;<?php echo date('Y'); ?> <a href="//getbutterfly.com/" rel="external"><strong>getButterfly</strong>.com</a> &middot; <a href="//getbutterfly.com/forums/" rel="external">Support forums</a> &middot; <a href="//getbutterfly.com/trac/" rel="external">Trac</a> &middot; <small>Code wrangling since 2005</small></p>
                </div>
            </div>
		</div>
	</div>

    <?php
}

function mobilize_enqueue_color_picker($hook_suffix) {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('mobilize_color_picker', plugins_url('js/mobilize-functions.js', __FILE__ ), array('wp-color-picker'), false, true);
}

/* add actions */
add_action('wp_head', 'mobilize_head', 0);
add_action('wp_footer', 'mobilize');
add_action('admin_enqueue_scripts', 'mobilize_enqueue_color_picker');

function mobilize_head() {
    wp_enqueue_style('fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
    wp_enqueue_style('mobilize-css', plugins_url('css/jquery.mmenu-min.css', __FILE__));
}

function mobilize() {
    $mobilize_flavour = get_option('mobilize_flavour');
    $mobilize_text_flavour = get_option('mobilize_text_flavour');
    $mobilize_button_flavour = get_option('mobilize_button_flavour');
    $mobilize_font_size = get_option('mobilize_font_size');
    $mobilize_line_height = get_option('mobilize_line_height');

    $mobilize_menubar_minwidth = get_option('mobilize_menubar_minwidth');
    $mobilize_menubar_maxwidth = get_option('mobilize_menubar_maxwidth');

    $display = '<!-- BEGIN MOBILIZE -->';

    $display .= '<style>
    #navid > ul, #navid #toggle { background-color: ' . $mobilize_flavour . '; }
    #navid ul li a { color: ' . $mobilize_text_flavour . '; font-size: ' . $mobilize_font_size . 'px; line-height: ' . $mobilize_line_height . 'px; }
    #navid #toggle { color: ' . $mobilize_text_flavour . '; }
    #navid #toggle:hover { background-color: ' . $mobilize_button_flavour . '; }

    @media screen and (min-width: ' . $mobilize_menubar_minwidth . 'px) { #navid #toggle { display: none; } }
    @media screen and (max-width: ' . $mobilize_menubar_maxwidth . 'px) { #navid #toggle { display: block; } }
    </style>';

    $display .= '<input type="checkbox" id="nav-toggle">
    <div id="navid">
        <label for="nav-toggle" id="toggle"><i class="fa fa-bars"></i></label>';
        //$display .= get_search_form();
        $display .= wp_nav_menu(array('theme_location' => 'mobilize', 'menu_class' => '', 'container' => false, 'echo' => false));
    $display .= '</div>';

    $display .= '<!-- END MOBILIZE -->';

    echo $display;
}
?>
