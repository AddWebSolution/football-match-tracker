<?php
/**
 * API Class
 * @package   Football-API
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 **/

if ( ! defined('ABSPATH')) {
	exit;
}

class ADDWEB_FA_API {
	/**
	 * API EndPoint.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_endpoint;

	/**
	 * API Authentication Key.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_authentication;

	/**
	 * API Version.
	 * 
	 *
	 * @var string
	 */
	protected static $addweb_fa_version;
	
	function __construct(){
		$this->addweb_fa_endpoint 					= 		get_option('addweb_fa_api_endpoint');
		$this->addweb_fa_authentication 			= 		get_option('addweb_fa_api_authentication');
		$this->addweb_fa_version 					= 		get_option('addweb_fa_api_version');
	}

	//Get Response of called API
	public function addweb_fa_API($url, $params = array()) {
		$api_base_url = $this->addweb_fa_endpoint;
		$api_version = $this->addweb_fa_version;
		$api_key =  $this->addweb_fa_authentication;
		$final_url = $api_base_url.$api_version."/".$url;
		
		if(!empty($params)) {
			$count_params = count($params);
			if($count_params == 1 	&& is_numeric($params[0])) {
		    	$final_url .= "/".$params[0]."?Authorization=".$api_key;
		   }
		   else {
			    $listParams = implode("&", $params);
			    $final_url .= "?Authorization=" . $api_key;
			    $final_url .= "&" . $listParams;
		   }
		}
		else {
			$final_url .= "?Authorization=".$api_key;
		} 

		// // Get cURL resource
		// $addweb_fa_curl = curl_init();
		// // Set some options - we are passing in a useragent too here
		// curl_setopt($addweb_fa_curl, CURLOPT_URL, $final_url);
		// curl_setopt($addweb_fa_curl, CURLOPT_RETURNTRANSFER, 1);
		// // Send the request & save response to $resp
		// $result = curl_exec($addweb_fa_curl);
		// // Close request to clear up some resources
		// curl_close($addweb_fa_curl); 
		// $arrResult = json_decode($result);
		// return $arrResult;
		$result = wp_remote_get($final_url);
		if(is_wp_error($result)){
			$arrResult = json_decode('{"api_error": "API-Error"}');
			return $arrResult;
		}
		else{
			$arrResult = json_decode($result['body']);
			return $arrResult;
		}
	}
}