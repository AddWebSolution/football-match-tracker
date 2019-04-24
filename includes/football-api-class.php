<?php 
/**
 * Football-API Class
 * @package   Football Match Tracker
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

///SHORTCODE CLASS FOR RESGISTER SHORTCODE INTO THIS CLASS
require_once plugin_dir_path(__FILE__) . 'shortcodes.php';

class ADDWEB_FA_FOOTBALL_API {
	
	/**
	 * Unique identifier for plugin.
	 *
	 * 
	 * @var string
	 */
	protected $addweb_fa_plugin_slug = 'football-match-tracker';
	
	/**
	 * Instance of this class.
	 *
	 * 
	 * @var object
	 */
	protected static $addweb_fa_instance = null;

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 * 
	 *
	 * @var string
	 */
	const ADDWEB_FA_VERSION = '1.0';

	/**
	 * API EndPoint.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_api_endpoint;

	/**
	 * API Authentication Key.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_api_authentication;

	/**
	 * API Version.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_api_version;

	/**
	 * Score Widget Background Color.
	 * 
	 *
	 * @var string
	 */

	protected static $addweb_fa_sw_background_color;

	/**
	 * Score Widget's Tab And Date background color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_sw_td_background_color;

	/**
	 * Commentary Widget Background Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_cw_background_color;

	/**
	 * Commentary Widget's Title Bar Background Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_cw_title_background_color;

	/**
	 * Commentary Widget's Comment Box Background Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_cw_cb_background_color;

	/**
	 * Commentary Widget's Comment Font Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_cw_cbf_color;

	/**
	 * Commentary Widget's Score Title Font Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_cw_stf_color;

	/**
	 * Theme Background Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_background_color;

	/**
	 * Button Hover Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_hover_color;

	/**
	 * Match Shortcode Tab Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_tab_background_color;

	/**
	 * Match Shortcode Tab Active Color..
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_tab_active_background_color;

	/**
	 * Match Shortcode Date-Bar Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_dt_background_color;

	/**
	 * Match Shortcode Competiton-Bar Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_ct_background_color;

	/**
	 * Match-Bar Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_mb_background_color;

	/**
	 * Match-Bar Hover Color.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_mb_hover_background_color;
	/**
	 * Score Refresh.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_refersh;
	/**
	 * Score Refresh Seconds.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_auto_refresh_seconds;
	function __construct()
	{
		$this->addweb_fa_api_endpoint 					= 		get_option('addweb_fa_api_endpoint');
		$this->addweb_fa_api_authentication 			= 		get_option('addweb_fa_api_authentication');
		$this->addweb_fa_api_version 					= 		get_option('addweb_fa_api_version');
		$this->addweb_fa_sw_background_color 			= 		get_option('addweb_fa_sw_background_color');
		$this->addweb_fa_sw_td_background_color 		= 		get_option('addweb_fa_sw_td_background_color');
		$this->addweb_fa_cw_background_color 			= 		get_option('addweb_fa_cw_background_color');
		$this->addweb_fa_cw_title_background_color  	= 		get_option('addweb_fa_cw_title_background_color');
		$this->addweb_fa_cw_cb_background_color 		= 		get_option('addweb_fa_cw_cb_background_color');
		$this->addweb_fa_cw_cbf_color 					= 		get_option('addweb_fa_cw_cbf_color');
		$this->addweb_fa_cw_stf_color					= 		get_option('addweb_fa_cw_stf_color');
		$this->addweb_fa_background_color 				= 		get_option('addweb_fa_background_color');
		$this->addweb_fa_hover_color 					= 		get_option('addweb_fa_hover_color');
		$this->addweb_fa_tab_background_color 			=		get_option('addweb_fa_tab_background_color');
		$this->addweb_fa_tab_active_background_color	=		get_option('addweb_fa_tab_active_background_color');
		$this->addweb_fa_dt_background_color 			=		get_option('addweb_fa_dt_background_color');
		$this->addweb_fa_ct_background_color 			=		get_option('addweb_fa_ct_background_color');
		$this->addweb_fa_mb_background_color 			=		get_option('addweb_fa_mb_background_color');
		$this->addweb_fa_mb_hover_background_color		=		get_option('addweb_fa_mb_hover_background_color');
		$this->addweb_fa_refersh						=		get_option('addweb_fa_refersh');
		$this->addweb_auto_refresh_seconds				=		get_option('addweb_auto_refresh_seconds');

		if( is_admin()) {
			// Add the settings page and menu item.
			add_action( 'admin_menu', array( $this, 'addweb_fa_plugin_admin_menu' ) );
			// Add jQuery UI js for add tab in plugin menu
			add_action( 'admin_enqueue_scripts', array( $this, 'addweb_fa_enqueue_admin' ) );	
		}

		$addweb_fa_shortcode = new ADDWEB_FA_SHORTCODE();

		//Short Code for show all competitions list and competitions details
		add_shortcode('FA_COMPETITION_LIST', array($addweb_fa_shortcode ,'addweb_fa_competitionsList'));
		//Short Code for show all live mtaches,filter match by team,filter match by competition & show detials of match.
		add_shortcode('FA_MATCH_LIST', array( $addweb_fa_shortcode ,'addweb_fa_matchList'));
		//add auto refresh seconds
		add_action('wp_head',array( $this,'addweb_fa_refresh_script'));
		//add custom bootstrap in fornt-end
		add_action('wp_enqueue_scripts', array( $this,'addweb_fa_enqueue_styles'));
		//API Call
		add_action("wp_plugin_event", "addweb_fa_API");
		//add auto refresh script
		if($this->addweb_fa_refersh	== 'auto-refresh') {
			add_action('wp_enqueue_scripts', array( $this,'addweb_fa_auto_refresh_script'));
		}
		add_action('wp_enqueue_scripts', array( $this, 'addweb_fa_font_awesome'));
	}
	//Instance
	public static function addweb_fa_get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$addweb_fa_instance ) {
			self::$addweb_fa_instance = new self;
		}
		return self::$addweb_fa_instance;
	}

	//Add plugin menu 
	public function addweb_fa_plugin_admin_menu() {
		add_menu_page( __('Football Match Tracker','addweb-fa-football-api'), __('Football Match Tracker Settings','addweb-fa-football-api'), 'manage_options', $this->addweb_fa_plugin_slug, array( $this, 'addweb_fa_options' ), plugins_url('../assets/icon/fa.svg', __FILE__ ));
	}

	//jQuery UI js, Color Picker, Date Picker script file function
	public function addweb_fa_enqueue_admin() {
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( $this->addweb_fa_plugin_slug . '-jquery-cookie', plugins_url( '../assets/js/jquery.cookie.js', __FILE__ ), array('jquery'), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_script( $this->addweb_fa_plugin_slug . '-admin-script-js', plugins_url( '../assets/js/admin.js', __FILE__ ), array('wp-color-picker','jquery-ui-tabs'), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_style( $this->addweb_fa_plugin_slug . '-jquery-ui-style', plugins_url( '../assets/css/jquery-ui.min.css', __FILE__ ), array(), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_style( $this->addweb_fa_plugin_slug . '-admin-style', plugins_url( '../assets/css/admin_style.css', __FILE__ ), array(), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
	
	}
	
	public function addweb_fa_refresh_script() {
		?><script>
			var refresh_seconds = <?php echo $this->addweb_auto_refresh_seconds*1000; ?>;
		</script><?php
	}
	//style file for widget & shortcode
	public function addweb_fa_enqueue_styles() {
		wp_enqueue_style( $this->addweb_fa_plugin_slug . '-cs-style', plugins_url( '../assets/css/jquery.custom-scrollbar.css', __FILE__ ), array(), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_style( $this->addweb_fa_plugin_slug . '-style', plugins_url( '../assets/css/addweb-style.css', __FILE__ ), array(), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_script( $this->addweb_fa_plugin_slug . '-scrollbar-js', plugins_url( '../assets/js/jquery.custom-scrollbar.js', __FILE__ ), array('jquery'), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
		wp_enqueue_script( $this->addweb_fa_plugin_slug . '-addweb-js', plugins_url( '../assets/js/addweb-js.js', __FILE__ ), array('jquery'), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
	}

	public function addweb_fa_auto_refresh_script() {
		wp_enqueue_script( $this->addweb_fa_plugin_slug . '-refresh-js', plugins_url( '../assets/js/ref-js.js', __FILE__ ), array('jquery'), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION );
	}

	public function addweb_fa_font_awesome() {
		wp_enqueue_style($this->addweb_fa_plugin_slug . '-font-awesome', plugins_url('../assets/font-awesome/css/font-awesome.min.css',__FILE__), array(), ADDWEB_FA_FOOTBALL_API::ADDWEB_FA_VERSION ); 
	}
	
	//Plugin Menu page
	public function addweb_fa_options() {
		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		$keyvalid = '';
		if(isset($_POST['addweb-setting'])){
			if($_POST['addweb-setting'] == 'addweb-api-setting'){
				$api_base_url = $this->addweb_fa_api_endpoint;
				$api_version = $this->addweb_fa_api_version;
				$addweb_api_authentication = sanitize_text_field($_POST['addweb_fa_api_authentication']);
				$final_url = $api_base_url.$api_version."/competitions?Authorization=".$addweb_api_authentication;
				$result = wp_remote_get($final_url);
				$aResult = json_decode($result['body']);
				if($aResult->error == 'Key not authorised') {
					wp_redirect( admin_url( 'admin.php?page='.$_GET['page'].'&apierror=1' ) );
				}
				else{
					$keyvalid = __('<span style="color:green;">Authorised Key</span>');
					if ( ! empty( $_POST ) && check_admin_referer( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_fa' ) ) {
						/**Update API ENDPOINT**/
						if($this->addweb_fa_api_endpoint !== false) {
							$addweb_api_endpoint = sanitize_text_field($_POST['addweb_fa_api_endpoint']);
							update_option('addweb_fa_api_endpoint', $addweb_api_endpoint);
						}
						/**Update API AUTHENTICATION**/
						if($this->addweb_fa_api_authentication !== false) {
							$addweb_api_authentication = sanitize_text_field($_POST['addweb_fa_api_authentication']);
							update_option('addweb_fa_api_authentication', $addweb_api_authentication);
						}
						else {
							$addweb_api_authentication = sanitize_text_field($_POST['addweb_fa_api_authentication']);
							add_option('addweb_fa_api_authentication',$addweb_api_authentication,null,'no');
						}
					}
					wp_redirect( admin_url( 'admin.php?page='.$_GET['page'].'&updated=1' ) );
				}
			}
			//Theme Color setting
			if($_POST['addweb-setting'] == 'addweb-theme-setting'){
				if ( ! empty( $_POST ) && check_admin_referer( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_fa_theme' ) ) {
					if($this->addweb_fa_background_color !== false) {
						$addweb_fa_bg_color = sanitize_hex_color($_POST['addweb_fa_background_color']);
						update_option('addweb_fa_background_color', $addweb_fa_bg_color);
					}

					if($this->addweb_fa_hover_color !== false) {
						$addweb_fa_hvr_color = sanitize_hex_color($_POST['addweb_fa_hover_color']);
						update_option('addweb_fa_hover_color', $addweb_fa_hvr_color);
					}

					if($this->addweb_fa_sw_background_color !== false) {
						$addweb_fa_sw_bg_color = sanitize_hex_color($_POST['addweb_fa_sw_background_color']);
						update_option('addweb_fa_sw_background_color', $addweb_fa_sw_bg_color);
					}

					if($this->addweb_fa_sw_td_background_color !== false) {
						$addweb_sw_td_bg_color = sanitize_hex_color($_POST['addweb_fa_sw_td_background_color']);
						update_option('addweb_fa_sw_td_background_color', $addweb_sw_td_bg_color);
					}

					if($this->addweb_fa_cw_background_color !== false) {
						$addweb_fa_cw_bg_color = sanitize_hex_color($_POST['addweb_fa_cw_background_color']);
						update_option('addweb_fa_cw_background_color', $addweb_fa_cw_bg_color);
					}

					if($this->addweb_fa_cw_title_background_color !== false) {
						$addweb_fa_cw_title_bg_color = sanitize_hex_color($_POST['addweb_fa_cw_title_background_color']);
						update_option('addweb_fa_cw_title_background_color', $addweb_fa_cw_title_bg_color);
					}

					if($this->addweb_fa_cw_cb_background_color !== false) {
						$addweb_fa_cw_cb_bg_color = sanitize_hex_color($_POST['addweb_fa_cw_cb_background_color']);
						update_option('addweb_fa_cw_cb_background_color', $addweb_fa_cw_cb_bg_color);
					}

					if($this->addweb_fa_cw_cbf_color !== false) {
						$addweb_fa_cw_cbfont_color = sanitize_hex_color($_POST['addweb_fa_cw_cbf_color']);
						update_option('addweb_fa_cw_cbf_color', $addweb_fa_cw_cbfont_color);
					}

					if($this->addweb_fa_cw_stf_color !== false) {
						$addweb_fa_cw_stfont_color = sanitize_hex_color($_POST['addweb_fa_cw_stf_color']);
						update_option('addweb_fa_cw_stf_color', $addweb_fa_cw_stfont_color);
					}

					if($this->addweb_fa_tab_background_color !== false) {
						$addweb_fa_tab_bg_color = sanitize_hex_color($_POST['addweb_fa_tab_background_color']);
						update_option('addweb_fa_tab_background_color', $addweb_fa_tab_bg_color);
					}

					if($this->addweb_fa_tab_active_background_color !== false) {
						$addweb_fa_tab_active_bg_color = sanitize_hex_color($_POST['addweb_fa_tab_active_background_color']);
						update_option('addweb_fa_tab_active_background_color', $addweb_fa_tab_active_bg_color);
					}

					if($this->addweb_fa_dt_background_color !== false) {
						$addweb_fa_dt_bg_color = sanitize_hex_color($_POST['addweb_fa_dt_background_color']);
						update_option('addweb_fa_dt_background_color', $addweb_fa_dt_bg_color);
					}

					if($this->addweb_fa_ct_background_color !== false) {
						$addweb_fa_ct_bg_color = sanitize_hex_color($_POST['addweb_fa_ct_background_color']);
						update_option('addweb_fa_ct_background_color', $addweb_fa_ct_bg_color);
					}

					if($this->addweb_fa_mb_background_color !== false) {
						$addweb_fa_mb_bg_color = sanitize_hex_color($_POST['addweb_fa_mb_background_color']);
						update_option('addweb_fa_mb_background_color', $addweb_fa_mb_bg_color);
					}
					if($this->addweb_fa_mb_hover_background_color !== false) {
						$addweb_fa_mb_hvr_bg_color = sanitize_hex_color($_POST['addweb_fa_mb_hover_background_color']);
						update_option('addweb_fa_mb_hover_background_color', $addweb_fa_mb_hvr_bg_color);
					}
				}
				wp_redirect( admin_url( 'admin.php?page='.$_GET['page'].'&updated=1' ) );
			}
			if($_POST['addweb-setting'] == 'addweb-other-setting'){
				if ( ! empty( $_POST ) && check_admin_referer( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_other' ) ) {
					if($this->addweb_fa_refersh !== false) {
						$addweb_fa_data_refresh = sanitize_text_field($_POST['addweb_fa_refersh']);
						update_option('addweb_fa_refersh', $addweb_fa_data_refresh);
					}
					if($this->addweb_auto_refresh_seconds !== false) {
						$addweb_fa_auto_refresh_seconds = intval($_POST['addweb_auto_refresh_seconds']);
						update_option('addweb_auto_refresh_seconds', $addweb_fa_auto_refresh_seconds);
					}
				}
				wp_redirect( admin_url( 'admin.php?page='.$_GET['page'].'&updated=1' ) );
			}
		}
		?>
		<!--********************Plugin Setting View*******************-->
		<?php if( isset($_GET['updated']) && $_GET['updated']==1 ) { ?>
    		<div id="message" class="updated" style="margin-left:2px;">
        		<p><strong><?php _e('Settings saved.') ?></strong></p>
   			</div>
		<?php } ?>

		<div class="setting-wrap">
			<h2><?php _e( 'Football Match Tracker Settings', 'addweb-fa-football-api' ); ?></h2>
			<div id="addweb_fa_api-settings">
				<ul>
					<li><a href = "#api-settings">API Settings</a></li>
          <li><a href = "#shortcodes">Shortcodes</a></li>
          <li><a href = "#plugin-theme">Themes</a></li>
          <li><a href = "#other-setting">Other Setting</a></li>
          <li><a href = "#about-settings">About Us</a></li>
				</ul>
				<div id="api-settings">
					<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page='.$_GET['page'].'&noheader=true' )); ?>" enctype="multipart/form-data">
					<?php wp_nonce_field( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_fa' ); ?>
						<table class="form-table" width="100%">
							<tr>
								<th scope="row"><label for="api-endpoint"><strong><?php _e('API Endpoint','addweb-fa-football-api'); ?></strong></label></th>
								<td>
									<input type="text" id="api-endpoint" name="addweb_fa_api_endpoint" size="30" value="<?php echo $this->addweb_fa_api_endpoint;?>" >
								</td>
							</tr>
							<tr>
								<th></th>
								<td><span>Refer API and Authentication Key From <a href="http://www.football-api.com" target="_blank">www.football-api.com</a></span></td>
							</tr>
							<tr>
								<th scope="row"><label for="api-authentication"><strong><?php _e('API Authentication Key','addweb-fa-football-api'); ?></strong></label></th>
								<td style="width: 412px;">
									<input type="text" id="api-authentication" name="addweb_fa_api_authentication" size="30" value="<?php echo $this->addweb_fa_api_authentication;?>">
									<input type="hidden" name="addweb-setting" value="addweb-api-setting"> &nbsp;
									<?php if($_GET['apierror']==1){echo '<span style="color:red">'.__('Key not authorised').'</span>';}?>
								</td>
							</tr>
							
						</table>
						<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
						</p>
					</form>
					<?php $plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) ); ?>
				</div>
				<div id="shortcodes">
					<div>
						<h3>When you active this plugin there are two pages automatically created for competitions and match shortcodes.</h3>
						<h4>1. [FA_COMPETITION_LIST]</h4><?php $comp_id = get_option('competition_page'); 
						 edit_post_link( 'Edit Competition Shortcode Page', '<span class="addweb_custom_button">', '</span>', $comp_id, 'button button-primary' );?>
						<div >
							<p style="margin-left:14px;font-size:14px;"><b style="font-size:12px;">'[FA_COMPETITION_LIST]'</b> shortcode provide you all competitions list. Also provide you details of Standings for competitions, Team details and Player details.</p>
							<p style="margin-left:14px;font-size:14px;">How to use : Just put [FA_COMPETITION_LIST] into your page or post.</p>
						</div>
						<h4>2. [FA_MATCH_LIST]</h4><?php $match_id = get_option('match_page'); 
						 edit_post_link( 'Edit Match Shortcode Page', '<span class="addweb_custom_button">', '</span>', $match_id, 'button button-primary' );?>
						<p style="margin-left:14px;font-size:14px;"><b style="font-size:12px;">'[FA_MATCH_LIST]'</b> shortcode provide you match list of competitions for current date, Fixture match list for your entered day basis, Finished match list for your entered day basis, Live match details. Also provide you details of Standings for competitions, Team details and Player details.</p>

						<h5 style="margin-left:14px;">[FA_MATCH_LIST] shortcode have following attributes :</h5>
						<ol style="margin-left:28px;">
							<li value="1">show-tab</li>
							<li>fixture-days</li>
							<li>finished-match-days</li>
						</ol>

						<p style="margin-left:14px;"><b>1. <u>show-tab</u></b> : show-tab have four property <b>(live, today, finished, fixture)</b> that are use for showing data according tabs, that you want used.</p>
						<p style="margin-left:14px;">Example : [FA_MATCH_LIST show-tab="today|live|fixture"] this Example shows data for Today tab, Live tab, Fixture tab only.</p>
						<p style="margin-left:14px;"><b>2. <u>fixture-days</u></b> : fixture-days shows fixture or up coming match data into Fixture tab for you entered number of days. By default it shows two days fixture.</p>
						<p style="margin-left:14px;">Example : [FA_MATCH_LIST fixture-days="5"] this Example shows data of fixture for five days from current date.</p>
						<p style="margin-left:14px;"><b>3. <u>finished-match-days</u></b> : finished-match-days shows finished match data into Finished tab for you entered number of days. By default it shows one days finished match.</p>
						<p style="margin-left:14px;">Example : [FA_MATCH_LIST finished-match-days="5"] this Example shows data of finished match for five days from current date.</p>
					</div>
				</div>
				<div id="plugin-theme">
					<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page='.$_GET['page'].'&noheader=true&theme=true' )); ?>" enctype="multipart/form-data">
						 <?php wp_nonce_field( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_fa_theme' ); ?>
							<div>
								<h2><u>Shortcodes Theme</u></h2>
								<div>
									<h4>1.Competiotion Shortcode Theme</h4>
									<div>
										<table>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_background"><?php _e('Background Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_background" name="addweb_fa_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_background_color; ?>">
													<input type="hidden" name="addweb-setting" value="addweb-theme-setting">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb-btn-hover"><?php _e('Hover Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb-btn-hover" name="addweb_fa_hover_color" maxlength="255" size="25" value="<?php echo $this->addweb_fa_hover_color; ?>">
												</td>
											</tr>
										</table>
									</div>
									<h4>2.Match Shortcode Theme</h4>
									<div>
										<table>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_tab_background"><?php _e('Tab Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_tab_background" name="addweb_fa_tab_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_tab_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_tab_active_background"><?php _e('Active Tab Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_tab_active_background" name="addweb_fa_tab_active_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_tab_active_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_dt_background"><?php _e('Date Tile-Bar Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_dt_background" name="addweb_fa_dt_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_dt_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_ct_background"><?php _e('Competition Title-Bar Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_ct_background" name="addweb_fa_ct_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_ct_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_mb_background"><?php _e('Match-Bar Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_mb_background" name="addweb_fa_mb_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_mb_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_theme_mb_hover_background"><?php _e('Match-Bar Hover Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_theme_mb_hover_background" name="addweb_fa_mb_hover_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_mb_hover_background_color; ?>">
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div>
								<h2><u>Widget Theme</u></h2>
								<div>
									<h4>1.Score Widget Theme</h4>
									<div>
										<table>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_sw_theme_background"><?php _e('Widget Background','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_sw_theme_background" name="addweb_fa_sw_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_sw_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_sw_td_background"><?php _e('Widget Date & Tab Background','addweb-fa-football-api'); ?></label
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_sw_td_background" name="addweb_fa_sw_td_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_sw_td_background_color; ?>">
												</td>
											</tr>
										</table>
									</div>
									<h4>2.Commentary Widget Theme</h4>
									<div>
										<table>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_cw_theme_background"><?php _e('Widget Background','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_cw_theme_background" name="addweb_fa_cw_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_cw_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_cw_title_background"><?php _e('Score Title Background','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_cw_title_background" name="addweb_fa_cw_title_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_cw_title_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_cw_cb_background"><?php _e('Comment Box Background','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_cw_cb_background" name="addweb_fa_cw_cb_background_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_cw_cb_background_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_cw_stf_background"><?php _e('Score Title Font Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_cw_stf_background" name="addweb_fa_cw_stf_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_cw_stf_color; ?>">
												</td>
											</tr>
											<tr>
												<th class="addweb-fa-th" scope="row">
													<label for="addweb_cw_cbf_background"><?php _e('Comment Box Font Color','addweb-fa-football-api'); ?></label>
												</th>
												<td>
													<input type="text" class="color-picker" id="addweb_cw_cbf_background" name="addweb_fa_cw_cbf_color" maxlength="255" size="25"  value="<?php echo $this->addweb_fa_cw_cbf_color; ?>">
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						<p class="submit">
							<input type="submit" name="Submit_theme" class="button-primary" value="<?php esc_attr_e( 'Save Theme' ); ?>" />
						</p>
					</form>
				</div>
				<div id="other-setting">
					<form align="center" method="post" action="<?php echo esc_url( admin_url( 'admin.php?page='.$_GET['page'].'&noheader=true' )); ?>">
					<?php wp_nonce_field( 'ADDWEB_FA_FOOTBALL_API', 'save_addweb_other' ); ?>
						<table class="form-table" width="100%">
							<tr>
								<th scope="row"><?php _e('Manual Refresh','addweb-fa-football-api'); ?></th>
								<td>
									<input type="radio" name="addweb_fa_refersh" value="manual-refresh" id="manual-refresh" onclick="fun_disable();" <?php if($this->addweb_fa_refersh == 'manual-refresh'){ echo 'checked';}?>/>
									<input type="hidden" name="addweb-setting" value="addweb-other-setting">
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Auto Refresh','addweb-fa-football-api'); ?></th>
								<td>
									<input type="radio" name="addweb_fa_refersh" value="auto-refresh" id="auto-refresh" onclick="fun_enable();" <?php if($this->addweb_fa_refersh == 'auto-refresh'){ echo 'checked';}?>/>
									<input type="number" name="addweb_auto_refresh_seconds" id="ref-seconds" min="10" value="<?php echo $this->addweb_auto_refresh_seconds; ?>"  style="width:55px;"/><?php _e(' Seconds','addweb-fa-football-api'); ?>
								</td>
							</tr>
						</table>
						<p class="submit">
							<input type="submit" name="Submit_theme" class="button-primary" value="<?php esc_attr_e( 'Save' ); ?>" />
						</p>
					</form>
				</div>
				<div id="about-settings">
					<div style="margin:0 auto;width:54%;">
						<a href="http://www.addwebsolution.com" style="outline: hidden;" target="_blank"><img src="<?php echo plugins_url( '../assets/images/addweb-logo.png', __FILE__);?>" alt="AddwebSolution" height=60px ></a>
					</div><?php
					$arrAddwebPlugins = array(
			      'woo-cart-customizer' => 'Woo Cart Customizer',
			      'widget-social-share' => 'WSS: Widget Social Share',
			      'post-timer' => 'Post Timer',
			      'wp-all-in-one-social' => 'WP All In One Social',
			      'aws-cookies-popup' => 'AWS Cookies Popup'
    			);?>
			    <div class="advertise">
			    <div class="ad-heading">Visit Our Other Plugins:</div>
			    <div class="ad-content"><?php
				    foreach($arrAddwebPlugins as $slug=>$name) {?>
				        <div class="ad-detail">
				          <a href="https://wordpress.org/plugins/<?php echo $slug;?>" target="_blank"><img src="<?php echo plugins_url( '../assets/images/', __FILE__).$slug;?>.svg"></a>..
				          <a href="https://wordpress.org/plugins/<?php echo $slug;?>" class="ad-link" target="_blank"><?php echo $name;?></a>
				        </div><?php
				    } ?></div>
    			</div>
				</div>
			</div>
		</div>
		<?php
	}
}