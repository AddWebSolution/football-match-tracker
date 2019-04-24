<?php
/**
 * ShortCode Class
 * @package   Football-API
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

if ( ! defined('ABSPATH')) {
	exit;
}
////API CLASS FOR GETTING API DATA FOR SHORTCODES
require_once plugin_dir_path(__FILE__) . 'api-class.php';

class ADDWEB_FA_SHORTCODE {
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
	 * API Call
	 * 
	 *
	 * @var api class object
	 */
	protected static $addweb_fa_api_call;

	function __construct(){
		$this->addweb_fa_background_color 				= 		get_option('addweb_fa_background_color');
		$this->addweb_fa_hover_color 					= 		get_option('addweb_fa_hover_color');
		$this->addweb_fa_tab_background_color 			=		get_option('addweb_fa_tab_background_color');
		$this->addweb_fa_tab_active_background_color	=		get_option('addweb_fa_tab_active_background_color');
		$this->addweb_fa_dt_background_color 			=		get_option('addweb_fa_dt_background_color');
		$this->addweb_fa_ct_background_color 			=		get_option('addweb_fa_ct_background_color');
		$this->addweb_fa_mb_background_color 			=		get_option('addweb_fa_mb_background_color');
		$this->addweb_fa_mb_hover_background_color		=		get_option('addweb_fa_mb_hover_background_color');
		$this->addweb_fa_api_call						=		new ADDWEB_FA_API();
	}

	public function addweb_fa_matchList($match_atts) {
		$tab_type = shortcode_atts(array('show-tab' => 'today|live|fixture','finished-match-days' => '', 'fixture-days' => ''),$match_atts);
		$match_style = '<style>';
			$match_style .= '.addweb-tab-active { background: '.$this->addweb_fa_tab_active_background_color.';}';
			$match_style .= '.addweb_m_tab_color {background: '.$this->addweb_fa_tab_background_color.';}';
			$match_style .= '.addweb_m_tabs .addweb_m_tab:hover {background: '.$this->addweb_fa_tab_active_background_color.';}';
			$match_style .= '.addweb-match tr {background: '.$this->addweb_fa_mb_background_color.';}';
			$match_style .= '.addweb-comp-date {background: '.$this->addweb_fa_ct_background_color.';}';
			$match_style .= '.addweb-info-header h3 {background: '.$this->addweb_fa_dt_background_color.';}';
			$match_style .= '.addweb-match tr:hover {background: '.$this->addweb_fa_mb_hover_background_color.';}';
		$match_style .= '</style>';
		if(!($_GET['Mteam_id']) && !($_GET['match_id']) && !($_GET['cm_id']) && !($_GET['comp_id']) && !($_GET['player_id'])) {
			if($tab_type['show-tab']!=''){
				$tabs = explode("|", $tab_type['show-tab']);
				$match_data = '<div class="addweb-match-data" id="match-refresh">';
					$current_match_date = 'match_date='.date('d-m-Y');
					$match_api_data = $this->addweb_fa_api_call->addweb_fa_API('matches', array($current_match_date));
					if(isset($match_api_data->error) && $match_api_data->error == 'Authorization field missing') {
						$match_data .= '<div style="background:#d3d3d3 !important; border-left:4px solid #f70000 !important;">';
							$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000 !important; margin-left:5px !important;"></i>';
							$match_data .= '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
						$match_data .= '</div>';
					}
					else {
						if(isset($match_api_data->error) && $match_api_data->error == 'Rate limit exceeded') {
							$match_data .= '<div style="background:#d3d3d3 !important; border-left:4px solid #f70000 !important;">';
								$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000 !important; margin-left:5px !important;"></i>';
								$match_data .= '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
							$match_data .= '</div>';
						}
						else {
							if(isset($match_api_data->api_error) && $match_api_data->api_error == 'API-Error') {
								$match_data .= '<div style="background:#d3d3d3 !important; border-left:4px solid #f70000 !important;">';
									$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000 !important; margin-left:5px !important;"></i>';
									$match_data .= '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
								$match_data .= '</div>';
							}
							else {
								foreach ($match_api_data as $match_api_key => $match_api_value) {
									$match_data_info[$match_api_value->comp_id][] = $match_api_value;
								}
								$match_data .= '<section class= "add-matchdays-wrapper">';
								$match_data .= '<div class="addweb_tabs_div">';
								$match_data .= '<ul class="addweb_m_tabs">';
								for($tab_i=0; $tab_i<sizeof($tabs); $tab_i++) {
									if($tab_i==0) {
										$active_tab = 'addweb-tab-active';
										$active_class = 'addweb-display-none';
									}
									else {
										$active_tab = 'addweb_m_tab_color';
										$active_class = '';
									}
									switch ($tabs[$tab_i]) {
										case 'live':
											$match_data .= '<li class="addweb_m_tab '.$active_tab.'" id="live-match">Live</li>';
										break;

										case 'today':
											$match_data .= '<li class="addweb_m_tab '.$active_tab.'" id="today-match">Today</li>';
										break;

										case 'fixture':
											$match_data .= '<li class="addweb_m_tab '.$active_tab.'" id="comming-match">Fixture</li>';
										break;

										case 'finished':
											$match_data .= '<li class="addweb_m_tab '.$active_tab.'" id="finished-match">Finished</li>';
										break;
									}
								}
								$match_data .= '</ul>';
								$match_data .= '</div>';
								if(get_option('addweb_fa_refersh') != 'auto-refresh') {
									$match_data .= '<div class="addweb_m_refresh">';
      									$match_data .= '<button class="addweb_m_tab_color" onclick="fun_refresh_button_match();"><i class="fa fa-refresh fa-1x" id="ma-refresh"></i></button>';
      								$match_data .= '</div>';
								}
								for($tab_data=0; $tab_data<sizeof($tabs); $tab_data++) {
									if($tab_data==0) {
										$active_class = '';
									}
									else {
										$active_class = 'addweb-display-none';
									}
									switch ($tabs[$tab_data]) {
										case 'live':
											//live match div
											$live_match = $this->addweb_fa_api_call->addweb_fa_API('matches');
											$match_data .= '<div id="live_match" class="'.$active_class.'">';
												$match_data .= '<section >';
													$match_data .= '<header class="addweb-info-header">';
														$match_data .= '<h3>'.date("l, jS F Y").'</h3>';
													$match_data .= '</header>';
													if(isset($live_match->status) && $live_match->status == 'error'){
														$match_data .= '<table class="addweb-matches">';
															$match_data .= '<tbody class="addweb-match">';
																$match_data .= '<tr>';
																	$match_data .= '<td class="addweb-status">';
																		$match_data .= '<span>There are no matches at the moment.</span>';
																	$match_data .= '</td>';
																$match_data .= '</tr>';	
															$match_data .= '</tbody>';
														$match_data .= '</table>';		
													}
													else {
														$match_data .= '<table class="addweb-matches">';
														$match_data .= '<tbody class="addweb-match">';
														foreach ($live_match as $live_match_key => $live_match_value) {
															$time_zone =  get_option('timezone_string');
																if(empty($time_zone)) {
																	$offset = get_option('gmt_offset');
		                    										$time_zone = $this->addweb_tw_offset_to_name($offset);
		                    										$match_time = date('H:i', strtotime($live_match_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$live_match_n_time = $o_date->format('H:i');
																}
																else{
																	$match_time = date('H:i', strtotime($live_match_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$live_match_n_time = $o_date->format('H:i');
																}
																
																$match_data .= '<tr>';
																	$match_data .= '<td class="addweb-status">';
																		$match_data .= '<span>'.$live_match_n_time.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$live_match_value->localteam_id.'">'.$live_match_value->localteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-vs">';
																		$match_data .= '<span>'.$live_match_value->localteam_score.' - '.$live_match_value->visitorteam_score.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$live_match_value->visitorteam_id.'">'.$live_match_value->visitorteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-matchdata">';
																		$match_data .= '<a href="?match_id='.$live_match_value->id.'">Match Details</a>';
																	$match_data .= '</td>';
																$match_data .= '</tr>';
														}
														$match_data .= '</tbody>';
														$match_data .= '</table>';
													}
												$match_data .= '</section>';
											$match_data .= '</div>';
										break;
										
										case 'fixture':
											//Fixture div
											$current_date = date('d-m-Y');
											$start_date = "from_date=".date('d-m-Y', strtotime($current_date . '+1 day'));
											if($tab_type['fixture-days'] == ''){
												$end_date = "to_date=".date('d-m-Y', strtotime($current_date . '+2 day'));
											}
											else{
												$fix_days = "+".$tab_type['fixture-days']." day";
												$end_date = "to_date=".date('d-m-Y', strtotime($current_date . $fix_days));
											}
											
											
											$fix_data = $this->addweb_fa_api_call->addweb_fa_API('matches', array($start_date, $end_date));
											foreach ($fix_data as $fix_key => $fix_value) {
												$fixture_data[$fix_value->formatted_date][$fix_value->comp_id][] = $fix_value;
											}
											$match_data .= '<div id="fixture_match" class="'.$active_class.'">';
											foreach ($fixture_data as $fixture_key => $fixture_value) {
												$match_data .= '<section>';
													$match_data .= '<header class="addweb-info-header">';
														$match_data .= '<h3>'.date("l, jS F Y", strtotime($fixture_key)).'</h3>';
													$match_data .= '</header>';
													foreach ($fixture_value as $fix_comp_key => $fix_comp_value) {
														$fix_comp_name_data = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($fix_comp_key));
														$match_data .= '<table class="addweb-matches">';
															$match_data .= '<thead>';
																$match_data .= '<tr class="addweb-subheader">';
																	$match_data .= '<th colspan="5" class="addweb-comp-date">';
																		$match_data .= '<span><a href="?comp_id='.$fix_comp_key.'">'.$fix_comp_name_data->name.'</a></span>';
																	$match_data .= '</th>';
																$match_data .= '</tr>';
															$match_data .= '</thead>';
															$match_data .= '<tbody class="addweb-match">';
															foreach ($fix_comp_value as $fix_main_key => $fix_main_value) {
																$time_zone =  get_option('timezone_string');
																if(empty($time_zone)) {
																	$offset = get_option('gmt_offset');
		                    										$time_zone = $this->addweb_tw_offset_to_name($offset);
		                    										$match_time = date('H:i', strtotime($fix_main_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$fix_match_n_time = $o_date->format('H:i');
																}
																else{
																	$match_time = date('H:i', strtotime($fix_main_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$fix_match_n_time = $o_date->format('H:i');
																}
																
																$match_data .= '<tr>';
																	$match_data .= '<td class="addweb-status">';
																		$match_data .= '<span>'.$fix_match_n_time.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$fix_main_value->localteam_id.'">'.$fix_main_value->localteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-vs">';
																		$match_data .= '<span> V/S </span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$fix_main_value->visitorteam_id.'">'.$fix_main_value->visitorteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-matchdata">';
																		$match_data .= '<a href="?match_id='.$fix_main_value->id.'">Match Details</a>';
																	$match_data .= '</td>';
																$match_data .= '</tr>';
															}
															$match_data .= '</tbody>';
														$match_data .= '</table>';	
													}
												$match_data .= '</section>';
											}
											$match_data .= '</div>';
										break;

										case 'today':
											$match_data .= '<div id="today_match" class="'.$active_class.'">';
												$match_data .= '<section class="addweb-matchday">';
													$match_data .= '<header class="addweb-info-header">';
														$match_data .= '<h3>'.date("l, jS F Y").'</h3>';
													$match_data .= '</header>';
													foreach ($match_data_info as $match_data_key => $match_data_value) {
														$comp_name_data = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($match_data_key));
														$match_data .= '<table class="addweb-matches">';
															$match_data .= '<thead>';
																$match_data .= '<tr class="addweb-subheader">';
																	$match_data .= '<th colspan="5" class="addweb-comp-date">';
																		$match_data .= '<span><a href="?comp_id='.$match_data_key.'">'.$comp_name_data->name.'</a></span>';
																	$match_data .= '</th>';
																$match_data .= '</tr>';
															$match_data .= '</thead>';
															$match_data .= '<tbody class="addweb-match">';
															foreach ($match_data_value as $match_info_key => $match_info_value) {
																if($fix_main_value->localteam_score == '?' && $fix_main_value->visitorteam_score == '?' || empty($fix_main_value->localteam_score) && empty($fix_main_value->visitorteam_score)){
																	$score = "V/S";
																}
																else{
																	$score = $fix_main_value->localteam_score."  -  ".$fix_main_value->visitorteam_score;
																}
																$time_zone =  get_option('timezone_string');
																if(empty($time_zone)) {
																	$offset = get_option('gmt_offset');
		                    										$time_zone = $this->addweb_tw_offset_to_name($offset);
		                    										$match_time = date('H:i', strtotime($match_info_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$t_match_n_time = $o_date->format('H:i');
		                    									}
																else {
																	$match_time = date('H:i', strtotime($match_info_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$t_match_n_time = $o_date->format('H:i');
																}
																
																$match_data .= '<tr>';
																	$match_data .= '<td class="addweb-status">';
																		$match_data .= '<span>'.$t_match_n_time.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$match_info_value->localteam_id.'">'.$match_info_value->localteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-vs">';
																		$match_data .= '<span> '.$score.' </span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$match_info_value->visitorteam_id.'">'.$match_info_value->visitorteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-matchdata">';
																		$match_data .= '<a href="?match_id='.$match_info_value->id.'">View Details</a>';
																	$match_data .= '</td>';
																$match_data .= '</tr>';
															}
															$match_data .= '</tbody>';
														$match_data .= '</table>';
													}
												$match_data .= '</section>';
											$match_data .= '</div>';
										break;

										case 'finished':
											//Finished Match
											$curr_date = date('d-m-Y');
											$old_end_date = "to_date=".date('d-m-Y', strtotime($curr_date . '-1 day'));
											if($tab_type['finished-match-days'] == ''){
												$old_start_date = "from_date=".date('d-m-Y', strtotime($curr_date . '-1 day'));
											}
											else{
												$days = "-".$tab_type['finished-match-days']." day";
												$old_start_date = "from_date=".date('d-m-Y', strtotime($curr_date . $days));
											}
											$fin_data = $this->addweb_fa_api_call->addweb_fa_API('matches', array($old_start_date, $old_end_date));
											foreach ($fin_data as $fin_key => $fin_value) {
												$finished_data[$fin_value->formatted_date][$fin_value->comp_id][] = $fin_value;
											}
											$match_data .= '<div id="finished_match" class="'.$active_class.'">';
											foreach ($finished_data as $finished_key => $finished_value) {
												$match_data .= '<section>';
													$match_data .= '<header class="addweb-info-header">';
														$match_data .= '<h3>'.date("l, jS F Y", strtotime($finished_key)).'</h3>';
													$match_data .= '</header>';
													foreach ($finished_value as $fin_comp_key => $fin_comp_value) {
														$fin_comp_name_data = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($fin_comp_key));
														$match_data .= '<table class="addweb-matches">';
															$match_data .= '<thead>';
																$match_data .= '<tr class="addweb-subheader">';
																	$match_data .= '<th colspan="5" class="addweb-comp-date">';
																		$match_data .= '<span><a href="?comp_id='.$fin_comp_key.'">'.$fin_comp_name_data->name.'</a></span>';
																	$match_data .= '</th>';
																$match_data .= '</tr>';
															$match_data .= '</thead>';
															$match_data .= '<tbody class="addweb-match">';
															foreach ($fin_comp_value as $fin_main_key => $fin_main_value) {
																$time_zone =  get_option('timezone_string');
																if(empty($time_zone)) {
																	$offset = get_option('gmt_offset');
		                    										$time_zone = $this->addweb_tw_offset_to_name($offset);
		                    										$match_time = date('H:i', strtotime($fin_main_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$fin_match_n_time = $o_date->format('H:i');
		                    									}
																else {
																	$match_time = date('H:i', strtotime($fin_main_value->time));
																	$o_date = new DateTime($match_time, new DateTimeZone('Europe/Berlin'));
																	$o_date->setTimeZone(new DateTimeZone($time_zone));
																	$fin_match_n_time = $o_date->format('H:i');
																}
																
																$match_data .= '<tr>';
																	$match_data .= '<td class="addweb-status">';
																		$match_data .= '<span>'.$fin_match_n_time.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$fin_main_value->localteam_id.'">'.$fin_main_value->localteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-vs">';
																		$match_data .= '<span>'.$fin_main_value->localteam_score.'  -  '.$fin_main_value->visitorteam_score.'</span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-team">';
																		$match_data .= '<span><a href="?Mteam_id='.$fin_main_value->visitorteam_id.'">'.$fin_main_value->visitorteam_name.'</a></span>';
																	$match_data .= '</td>';
																	$match_data .= '<td class="addweb-matchdata">';
																		$match_data .= '<a href="?match_id='.$fin_main_value->id.'">Match Details</a>';
																	$match_data .= '</td>';
																$match_data .= '</tr>';
															}
															$match_data .= '</tbody>';
														$match_data .= '</table>';	
													}
												$match_data .= '</section>';
											}
											$match_data .= '</div>';
										break;
									}
								}
								$match_data .= '</section>';
							}
						}
					}
				$match_data .= '</div>';
				echo $match_style;
				echo $match_data;
			}
		}
		//Team Information
		if($_GET['Mteam_id'] && !empty($_GET['Mteam_id'])) {
			$team_info = $this->addweb_fa_api_call->addweb_fa_API('team', array($_GET['Mteam_id']));
			if(isset($team_info->error) && $team_info->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else{
				if(isset($team_info->error) && $team_info->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else {
					if(isset($team_info->api_error) && $team_info->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						echo "<font style='font-size:20px;font-weight:bold'>".$team_info->name."</font> <span> (".$team_info->country.")</span>";
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb_team_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';

						$comp_name = '<table class="addweb_team_table">';
							$comp_name .= '<thead>';
								$comp_name .= '<tr>';
									$comp_name .= '<th>Is National</th>';
									$comp_name .= '<th>Coach Name</th>';
									$comp_name .= '<th>Rank</th>';
									$comp_name .= '<th>Total Wins</th>';
									$comp_name .= '<th>Total Lose</th>';
									$comp_name .= '<th>Total Goals</th>';
								$comp_name .= '</tr>';
							$comp_name .= '</thead>';
							$comp_name .= '<tbody>';
								$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$team_info->is_national.'</label></td>';
									$comp_name .= '<td><label>'.$team_info->coach_name.'</label></td>';
									foreach ($team_info->statistics as $team_info_key => $team_info_value) {
										$comp_name .= '<td><label>'.$team_info_value->rank.'</label></td>';
										$comp_name .= '<td><label>'.$team_info_value->wins.'</label></td>';
										$comp_name .= '<td><label>'.$team_info_value->losses.'</label></td>';
										$comp_name .= '<td><label>'.$team_info_value->goals.'</label></td>';
									}
								$comp_name .= '</tr>';
							$comp_name .= '</tbody>';
						$comp_name .= '</table>';

						$comp_name .= '<div>';
						$comp_name .= '<label><b>Leagues : </b></label><p>';
						if(!empty($team_info->leagues)) {
							$leagues_info = explode(",", $team_info->leagues);
							foreach ($leagues_info as $leagues_value) {
								$competitions_info = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($leagues_value));
								$comp_name .= '<a href=?comp_id='.$competitions_info->id.'>'.$competitions_info->name.'</a>, ';
							}		
						}
						else {
							$comp_name .= 'Not Played In Any Leagues.';
						}
						$comp_name .= '</p></div>';

						$comp_name .= '<div>';
						$comp_name .= '<label><b>Team Players : </b></label>';
						$comp_name .= '<table class="addweb_team_table">';
						$comp_name .= '<tr>';
						$comp_name .= '<th><label>Player Name</label></th>';
						$comp_name .= '<th><label>Player Number</label></th>';
						$comp_name .= '</tr>';
						foreach ($team_info->squad as $player_info_key => $player_info_value) {
							$comp_name .= '<tr>';
							$comp_name .= '<td><label><a href=?player_id='.$player_info_value->id.'>'.$player_info_value->name.'</a></label></td>';
							$comp_name .= '<td><label>'.$player_info_value->number.'</label></td>';
							$comp_name .= '</tr>';
						}	
						$comp_name .= '</table>';	
						$comp_name .= '</div>';
						echo $addweb_shortcode_style;
						echo $comp_name;
					}
				}
			}
		}
		//Competiotion Information
		if($_GET['comp_id'] && !empty($_GET['comp_id'])) {
			$matches_by_competition = $this->addweb_fa_api_call->addweb_fa_API('standings', array($_GET['comp_id']));
			$competiotion_info_data = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($_GET['comp_id']));
			if(isset($matches_by_competition->error) && $matches_by_competition->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else {
				if(isset($matches_by_competition->error) && $matches_by_competition->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else{
					if(isset($matches_by_competition->api_error) && $matches_by_competition->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						$arrGroupWiseInfoData = array();
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb-standings .addweb_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
							$addweb_shortcode_style .= '.addweb-btn {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
							$addweb_shortcode_style .= '.addweb-btn:hover, addweb-btn:active {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_hover_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';
						foreach($matches_by_competition as $matches_by_competition_key => $matches_by_competition_data){
							$arrGroupWiseInfoData[$matches_by_competition_data->comp_group][] = $matches_by_competition_data;
						}
						$comp_name1 = '<div>';
							$comp_name1 .= '<div>';
								$comp_name1 .= '<div>';
									$comp_name1 .= '<span class="addweb-st-comp-name">'.$competiotion_info_data->name.'</span><span class="addweb-st-comp-region">('.$competiotion_info_data->region.')</span>';
								$comp_name1 .= '</div>';
								$comp_name1 .= '<div>';
									$comp_name1 .= 'Standings';
								$comp_name1 .= '</div>';
							$comp_name1 .= '</div>';
							$comp_name1 .= '<div>';
								$comp_name1 .= 'Group stage';
							$comp_name1 .= '</div>';
							echo $comp_name1;
						foreach ($arrGroupWiseInfoData as $arrGroupWiseInfoData_key => $arrGroupWiseInfoData_value) {
							$div = '<div class="addweb-group-link">';
							if(!empty($arrGroupWiseInfoData_key)) {
								$div1 .= '<a class="addweb-btn" href="#matchgroup_'.str_replace("Group","",$arrGroupWiseInfoData_key).'">'.str_replace("Group","",$arrGroupWiseInfoData_key).'</a>';
							}
							else{
								$div1 .= '<span style="font-size:12px;">No group available this competition.<span>';
							}
							$div2 = '</div>';
							$comp_name .= '<div id="matchgroup_'.str_replace("Group","",$arrGroupWiseInfoData_key).'" style="height: 35px"></div>';
							$comp_name .= '<div class="addweb-standings">';
							 	$comp_name .= '<h3 class="addweb-group-title addweb-innerText">'.$arrGroupWiseInfoData_key.'</h3>';
							 	$comp_name .= '<table class="addweb_table">';
							 		$comp_name .= '<thead>';
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<th colspan="3"></th>';
							 				$comp_name .= '<th colspan="3" class="addweb-dcol addweb-th-text-align">Home</th>';
							 				$comp_name .= '<th colspan="3" class="addweb-dcol addweb-th-text-align">Away</th>';
							 				$comp_name .= '<th colspan="4" class="addweb-dcol addweb-th-text-align">Total</th>';
							 				$comp_name .= '<th colspan="1" class="addweb-dcol"></th>';
							 			$comp_name .= '</tr>';
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<th><abbr title="Position"></abbr></th>';
							 				$comp_name .= '<th class="addweb-club addweb-w160 addweb-l">Team</th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Round">R</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Goal difference">+/-</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Points">Pts</abbr></th>';
							 			$comp_name .= '</tr>';
							 		$comp_name .= '</thead>';
							 		$comp_name .= '<tbody>';
							 foreach ($arrGroupWiseInfoData_value as $arrinfo_key => $arrinfo_value) {
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<td class="addweb-w30 addweb-innerText">'.$arrinfo_value->position.'</td>';
							 				$comp_name .= '<td class="addweb-club addweb-w160 addweb-l"><a href=?Mteam_id='.$arrinfo_value->team_id.'>'.$arrinfo_value->team_name.'</a></td>';
							 				$comp_name .= '<td>'.$arrinfo_value->round.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$arrinfo_value->home_w.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->home_d.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->home_l.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$arrinfo_value->away_w.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->away_d.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->away_l.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$arrinfo_value->overall_w.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->overall_d.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->overall_l.'</td>';
							 				$comp_name .= '<td>'.$arrinfo_value->gd.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$arrinfo_value->points.'</td>';
							 			$comp_name .= '</tr>';
							 }
								$comp_name .= '</tbody>';
							$comp_name .= '</table>';
							$comp_name .= '</div>';
						}
						$comp_name .= '</div>';
						echo $addweb_shortcode_style;
						echo $div;
						echo $div1;
						echo $div2;
						echo $comp_name;
					}
				}
			}
		}
		//Match Details
		if($_GET['match_id'] && !empty($_GET['match_id'])) {
			$md_score='';
			$match_flag = '';
			$match_data = '<div>';
				$matches_Details = $this->addweb_fa_api_call->addweb_fa_API('matches', array($_GET['match_id']));
				if(isset($matches_Details->error) && $matches_Details->error == 'Authorization field missing') {
					$match_data .= '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						$match_data .= '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
					$match_data .= '</div>';
				}
				else {
					if(isset($matches_Details->error) && $matches_Details->error == 'Rate limit exceeded') {
						$match_data .= '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							$match_data .= '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
						$match_data .= '</div>';
					}
					else{
						if(isset($matches_Details->api_error) && $matches_Details->api_error == 'API-Error') {
							$match_data .= '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
								$match_data .= '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
								$match_data .= '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
							$match_data .= '</div>';
						}
						else {
							$comp_name_data = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($matches_Details->comp_id));
							$commentary_details = $this->addweb_fa_api_call->addweb_fa_API('commentaries', array($_GET['match_id']));
								$time_zone_dtp =  get_option('timezone_string');
								if(empty($time_zone_dtp)) {
									$offset_dtp = get_option('gmt_offset');
									$time_zone_dtp = $this->addweb_tw_offset_to_name($offset_dtp);
									$match_time_dtp = date('H:i', strtotime($matches_Details->time));
									$o_date_dtp = new DateTime($match_time_dtp, new DateTimeZone('Europe/Berlin'));
									$o_date_dtp->setTimeZone(new DateTimeZone($time_zone_dtp));
									$match_n_time_dtp = $o_date_dtp->format('H:i');
								}
								else {
									$match_time_dtp = date('H:i', strtotime($matches_Details->time));
									$o_date_dtp = new DateTime($match_time_dtp, new DateTimeZone('Europe/Berlin'));
									$o_date_dtp->setTimeZone(new DateTimeZone($time_zone_dtp));
									$match_n_time_dtp = $o_date_dtp->format('H:i');
								}
								if($matches_Details->localteam_score == '?' && $matches_Details->visitorteam_score == '?' || empty($matches_Details->localteam_score) && empty($matches_Details->visitorteam_score)) {
									$md_score = "V/S";
									$match_flag = "false";
								}
								else {
									$md_score = $matches_Details->localteam_score."  -  ".$matches_Details->visitorteam_score;
								}
							$match_data .= '<section class= "add-matchdays-wrapper">';
								$match_data .= '<ul class="addweb_m_tabs">';
									$match_data .= '<li class="addweb_m_tab addweb-tab-active" id="match-details">Match Info</li>';
									$match_data .= '<li class="addweb_m_tab addweb_m_tab_color" id="match-commentary">Commentary</li>';
								$match_data .= '</ul>';
								$match_data .= '<div id="match_details" class="">';
									$match_data .= '<section class="addweb-matchday">';
										$match_data .= '<header class="addweb-info-header">';
											$match_data .= '<h3>'.date("l, jS F Y", strtotime($matches_Details->formatted_date)).'</h3>';
										$match_data .= '</header>';
										$match_data .= '<table class="addweb-matches">';
												$match_data .= '<thead>';
													$match_data .= '<tr class="addweb-subheader">';
														$match_data .= '<th colspan="5" class="addweb-comp-date">';
															$match_data .= '<span><a href="?comp_id='.$matches_Details->comp_id.'">'.$comp_name_data->name.'</a></span>';
														$match_data .= '</th>';
													$match_data .= '</tr>';
												$match_data .= '</thead>';
												$match_data .= '<tbody class="addweb-match">';
													$match_data .= '<tr>';
														$match_data .= '<td colspan="2">';
															$match_data .= '<span> Season : '.$matches_Details->season.'</span>';
														$match_data .= '</td>';
														$match_data .= '<td></td>';	
														$match_data .= '<td colspan="2">';
															$match_data .= '<span> Week : '.$matches_Details->week.'</span>';
														$match_data .= '</td>';
													$match_data .= '</tr>';
													$match_data .= '<tr>';
														$match_data .= '<td colspan="5">';
															$match_data .= '<span> Venue : '.$matches_Details->venue.'</span>';
														$match_data .= '</td>';
													$match_data .= '</tr>';
													$match_data .= '<tr>';
														$match_data .= '<td colspan="5">';
															$match_data .= '<span> Venue City : '.$matches_Details->venue_city.'</span>';
														$match_data .= '</td>';
													$match_data .= '</tr>';
													$match_data .= '<tr>';
														$match_data .= '<td class="addweb-status">';
															$match_data .= '<span>'.$match_n_time_dtp.'</span>';
														$match_data .= '</td>';
														$match_data .= '<td class="addweb-team">';
															$match_data .= '<span><a href="?Mteam_id='.$matches_Details->localteam_id.'">'.$matches_Details->localteam_name.'</a></span>';
														$match_data .= '</td>';
														$match_data .= '<td class="addweb-vs">';
															$match_data .= '<span>'.$md_score.'</span>';
														$match_data .= '</td>';
														$match_data .= '<td class="addweb-team">';
															$match_data .= '<span><a href="?Mteam_id='.$matches_Details->visitorteam_id.'">'.$matches_Details->visitorteam_name.'</a></span>';
														$match_data .= '</td>';
														$match_data .= '<td class="addweb-matchdata"></td>';
													$match_data .= '</tr>';
												$match_data .= '</tbody>';
											$match_data .= '</table>';
									$match_data .= '</section>';
								$match_data .= '</div>';
								//commentary
								$match_data .= '<div class="addweb-display-none" id="commentary_data">';
									$match_data .= '<section class="addweb-matchday">';
										$match_data .= '<header class="addweb-info-header">';
											$match_data .= '<h3>'.date("l, jS F Y", strtotime($matches_Details->formatted_date)).'</h3>';
										$match_data .= '</header>';
										$match_data .= '<table class="addweb-matches">';
											$match_data .= '<thead>';
												$match_data .= '<tr class="addweb-subheader">';
													$match_data .= '<th colspan="5" class="addweb-comp-date">';
														$match_data .= '<span><a href="?comp_id='.$matches_Details->comp_id.'">'.$comp_name_data->name.'</a></span>';
													$match_data .= '</th>';
												$match_data .= '</tr>';
											$match_data .= '</thead>';
											$match_data .= '<tbody class="addweb-match">';
												$match_data .= '<tr>';
													$match_data .= '<td class="addweb-status">';
														$match_data .= '<span>'.$matches_Details->time.'</span>';
													$match_data .= '</td>';
													$match_data .= '<td class="addweb-team">';
														$match_data .= '<span><a href="?Mteam_id='.$matches_Details->localteam_id.'">'.$matches_Details->localteam_name.'</a></span>';
													$match_data .= '</td>';
													$match_data .= '<td class="addweb-vs">';
														$match_data .= '<span>'.$md_score.'</span>';
													$match_data .= '</td>';
													$match_data .= '<td class="addweb-team">';
														$match_data .= '<span><a href="?Mteam_id='.$matches_Details->visitorteam_id.'">'.$matches_Details->visitorteam_name.'</a></span>';
													$match_data .= '</td>';
													$match_data .= '<td class="addweb-matchdata"></td>';
												$match_data .= '</tr>';
												if($match_flag == 'false'){
													$match_data .= '<tr>';
														$match_data .= '<td colspan="5">';
															$match_data .= '<span>The match has not started yet.</span>';
														$match_data .= '</td>';
													$match_data .= '</tr>';
												}
												else{
													foreach ($commentary_details as $comment_key => $comment_value) {
														$match_data .= '<tr>';
															$match_data .= '<td colspan="5">';
																$match_data .= '<span><b>Comments : </b>'.$comment_value->comment.'</span>';
															$match_data .= '</td>';
														$match_data .= '</tr>';
													}
												}	
											$match_data .= '</tbody>';
										$match_data .= '</table>';
									$match_data .= '</section>';
								$match_data .= '</div>';
							$match_data .= '</section>';
						}
					}
				}
			$match_data .= '</div>';
			echo $match_style;
			echo $match_data;
		}
		//Player Details
		if($_GET['player_id'] && !empty($_GET['player_id'])) {
			$player_info = $this->addweb_fa_api_call->addweb_fa_API('player', array($_GET['player_id']));
			if(isset($player_info->error) && $player_info->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else {
				if(isset($player_info->error) && $player_info->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else{
					if(isset($player_info->api_error) && $player_info->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						echo "<font style='font-size:20px;font-weight:bold'>".$player_info->name."</font> <span> (".$player_info->team.")</span>";
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb_player_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';

						$comp_name = '<table class="addweb_player_table" >';
						$comp_name .= '<tr>';
						$comp_name .= '<th><label>Full Name</label></th>';
						$comp_name .= '<th><label>Nationality</label></th>';
						$comp_name .= '<th><label>Age</label></th>';
						$comp_name .= '<th><label>Position</label></th>';
						$comp_name .= '<th><label>Height</label></th>';
						$comp_name .= '<th><label>Weight</label></th>';
						$comp_name .= '</tr>';
						$comp_name .= '<tr>';
						$comp_name .= '<td><label>'.$player_info->firstname.' '.$player_info->lastname.'</label></td>';
						$comp_name .= '<td><label>'.$player_info->nationality.'</label></td>';
						$comp_name .= '<td><label>'.$player_info->age.'</label></td>';
						$comp_name .= '<td><label>'.$player_info->position.'</label></td>';
						$comp_name .= '<td><label>'.$player_info->height.'</label></td>';
						$comp_name .= '<td><label>'.$player_info->weight.'</label></td>';
						$comp_name .= '</tr>';
						$comp_name .= '</table>';
						foreach ($player_info->player_statistics as $pstatistic_key => $pstatistic_value) {
							if($pstatistic_key == 'club') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Club : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($pstatistic_value as $pclub_key => $pclub_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$pclub_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($pstatistic_key == 'cups') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Cups : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($pstatistic_value as $pcups_key => $pcups_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$pcups_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$pcups_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($pstatistic_key == 'club_intl') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Club Initial : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($pstatistic_value as $pclub_intl_key => $pclub_intl_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$pclub_intl_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$pclub_intl_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($pstatistic_key == 'national') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>National : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($pstatistic_value as $pnational_key => $pnational_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$pnational_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$pnational_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}
						}
						echo $addweb_shortcode_style;
						echo $comp_name;
					}
				}
			}
		}
	}

	public function addweb_fa_competitionsList() {
		if(!($_GET['cp_id']) && !($_GET['team_id']) && !($_GET['pl_id'])) {
			$competitions = $this->addweb_fa_api_call->addweb_fa_API('competitions');
			// print_r($competitions);
			if(isset($competitions->error) && $competitions->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else {
				if(isset($competitions->error) && $competitions->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else {
					if(isset($competitions->api_error) && $competitions->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						$comp_name = '<table class="table" >';
						foreach ($competitions as $index => $competition_value) {
							$comp_name .= '<tr>';
							$comp_name .= '<td> <label><a href="?cp_id='.$competition_value->id.'">' . $competition_value->name . '</a></label></td>';
							$comp_name .= '</tr>';
						}
						$comp_name .= '</table>';
						echo $comp_name;
					}
				}
			}
		}
		if($_GET['cp_id']) {
			$standings = $this->addweb_fa_api_call->addweb_fa_API('standings', array($_GET['cp_id']));
			$Competiotion_info = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($_GET['cp_id']));
			if(isset($standings->error) && $standings->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else {
				if(isset($standings->error) && $standings->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else {
					if(isset($standings->api_error) && $standings->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						$arrGroupWiseInfo = array();
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb-standings .addweb_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
							$addweb_shortcode_style .= '.addweb-btn {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
							$addweb_shortcode_style .= '.addweb-btn:hover, addweb-btn:active {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_hover_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';
						foreach($standings as $groupkey => $groupdata){
							$arrGroupWiseInfo[$groupdata->comp_group][] = $groupdata;
						}
						$comp_name1 = '<div>';
							$comp_name1 .= '<div>';
								$comp_name1 .= '<div>';
									$comp_name1 .= '<span class="addweb-st-comp-name">'.$Competiotion_info->name.'</span><span class="addweb-st-comp-region">('.$Competiotion_info->region.')</span>';
								$comp_name1 .= '</div>';
								$comp_name1 .= '<div>';
									$comp_name1 .= 'Standings';
								$comp_name1 .= '</div>';
							$comp_name1 .= '</div>';
							$comp_name1 .= '<div>';
								$comp_name1 .= 'Group stage';
							$comp_name1 .= '</div>';
							echo $comp_name1;
						foreach ($arrGroupWiseInfo as $arrGroupWiseInfokey => $arrGroupWiseInfovalue) {
							$div = '<div class="addweb-group-link">';
							if(!empty($arrGroupWiseInfokey)) {
								$div1 .= '<a class="addweb-btn" href="#matchgroup_'.str_replace("Group","",$arrGroupWiseInfokey).'">'.str_replace("Group","",$arrGroupWiseInfokey).'</a>';
							}
							else{
								$div1 .= '<span style="font-size:12px;">No group available this competition.<span>';
							}
							$div2 = '</div>';
							$comp_name .= '<div id="matchgroup_'.str_replace("Group","",$arrGroupWiseInfokey).'" style="height: 35px"></div>';
							$comp_name .= '<div class="addweb-standings">';
							 	$comp_name .= '<h3 class="addweb-group-title addweb-innerText">'.$arrGroupWiseInfokey.'</h3>';
							 	$comp_name .= '<table class="addweb_table">';
							 		$comp_name .= '<thead>';
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<th colspan="3"></th>';
							 				$comp_name .= '<th colspan="3" class="addweb-dcol addweb-th-text-align">Home</th>';
							 				$comp_name .= '<th colspan="3" class="addweb-dcol addweb-th-text-align">Away</th>';
							 				$comp_name .= '<th colspan="4" class="addweb-dcol addweb-th-text-align">Total</th>';
							 				$comp_name .= '<th colspan="1" class="addweb-dcol"></th>';
							 			$comp_name .= '</tr>';
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<th><abbr title="Position"></abbr></th>';
							 				$comp_name .= '<th class="addweb-club addweb-w160 addweb-l">Team</th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Round">R</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Won">W</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Draw">D</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Lose">L</abbr></th>';
							 				$comp_name .= '<th class="addweb-th-text-align"><abbr title="Goal difference">+/-</abbr></th>';
							 				$comp_name .= '<th class="addweb-dcol addweb-th-text-align"><abbr title="Points">Pts</abbr></th>';
							 			$comp_name .= '</tr>';
							 		$comp_name .= '</thead>';
							 		$comp_name .= '<tbody>';
							 foreach ($arrGroupWiseInfovalue as $stkey => $standing_value) {
							 			$comp_name .= '<tr>';
							 				$comp_name .= '<td class="addweb-w30 addweb-innerText">'.$standing_value->position.'</td>';
							 				$comp_name .= '<td class="addweb-club addweb-w160 addweb-l"><a href=?team_id='.$standing_value->team_id.'>'.$standing_value->team_name.'</a></td>';
							 				$comp_name .= '<td>'.$standing_value->round.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$standing_value->home_w.'</td>';
							 				$comp_name .= '<td>'.$standing_value->home_d.'</td>';
							 				$comp_name .= '<td>'.$standing_value->home_l.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$standing_value->away_w.'</td>';
							 				$comp_name .= '<td>'.$standing_value->away_d.'</td>';
							 				$comp_name .= '<td>'.$standing_value->away_l.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$standing_value->overall_w.'</td>';
							 				$comp_name .= '<td>'.$standing_value->overall_d.'</td>';
							 				$comp_name .= '<td>'.$standing_value->overall_l.'</td>';
							 				$comp_name .= '<td>'.$standing_value->gd.'</td>';
							 				$comp_name .= '<td class="addweb-dcol">'.$standing_value->points.'</td>';
							 			$comp_name .= '</tr>';
							 }
								$comp_name .= '</tbody>';
							$comp_name .= '</table>';
							$comp_name .= '</div>';
						}
						$comp_name .= '</div>';
						echo $addweb_shortcode_style;
						echo $div;
						echo $div1;
						echo $div2;
						echo $comp_name;
					}
				}
			}
		}
		if($_GET['team_id']) {
			$team_details = $this->addweb_fa_api_call->addweb_fa_API('team', array($_GET['team_id']));
			if(isset($team_details->error) && $team_details->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">Please provide authorization key to access data.</span>';
				echo '</div>';
			}
			else {
				if(isset($team_details->error) && $team_details->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else {
					if(isset($team_details->api_error) && $team_details->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						echo "<font style='font-size:20px;font-weight:bold'>".$team_details->name."</font> <span> (".$team_details->country.")</span>";
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb_team_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';

						$comp_name = '<table class="addweb_team_table">';
							$comp_name .= '<thead>';
								$comp_name .= '<tr>';
									$comp_name .= '<th>Is National</th>';
									$comp_name .= '<th>Coach Name</th>';
									$comp_name .= '<th>Rank</th>';
									$comp_name .= '<th>Total Wins</th>';
									$comp_name .= '<th>Total Lose</th>';
									$comp_name .= '<th>Total Goals</th>';
								$comp_name .= '</tr>';
							$comp_name .= '</thead>';
							$comp_name .= '<tbody>';
								$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$team_details->is_national.'</label></td>';
									$comp_name .= '<td><label>'.$team_details->coach_name.'</label></td>';
									foreach ($team_details->statistics as $team_key => $team_value) {
										$comp_name .= '<td><label>'.$team_value->rank.'</label></td>';
										$comp_name .= '<td><label>'.$team_value->wins.'</label></td>';
										$comp_name .= '<td><label>'.$team_value->losses.'</label></td>';
										$comp_name .= '<td><label>'.$team_value->goals.'</label></td>';
									}
								$comp_name .= '</tr>';
							$comp_name .= '</tbody>';
						$comp_name .= '</table>';

						$comp_name .= '<div>';
						$comp_name .= '<label><b>Leagues : </b></label><p>';
						if(!empty($team_details->leagues)) {
							$leaguess = explode(",", $team_details->leagues);
							foreach ($leaguess as $league_value) {
								$competitions = $this->addweb_fa_api_call->addweb_fa_API('competitions', array($league_value));
								$comp_name .= '<a href=?cp_id='.$competitions->id.'>'.$competitions->name.'</a>, ';
							}		
						}
						else {
							$comp_name .= 'Not Played In Any Leagues.';
						}
						$comp_name .= '</p></div>';

						$comp_name .= '<div>';
						$comp_name .= '<label><b>Team Players : </b></label>';
						$comp_name .= '<table class="addweb_team_table">';
						$comp_name .= '<tr>';
						$comp_name .= '<th><label>Player Name</label></th>';
						$comp_name .= '<th><label>Player Number</label></th>';
						$comp_name .= '</tr>';
						foreach ($team_details->squad as $player_key => $player_value) {
							$comp_name .= '<tr>';
							$comp_name .= '<td><label><a href=?pl_id='.$player_value->id.'>'.$player_value->name.'</a></label></td>';
							$comp_name .= '<td><label>'.$player_value->number.'</label></td>';
							$comp_name .= '</tr>';
						}	
						$comp_name .= '</table>';	
						$comp_name .= '</div>';
						echo $addweb_shortcode_style;
						echo $comp_name;
					}
				}
			}
		}
		if($_GET['pl_id']) {
			$player_details = $this->addweb_fa_api_call->addweb_fa_API('player', array($_GET['pl_id']));
			if(isset($player_details->error) && $player_details->error == 'Authorization field missing') {
				echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
					echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
					echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
				echo '</div>';
			}
			else {
				if(isset($player_details->error) && $player_details->error == 'Rate limit exceeded') {
					echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
						echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
						echo '<span style="top: -8px;left: 24px;position: relative;">API access rate limit is finished please try after some time.</span>';
					echo '</div>';
				}
				else {
					if(isset($player_details->api_error) && $player_details->api_error == 'API-Error') {
						echo '<div style="background:#d3d3d3; border-left:4px solid #f70000" class="addweb-match-data">';
							echo '<i class="fa fa-times fa-3x" style="color:#f70000;margin-left:5px;"></i>';
							echo '<span style="top: -8px;left: 24px;position: relative;">API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span>';
						echo '</div>';
					}
					else {
						echo "<font style='font-size:20px;font-weight:bold'>".$player_details->name."</font> <span> (".$player_details->team.")</span>";
						$addweb_shortcode_style = '<style>';
							$addweb_shortcode_style .= '.addweb_player_table th {';
								$addweb_shortcode_style .= 'background: '.$this->addweb_fa_background_color.';';
							$addweb_shortcode_style .= '}';
						$addweb_shortcode_style .= '</style>';

						$comp_name = '<table class="addweb_player_table" >';
						$comp_name .= '<tr>';
						$comp_name .= '<th><label>Full Name</label></th>';
						$comp_name .= '<th><label>Nationality</label></th>';
						$comp_name .= '<th><label>Age</label></th>';
						$comp_name .= '<th><label>Position</label></th>';
						$comp_name .= '<th><label>Height</label></th>';
						$comp_name .= '<th><label>Weight</label></th>';
						$comp_name .= '</tr>';
						$comp_name .= '<tr>';
						$comp_name .= '<td><label>'.$player_details->firstname.' '.$player_details->lastname.'</label></td>';
						$comp_name .= '<td><label>'.$player_details->nationality.'</label></td>';
						$comp_name .= '<td><label>'.$player_details->age.'</label></td>';
						$comp_name .= '<td><label>'.$player_details->position.'</label></td>';
						$comp_name .= '<td><label>'.$player_details->height.'</label></td>';
						$comp_name .= '<td><label>'.$player_details->weight.'</label></td>';
						$comp_name .= '</tr>';
						$comp_name .= '</table>';
						foreach ($player_details->player_statistics as $statistic_key => $statistic_value) {
							if($statistic_key == 'club') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Club : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($statistic_value as $club_key => $club_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$club_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$club_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($statistic_key == 'cups') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Cups : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($statistic_value as $cups_key => $cups_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$cups_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$cups_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($statistic_key == 'club_intl') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>Club Initial : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($statistic_value as $club_intl_key => $club_intl_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$club_intl_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$club_intl_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}

							if($statistic_key == 'national') {
								$comp_name .= '<div>';
								$comp_name .= '<label><b>National : </b></label>';
								$comp_name .= '<table class="addweb_player_table" >';
								$comp_name .= '<tr>';
								$comp_name .= '<th><label>Club Name</label></th>';
								$comp_name .= '<th><label>League</label></th>';
								$comp_name .= '<th><label>Season</label></th>';
								$comp_name .= '<th><label>Goals</label></th>';
								$comp_name .= '<th><label>Yellow Cards</label></th>';
								$comp_name .= '<th><label>Red Cards</label></th>';
								$comp_name .= '<th><label>Yellow Red</label></th>';
								$comp_name .= '</tr>';
								foreach ($statistic_value as $national_key => $national_value) {
									$comp_name .= '<tr>';
									$comp_name .= '<td><label>'.$national_value->name.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->league.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->season.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->goals.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->yellowcards.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->redcards.'</label></td>';
									$comp_name .= '<td><label>'.$national_value->yellowred.'</label></td>';
									$comp_name .= '</tr>';
									
								}
								$comp_name .= '</table>';
								$comp_name .= '</div>';
							}
						}
						echo $addweb_shortcode_style;
						echo $comp_name;
					}
				}
			}
		}
	}
	function addweb_tw_offset_to_name($offset)
	{
       $offset *= 3600; // convert hour offset to seconds
       $abbrarray = timezone_abbreviations_list();
       foreach ($abbrarray as $abbr)
       {
           foreach ($abbr as $city)
           {
               if ($city['offset'] == $offset)
               {
                    return $city['timezone_id'];
               }
           }
       }
		return FALSE;
	}
}