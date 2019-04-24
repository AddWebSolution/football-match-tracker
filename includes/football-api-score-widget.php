<?php 
/**
 * Football-API Score-Board Widget
 * @package   Football-API
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

if ( ! defined('ABSPATH')) {
	exit;
}

//API CLASS FOR GETTING API DATA FOR SCORE BOARD
require_once plugin_dir_path(__FILE__) . 'api-class.php';

class ADDWEB_SCORE_BOARD_WIDGET extends WP_Widget {

	protected static $addweb_sw_bg;
	protected static $addweb_sw_td_bg;
	protected static $addweb_api_obj;

    public function ADDWEB_SCORE_BOARD_WIDGET() {
    	$addweb_score_data = array('classname' => 'ADDWEB_SCORE_BOARD_WIDGET',
    								'description' => 'Display Live Score Of Matches.');
    	parent::WP_Widget('ADDWEB_SCORE_BOARD_WIDGET',$name = __('Football Match Score-Board','ADDWEB_SCORE_BOARD_WIDGET'), $addweb_score_data);

    	$this->addweb_sw_bg 	=	get_option('addweb_fa_sw_background_color');
    	$this->addweb_sw_td_bg  =	get_option('addweb_fa_sw_td_background_color');
    	$this->addweb_api_obj	=	new ADDWEB_FA_API();
    }
    
	// update widget
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['addweb_score_widget_title'] = sanitize_title(esc_sql($new_instance['addweb_score_widget_title']));
		$instance['addweb_score_widget_min_show'] = intval(esc_attr($new_instance['addweb_score_widget_min_show']));
		$instance['addweb_score_widget_fixture_days'] = intval(esc_attr($new_instance['addweb_score_widget_fixture_days']));
    return $instance;
	}

	// widget form creation
	public function form($instance) {
    //Check for values
    $filter_competition = array();
		if($instance) {
			$title = esc_attr($instance['addweb_score_widget_title']);
			$min_show = esc_attr($instance['addweb_score_widget_min_show']);
			$fix_days = esc_attr($instance['addweb_score_widget_fixture_days']);
		}
		else {
			$title = '';
			$max_show = '';
			$fixture_days = '';
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('addweb_score_widget_title'); ?>"><?php _e('Title', 'ADDWEB_SCORE_BOARD_WIDGET');?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('addweb_fa_title'); ?>" name="<?php echo $this->get_field_name('addweb_score_widget_title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('addweb_score_widget_min_show'); ?>"><?php _e('Minimum Show Matches', 'ADDWEB_SCORE_BOARD_WIDGET');?></label>
			<input type="number" size="3" class="widefat" id="<?php echo $this->get_field_id('addweb_score_widget_min_show'); ?>" name="<?php echo $this->get_field_name('addweb_score_widget_min_show'); ?>" value="<?php echo $min_show; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('addweb_score_widget_fixture_days'); ?>"><?php _e('Set Fixtures Days', 'ADDWEB_SCORE_BOARD_WIDGET');?></label><br/>
			<input type="number" size="3" class="widefat" id="<?php echo $this->get_field_id('addweb_score_widget_fixture_days'); ?>" name="<?php echo $this->get_field_name('addweb_score_widget_fixture_days'); ?>" value="<?php echo $fix_days; ?>" />
		</p>
		<?php 
	}

	public function widget($args, $instance) {
		echo '<div id="sc-widget-live-refresh">';
			$current_date = "match_date=".date('d-m-Y');
	        $today_match_data = $this->addweb_api_obj->addweb_fa_API('matches',array($current_date));
	        $live_match_data = $this->addweb_api_obj->addweb_fa_API('matches');
			extract($args);
			extract($instance);
			$addweb_score_widget_title = apply_filters('widget_title', $addweb_score_widget_title);
			if(empty($addweb_score_widget_title)){
				$addweb_score_widget_title = 'Score-Board';
			}
	        if(empty($addweb_score_widget_min_show) || $addweb_score_widget_min_show == 0){
	            $addweb_score_widget_min_show = 0;
	        }
	        $comp_date = date('d-m-Y');
	        $addweb_score_widget_filter_from_date = "from_date=".date('d-m-Y', strtotime($comp_date . '+1 day'));
	        if(empty($addweb_score_widget_fixture_days) || $addweb_score_widget_fixture_days == 0){
	        	$addweb_score_widget_filter_to_date = "to_date=".date('d-m-Y', strtotime($comp_date . '+1 day'));
	        }
	        else{
	        	$user_fixture_days = "+".$addweb_score_widget_fixture_days." day";
	        	$addweb_score_widget_filter_to_date = "to_date=".date('d-m-Y', strtotime($comp_date . $user_fixture_days));
	        }
	        $matchshowLimiter = 0;

	        $addweb_sw_style = '<style>';
	        	$addweb_sw_style .= '.addweb_score_board { background: '.$this->addweb_sw_bg.'; } ';
	        	$addweb_sw_style .= '.addweb-sw-active-tab { background-color: '.$this->addweb_sw_td_bg.'; } ';
	        	$addweb_sw_style .= '.addweb-sw-tab-color { background-color: transparent; } ';
	        	$addweb_sw_style .= '.addweb_score_board .addweb_score_board_left { background: '.$this->addweb_sw_td_bg.'; } ';
	        $addweb_sw_style .= '</style>';
			echo $before_widget;
				if(isset($today_match_data->error) && $today_match_data->error == 'Authorization field missing') {
					echo $addweb_sw_style;
					echo '<div class="addweb_score_board">';
						echo '<div class="addweb_score_board_title_background">';
							echo '<div class="addweb_score_board_title">';
								echo '<h2>'.$addweb_score_widget_title.'</h2>';
							echo '</div>';
							echo '<div class="addweb_score_board_img">';
							echo '</div>';
						echo '</div>';	
						echo '<div class="green-skin live" id="live">';
							echo '<div class="addweb_error_live_match_box">';
								echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> Please provide authorization key to access data.</span></div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				else {
					if(isset($today_match_data->error) && $today_match_data->error == 'Rate limit exceeded') {
						echo $addweb_sw_style;
						echo '<div class="addweb_score_board">';
							echo '<div class="addweb_score_board_title_background">';
								echo '<div class="addweb_score_board_title">';
									echo '<h2>'.$addweb_score_widget_title.'</h2>';
								echo '</div>';
								echo '<div class="addweb_score_board_img">';
								echo '</div>';
							echo '</div>';	
							echo '<div class="green-skin live" id="live">';
								echo '<div class="addweb_error_live_match_box">';
									echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> API access rate limit is finished please try after some time.</span></div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
					else {
						if(isset($today_match_data->api_error) && $today_match_data->api_error == 'API-Error') {
							echo $addweb_sw_style;
							echo '<div class="addweb_score_board">';
								echo '<div class="addweb_score_board_title_background">';
									echo '<div class="addweb_score_board_title">';
										echo '<h2>'.$addweb_score_widget_title.'</h2>';
									echo '</div>';
									echo '<div class="addweb_score_board_img">';
									echo '</div>';
								echo '</div>';	
								echo '<div class="green-skin live" id="live">';
									echo '<div class="addweb_error_live_match_box">';
										echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span></div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
						else {	
							echo $addweb_sw_style;
							echo '<div class="addweb_score_board">';
								echo '<div class="addweb_score_board_title_background">';
								echo '<div class="addweb_score_board_title">';
									echo '<h2>'.$addweb_score_widget_title.'</h2>';
								echo '</div>';
								if(get_option('addweb_fa_refersh') != 'auto-refresh') {
									echo '<div class="addweb_score_board_img">';
										echo '<button class="addweb-sw-active-tab" onclick="fun_score_widget_refresh();"><i class="fa fa-refresh fa-1x" id="sc-refresh"></i></button>';
									echo '</div>';
								}
								echo '</div>';
								echo '<div class="addweb_score_board_tab">';
									echo '<div class="addweb_score_board_tab_title addweb-sw-active-tab" id="addweb_score" ><a href="javascript:;">Today</a></div>';
									echo '<div class="addweb_score_board_tab_title" id="addweb_live"><a href="javascript:;">Live</a></div>';
									echo '<div class="addweb_score_board_tab_title" id="addweb_fixture"><a href="javascript:;">Fixtures</a></div>';
								echo '</div>';
								echo '<div class="green-skin score" id="score">';
								foreach ($today_match_data as $tm_key => $tm_value) {
				                    if(strlen($tm_value->localteam_name)>10){
				                        $localteam = substr($tm_value->localteam_name,0,10)."..";
				                    }
				                    else{
				                        $localteam = $tm_value->localteam_name;
				                    }
				                    if(strlen($tm_value->visitorteam_name)>10){
				                        $visitorteam = substr($tm_value->visitorteam_name,0,10)."..";
				                    }
				                    else{
				                        $visitorteam = $tm_value->visitorteam_name;
				                    }
				                    if($tm_value->localteam_score == '?' || empty($tm_value->localteam_score)) {
				                    	$local_score = "-";
				                    }
				                    else {
				                    	$local_score = $tm_value->localteam_score;
				                    }
				                    if($tm_value->visitorteam_score == '?' || empty($tm_value->visitorteam_score)) {
				                    	$visiter_score = "-";
				                    }
				                    else {
				                    	$visiter_score = $tm_value->visitorteam_score;
				                    }
				                    
				                    $time_zone =  get_option('timezone_string');
				                    if(empty($time_zone)) {
				                    	$offset = get_option('gmt_offset');
				                    	$time_zone = $this->addweb_sc_tw_offset_to_name($offset);
				                    	$match_time = date('H:i', strtotime($tm_value->time));
										$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
										$o_date->setTimeZone(new DateTimeZone($time_zone));
										$match_n_time = $o_date->format('H:i');
				                    }
				                    else {
				                    	$match_time = date('H:i', strtotime($tm_value->time));
										$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
										$o_date->setTimeZone(new DateTimeZone($time_zone));
										$match_n_time = $o_date->format('H:i');
				                    }
									
									echo '<div class="addweb_score_board_table">';
										echo '<div class="addweb_score_board_left">';
											echo '<span class="addweb_score_board_date">'.$tm_value->formatted_date.'</span>';
											echo '<span class="addweb_score_board_ft">'.$match_n_time.'</span>';
										echo '</div>';
										echo '<div class="addweb_score_board_right">';
											echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$tm_value->localteam_name.'">'.$localteam.'</abbr></div><div class="addweb_score_board_team_score">'.$local_score.'</div></span>';
											echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$tm_value->visitorteam_name.'">'.$visitorteam.'</abbr></div><div class="addweb_score_board_team_score">'.$visiter_score.'</div></span>';
										echo '</div>';
									echo '</div>';
				                    if($addweb_score_widget_min_show != 0){
				                        if($matchshowLimiter == $addweb_score_widget_min_show){
				                            break;
				                        }
				                    }
				                    $matchshowLimiter++;
								}
								echo '</div>';
								echo '<div class="green-skin live addweb-display-none" id="live">';
									if(isset($live_match_data->status) && $live_match_data->status == 'error') {
										echo '<div class="addweb_error_live_match_box">';
											echo '<br/><span>There are no matches at the moment.</span>';
										echo '</div>';
									}
									else {
										foreach ($live_match_data as $lm_key => $lm_value) {
						                    if(strlen($lm_value->localteam_name)>10){
						                        $localteam = substr($lm_value->localteam_name,0,10)."..";
						                    }
						                    else{
						                        $localteam = $lm_value->localteam_name;
						                    }
						                    if(strlen($tm_value->visitorteam_name)>10){
						                        $visitorteam = substr($lm_value->visitorteam_name,0,10)."..";
						                    }
						                    else{
						                        $visitorteam = $lm_value->visitorteam_name;
						                    }

						                    $time_zone_live =  get_option('timezone_string');
						                    if(empty($time_zone_live)) {
						                    	$offset_live = get_option('gmt_offset');
						                    	$time_zone_live = $this->addweb_sc_tw_offset_to_name($offset_live);
						                    	$match_time_live = date('H:i', strtotime($lm_value->time));
												$o_date_live = new DateTime($match_time_live, new DateTimeZone('Europe/Berlin'));
												$o_date_live->setTimeZone(new DateTimeZone($time_zone_live));
												$match_n_time_live = $o_date_live->format('H:i');
						                    }
						                    else {
						                    	$match_time_live = date('H:i', strtotime($lm_value->time));
												$o_date_live = new DateTime($match_time_live, new DateTimeZone('Europe/Berlin'));
												$o_date_live->setTimeZone(new DateTimeZone($time_zone_live));
												$match_n_time_live = $o_date_live->format('H:i');
						                    }
											echo '<div class="addweb_score_board_table">';
												echo '<div class="addweb_score_board_left">';
													echo '<span class="addweb_score_board_date">'.$lm_value->formatted_date.'</span>';
													echo '<span class="addweb_score_board_ft">'.$match_n_time_live.'</span>';
												echo '</div>';
												echo '<div class="addweb_score_board_right">';
													echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$lm_value->localteam_name.'">'.$localteam.'</abbr></div><div class="addweb_score_board_team_score">'.$lm_value->localteam_score.'</div></span>';
													echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$lm_value->visitorteam_name.'">'.$visitorteam.'</abbr></div><div class="addweb_score_board_team_score">'.$lm_value->visitorteam_score.'</div></span>';
												echo '</div>';
											echo '</div>';
										}
									}
								echo '</div>';
								$comp_data = $this->addweb_api_obj->addweb_fa_API('matches',array($addweb_score_widget_filter_from_date,$addweb_score_widget_filter_to_date));
								echo '<div class="green-skin fixture addweb-display-none" id="fixture">';
									foreach ($comp_data as $cm_key => $cm_value) {
					                    if(strlen($cm_value->localteam_name)>10){
					                        $localteam = substr($cm_value->localteam_name,0,10)."..";
					                    }
					                    else{
					                        $localteam = $cm_value->localteam_name;
					                    }
					                    if(strlen($cm_value->visitorteam_name)>10){
					                        $visitorteam = substr($cm_value->visitorteam_name,0,10)."..";
					                    }
					                    else{
					                        $visitorteam = $cm_value->visitorteam_name;
					                    }
										echo '<div class="addweb_score_board_table">';
					                        echo '<div class="addweb_score_board_left">';
					                            echo '<span class="addweb_score_board_date">'.$cm_value->formatted_date.'</span>';
					                            echo '<span class="addweb_score_board_ft">'.$cm_value->status.'</span>';
					                        echo '</div>';
					                        echo '<div class="addweb_score_board_right">';
					                            echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$cm_value->localteam_name.'">'.$localteam.'</abbr></div><div class="addweb_score_board_team_score"></div></span>';
					                            echo '<span class="addweb_score_board_team"><div class="addweb_score_board_team_name"><abbr title="'.$cm_value->visitorteam_name.'">'.$visitorteam.'</abbr></div><div class="addweb_score_board_team_score"></div></span>';
					                        echo '</div>';
					                    echo '</div>';
									}
								echo '</div>';
							echo '</div>';
						}
					}
				}
			echo $after_widget;
		echo '</div>';	
        ?>
            <script type="text/javascript">
                    jQuery(window).load(function () {
                    	jQuery("#score").customScrollbar();
	                    jQuery("#addweb_fixture").click(function() {
	                    	jQuery("#fixture").customScrollbar();
	                	});
	                	jQuery("#addweb_live").click(function() {
	                    	jQuery("#live").customScrollbar();
	                	});
                    });
                </script>
        <?php
	}
	function addweb_sc_tw_offset_to_name($offset) {
       $offset *= 3600; // convert hour offset to seconds
       $abbrarray = timezone_abbreviations_list();
       foreach ($abbrarray as $abbr) {
           foreach ($abbr as $city) {
               if ($city['offset'] == $offset) {
                    return $city['timezone_id'];
               }
           }
       }
		return FALSE;
	}
}
