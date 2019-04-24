<?php 
/**
* Plugin Name: Football Match Tracker
* Plugin URI: http://www.addwebsolution.com
* Description: Football Match Tracker plugin is used for show Live matches, Competitions details, Fixture , Finished matches, Match details, Team details, Players details.
* Version: 1.0
* Author: AddWeb Solution Pvt. Ltd.
* Author URI: http://www.addwebsolution.com
* License: GPL-2.0+
* License URI: http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain: football-api
**/

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}
//Add addweb_fa_football_api class file
require_once plugin_dir_path(__FILE__) . 'includes/football-api-class.php';
//Widget Register file
require_once plugin_dir_path(__FILE__) . 'includes/football-api-widget-function.php';

add_action( 'plugins_loaded', array( 'ADDWEB_FA_FOOTBALL_API', 'addweb_fa_get_instance' ) );

//Register Default Settings at the plugin activation time
register_activation_hook(__FILE__,'addweb_fa_initialize_default_value');
function addweb_fa_initialize_default_value() {
	add_option( 'addweb_fa_api_endpoint', 'http://api.football-api.com/', null, 'no' );
	add_option( 'addweb_fa_api_authentication', '', null, 'yes' );
	add_option( 'addweb_fa_api_version', '2.0', null, 'no' );
	add_option( 'addweb_fa_background_color', '#343638', null, 'no' );
	add_option( 'addweb_fa_hover_color', '#000000', null, 'no' );
	add_option( 'addweb_fa_sw_background_color', '#474c50', null, 'no' );
	add_option( 'addweb_fa_sw_td_background_color', '#909da0', null, 'no' );
	add_option( 'addweb_fa_cw_background_color', '#474c50', null, 'no' );
	add_option( 'addweb_fa_cw_title_background_color', '#909da0', null, 'no' );
	add_option( 'addweb_fa_cw_cb_background_color', '#e5e5e5', null, 'no' );
	add_option( 'addweb_fa_cw_cbf_color', '#000000', null, 'no' );
	add_option( 'addweb_fa_cw_stf_color', '#ffffff', null, 'no' );
	add_option( 'addweb_fa_tab_background_color', '#a2aaad', null, 'no' );
	add_option( 'addweb_fa_tab_active_background_color', '#4f758b', null, 'no' );
	add_option( 'addweb_fa_dt_background_color', '#000000', null, 'no' );
	add_option( 'addweb_fa_ct_background_color', '#d0d4d6', null, 'no' );
	add_option( 'addweb_fa_mb_background_color', '#081f2c', null, 'no' );
	add_option( 'addweb_fa_mb_hover_background_color', '#1e324a', null, 'no');
    add_option( 'addweb_fa_refersh', 'auto-refresh', null, 'no');
    add_option( 'addweb_auto_refresh_seconds', '20', null, 'no');

	$comp_page_id = get_option("competition_page");
    if (!$comp_page_id) {
        //create a new page and automatically assign the page template
        $comp_post = array(
            'post_title' => "Competitions",
            'post_content' => "[FA_COMPETITION_LIST]",
            'post_status' => "publish",
            'post_type' => 'page',
        );
        $comp_postID = wp_insert_post($comp_post, $error);
        update_option("competition_page", $comp_postID);
    }
    $match_page_id = get_option("match_page");
    if (!$match_page_id) {
        //create a new page and automatically assign the page template
        $match_post = array(
            'post_title' => "Matches",
            'post_content' => "[FA_MATCH_LIST show-tab='live|today|finished|fixture' finished-match-days='3' fixture-days='3']",
            'post_status' => "publish",
            'post_type' => 'page',
        );
        $match_postID = wp_insert_post($match_post, $error);
        update_option("match_page", $match_postID);
    }
}

//Delete default values
register_deactivation_hook( __FILE__, 'addweb_fa_delete_default_values' );
function addweb_fa_delete_default_values() {
    delete_option( 'addweb_fa_api_endpoint' );
    delete_option( 'addweb_fa_api_authentication' );
    delete_option( 'addweb_fa_api_version' );
    delete_option( 'addweb_fa_background_color' );
    delete_option( 'addweb_fa_hover_color' );
    delete_option( 'addweb_fa_sw_background_color' );
    delete_option( 'addweb_fa_sw_td_background_color' );
    delete_option( 'addweb_fa_cw_background_color' );
    delete_option( 'addweb_fa_cw_title_background_color' );
    delete_option( 'addweb_fa_cw_cb_background_color' );
    delete_option( 'addweb_fa_cw_cbf_color' );
    delete_option( 'addweb_fa_cw_stf_color' );
    delete_option( 'addweb_fa_tab_background_color' );
    delete_option( 'addweb_fa_tab_active_background_color' );
    delete_option( 'addweb_fa_dt_background_color' );
    delete_option( 'addweb_fa_ct_background_color' );
    delete_option( 'addweb_fa_mb_background_color' );
    delete_option( 'addweb_fa_mb_hover_background_color' );
    delete_option( 'addweb_fa_refersh', 'auto-refresh' );
    delete_option( 'addweb_auto_refresh_seconds' ); 
}