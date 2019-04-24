<?php 
/**
 * Football-API Commentary Widget
 * @package   Football-API
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//API CLASS FOR GETTING API DATA FOR COMMENTARY DATA
require_once plugin_dir_path( __FILE__ ) . 'api-class.php';

class ADDWEB_COMMENTARY_WIDGET extends WP_Widget {

    /*API OBJECT*/
    protected static $addweb_api_object;

    public function ADDWEB_COMMENTARY_WIDGET() {
    	$addweb_commentary_data = array('classname' => 'ADDWEB_COMMENTARY_WIDGET',
    								'description' => 'Display Live Matches Commentary.');
    	parent::WP_Widget('ADDWEB_COMMENTARY_WIDGET',$name = __('Football Match Commentary','ADDWEB_COMMENTARY_WIDGET'), $addweb_commentary_data);

        $this->addweb_api_object = new ADDWEB_FA_API();
    }

    public function update($new_instance, $old_instance) {
    	$instance = $old_instance;

    	$instance['addweb_commentary_widget_title'] = esc_sql($new_instance['addweb_commentary_widget_title']);
    	return $instance;
    }

    public function form($instance) {
    	if($instance) {
    		$title = esc_attr($instance['addweb_commentary_widget_title']);
    	}
    	else {
			$title = '';
    	}?>
    	<p>
    		<label for="<?php echo $this->get_field_id('addweb_commentary_widget_title'); ?>"><?php _e('Title', 'ADDWEB_COMMENTARY_WIDGET'); ?></label>

    		<input type="text" id="<?php echo $this->get_field_id('addweb_commentary_widget_title');?>" name="<?php echo $this->get_field_name('addweb_commentary_widget_title');?>" class="widefat" value="<?php echo $title; ?>">
    	</p><?php
    }

    public function widget($args, $instance) {
        echo '<div id="cm-widget-live-refresh">';
            $match_data = $this->addweb_api_object->addweb_fa_API('matches');
    		extract($args);
    		extract($instance);
    		$addweb_commentary_widget_title = apply_filters('widget_title',$addweb_commentary_widget_title);
    		if(empty($addweb_commentary_widget_title)){
    			$addweb_commentary_widget_title = 'Commentary';
    		}
            $comentary_widget_style = '<style>';
            $comentary_widget_style .= '.addweb_commentary_board_background {background :'.get_option("addweb_fa_cw_background_color").' !important ;}';
            $comentary_widget_style .= '.addweb_commentary_team_title_background { background: '.get_option("addweb_fa_cw_title_background_color").' !important ;}';
            $comentary_widget_style .= '.addweb_commentary_comment_box_background { background : '.get_option("addweb_fa_cw_cb_background_color").' !important ;}';
            $comentary_widget_style .= '.addweb_commentary_team_title_font_color { color : '.get_option("addweb_fa_cw_stf_color").' !important ;}';
            $comentary_widget_style .= '.addweb_commentary_comment_font_color { color : '.get_option("addweb_fa_cw_cbf_color").' !important ;}';
            $comentary_widget_style .= '</style>';
    		echo $before_widget;
                if(isset($match_data->error) && $match_data->error == 'Authorization field missing') {
                    echo $comentary_widget_style;
                    echo '<div class="addweb_commentary_board addweb_commentary_board_background">';
                        echo '<div class="addweb_commentary_board_title_background">';
                            echo '<div class="addweb_commentary_board_title">';
                                echo '<h2>'.$addweb_commentary_widget_title.'</h2>';
                            echo '</div>';
                            echo '<div class="addweb_score_board_img">';
                            echo '</div>';
                        echo '</div>'; 
                        echo '<div class="addweb_commentary_board_table">';
                            echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background">';
                            echo '</div>';
                            echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> Please provide authorization key to access data.</span></div>';
                            echo '</div>';  
                        echo '</div>';    
                    echo '</div>';
                }
                else {
                    if(isset($match_data->error) && $match_data->error == 'Rate limit exceeded' || isset($match_data->error) && $match_data->error == 'Rate limit exceeded') {
                        echo $comentary_widget_style;
                        echo '<div class="addweb_commentary_board addweb_commentary_board_background">';
                            echo '<div class="addweb_commentary_board_title_background">';
                                echo '<div class="addweb_commentary_board_title">';
                                    echo '<h2>'.$addweb_commentary_widget_title.'</h2>';
                                echo '</div>';
                                echo '<div class="addweb_score_board_img">';
                                echo '</div>';
                            echo '</div>'; 
                            echo '<div class="addweb_commentary_board_table">';
                                echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background">';
                                echo '</div>';
                                echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                    echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> API access rate limit is finished please try after some time.</span></div>';
                                echo '</div>';  
                            echo '</div>';    
                        echo '</div>';
                    }
                    else {
                        if(isset($match_data->api_error) && $match_data->api_error == 'API-Error' || isset($match_data->api_error) && $match_data->api_error == 'API-Error') {
                            echo $comentary_widget_style;
                            echo '<div class="addweb_commentary_board addweb_commentary_board_background">';
                                echo '<div class="addweb_commentary_board_title_background">';
                                    echo '<div class="addweb_commentary_board_title">';
                                        echo '<h2>'.$addweb_commentary_widget_title.'</h2>';
                                    echo '</div>';
                                    echo '<div class="addweb_score_board_img">';
                                    echo '</div>';
                                echo '</div>'; 
                                echo '<div class="addweb_commentary_board_table">';
                                    echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background">';
                                    echo '</div>';
                                    echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                        echo '<div style="padding:20px"><span style="color:red;font-size: 15px;font-weight: bold;"><i class="fa fa-times fa-1x" style="color:#f70000;"></i> API Not Responding Please Click <a href="javascript:;" onclick="window.location.reload(true);">Here</a> For Try Again.</span></div>';
                                    echo '</div>';  
                                echo '</div>';    
                            echo '</div>';
                        }
                        else {
                            echo $comentary_widget_style;
                            echo '<div class="addweb_commentary_board addweb_commentary_board_background">';
                                echo '<div class="addweb_commentary_board_title_background">';
                                    echo '<div class="addweb_commentary_board_title">';
                                        echo '<h2>'.$addweb_commentary_widget_title.'</h2>';
                                    echo '</div>';
                                    if(get_option('addweb_fa_refersh') != 'auto-refresh') {
                                        echo '<div class="addweb_score_board_img">';
                                            echo '<button class="addweb_commentary_team_title_background" onclick="fun_commentary_widget_refresh();"><i class="fa fa-refresh fa-1x" id="cm-refresh"></i></button>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                                echo '<div>';
                                    if(isset($match_data->status) && $match_data->status == 'error') {
                                        echo '<div class="addweb_commentary_board_table">';
                                            echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background">';
                                            echo '</div>';
                                            
                                            echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                                echo '<div class="addweb_no_comment addweb_commentary_comment_font_color"><span>Sorry No Live Match In Progress.</span></div>';
                                            echo '</div>';  
                                        echo '</div>';  
                                    }
                                    else {
                                        if(count($match_data) == 1) {
                                            // print_r($match_data);
                                            if(strlen($match_data[0]->localteam_name)>8){
                                            $localteam = substr($match_data[0]->localteam_name,0,8)."..";
                                            }
                                            else{
                                                $localteam = $match_data[0]->localteam_name;
                                            }
                                            if(strlen($match_data[0]->visitorteam_name)>8){
                                                $visitorteam = substr($match_data[0]->visitorteam_name,0,8)."..";
                                            }
                                            else{
                                                $visitorteam = $match_data[0]->visitorteam_name;
                                            }
                                            echo '<div class="addweb_commentary_board_table">';
                                                echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background addweb_commentary_team_title_font_color">';
                                                    echo '<h3><abbr title="'.$match_data[0]->localteam_name.'">'.$localteam.'</abbr> <span class="addweb_commentary_team_score">'.$match_data->localteam_score.'</span> <span class="addweb_team_vs"> V/S </span> <abbr title="'.$match_data[0]->visitorteam_name.'">'.$visitorteam.'</abbr> <span class="addweb_commentary_team_score">'.$match_data->visitorteam_score.'</span></h3>';
                                                echo '</div>';
                                                
                                                echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                                $commentary_data = $this->addweb_api_object->addweb_fa_API('commentaries',array($match_data[0]->id));
                                                    echo '<div style="padding-left:2px; text-align:center;" class="addweb_commentary_comment_font_color"><span><b style="font-size:15px">Venue</b> : <b>'.$match_data[0]->venue.'</b></span></div>';
                                                    foreach ($commentary_data->comments as $com_key => $com_value) {
                                                        echo '<div style="padding:8px" class="addweb_commentary_comment_font_color"><span>Comments : '.$com_value->comment.'</span></div>';
                                                    }
                                                echo '</div>';  
                                            echo '</div>';
                                        }
                                        else{
                                            foreach ($match_data as $match_data_key => $match_data_value) {
                                                if(strlen($match_data_value->localteam_name)>8){
                                                    $localteam = substr($match_data_value->localteam_name,0,8)."..";
                                                }
                                                else{
                                                    $localteam = $match_data_value->localteam_name;
                                                }
                                                if(strlen($match_data_value->visitorteam_name)>8){
                                                    $visitorteam = substr($match_data_value->visitorteam_name,0,8)."..";
                                                }
                                                else{
                                                    $visitorteam = $match_data_value->visitorteam_name;
                                                }
                                                echo '<div class="addweb_commentary_board_table">';
                                                    echo '<div class="addweb_commentary_team_title addweb_commentary_team_title_background addweb_commentary_team_title_font_color">';
                                                        echo '<h3><abbr title="'.$match_data_value->localteam_name.'">'.$localteam.'</abbr> <span class="addweb_commentary_team_score">'.$match_data_value->localteam_score.'</span> <span class="addweb_team_vs"> V/S </span> <abbr title="'.$match_data_value->visitorteam_name.'">'.$visitorteam.'</abbr> <span class="addweb_commentary_team_score">'.$match_data_value->visitorteam_score.'</span></h3>';
                                                    echo '</div>';
                                                    
                                                    echo '<div class="addweb_commentary_board_box addweb_commentary_comment_box_background green-skin1" id="addweb-commentary">';
                                                    $commentary_data = $this->addweb_api_object->addweb_fa_API('commentaries',array($match_data_value->id));
                                                        echo '<div style="padding-left:2px; text-align:center;" class="addweb_commentary_comment_font_color"><span><b style="font-size:15px">Venue</b> : <b>'.$match_data_value->venue.'</b></span></div>';
                                                        foreach ($commentary_data->comments as $com_key => $com_value) {
                                                            echo '<div style="padding:8px" class="addweb_commentary_comment_font_color"><span>Comments : '.$com_value->comment.'</span></div>';
                                                        }
                                                    echo '</div>';  
                                                echo '</div>';
                                                break;
                                            }
                                        }
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
                        jQuery("#addweb-commentary").customScrollbar();
                    });
            </script>
        <?php
    }
}
 