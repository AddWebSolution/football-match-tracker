<?php
/**
 * Football-API Widget Function
 * @package   Football-API
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

if (! defined('ABSPATH')) {
	exit;
}

// Include widget classes.
include_once('football-api-score-widget.php');
include_once('football-api-commentary-widget.php');

/**
 * Register Widgets.
 *
 * @since 1.0
 */
function addweb_fa_register_widgets() {
	register_widget('addweb_score_board_widget');
	register_widget('addweb_commentary_widget');
}

add_action('widgets_init', 'addweb_fa_register_widgets');
