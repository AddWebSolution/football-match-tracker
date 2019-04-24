jQuery(document).ready(function() {
	setInterval(function() {
    	jQuery("#match-refresh").load(location.href+" #match-refresh", function() {
    		//For Match Short-Code//
			jQuery('#today-match').click(function(){
				jQuery('#today-match').addClass('addweb-tab-active');
				jQuery('#today-match').removeClass('addweb_m_tab_color');
				jQuery('#live-match').addClass('addweb_m_tab_color');
				jQuery('#comming-match').addClass('addweb_m_tab_color');
				jQuery('#finished-match').addClass('addweb_m_tab_color');
				jQuery('#live-match').removeClass('addweb-tab-active');
				jQuery('#comming-match').removeClass('addweb-tab-active');
				jQuery('#finished-match').removeClass('addweb-tab-active');
				jQuery('#today_match').removeClass('addweb-display-none');
				jQuery('#live_match').addClass('addweb-display-none');
				jQuery('#fixture_match').addClass('addweb-display-none');
				jQuery('#finished_match').addClass('addweb-display-none');
			});
			jQuery('#live-match').click(function(){
				jQuery('#live-match').addClass('addweb-tab-active');
				jQuery('#live-match').removeClass('addweb_m_tab_color');
				jQuery('#today-match').addClass('addweb_m_tab_color');
				jQuery('#finished-match').addClass('addweb_m_tab_color');
				jQuery('#finished-match').removeClass('addweb-tab-active');
				jQuery('#comming-match').addClass('addweb_m_tab_color');
				jQuery('#today-match').removeClass('addweb-tab-active');
				jQuery('#comming-match').removeClass('addweb-tab-active');
				jQuery('#live_match').removeClass('addweb-display-none');
				jQuery('#today_match').addClass('addweb-display-none');
				jQuery('#fixture_match').addClass('addweb-display-none');
				jQuery('#finished_match').addClass('addweb-display-none');
			});
			jQuery('#comming-match').click(function(){
				jQuery('#comming-match').addClass('addweb-tab-active');
				jQuery('#comming-match').removeClass('addweb_m_tab_color');
				jQuery('#live-match').addClass('addweb_m_tab_color');
				jQuery('#today-match').addClass('addweb_m_tab_color');
				jQuery('#finished-match').addClass('addweb_m_tab_color');
				jQuery('#finished-match').removeClass('addweb-tab-active');
				jQuery('#today-match').removeClass('addweb-tab-active');
				jQuery('#live-match').removeClass('addweb-tab-active');
				jQuery('#fixture_match').removeClass('addweb-display-none');
				jQuery('#today_match').addClass('addweb-display-none');
				jQuery('#live_match').addClass('addweb-display-none');
				jQuery('#finished_match').addClass('addweb-display-none');
			});
			jQuery('#finished-match').click(function(){
				jQuery('#finished-match').addClass('addweb-tab-active');
				jQuery('#finished-match').removeClass('addweb_m_tab_color');
				jQuery('#live-match').addClass('addweb_m_tab_color');
				jQuery('#today-match').addClass('addweb_m_tab_color');
				jQuery('#comming-match').addClass('addweb_m_tab_color');
				jQuery('#comming-match').removeClass('addweb-tab-active');
				jQuery('#today-match').removeClass('addweb-tab-active');
				jQuery('#live-match').removeClass('addweb-tab-active');
				jQuery('#finished_match').removeClass('addweb-display-none');
				jQuery('#today_match').addClass('addweb-display-none');
				jQuery('#live_match').addClass('addweb-display-none');
				jQuery('#fixture_match').addClass('addweb-display-none');
			});
    	});
    }, refresh_seconds); // seconds to wait, miliseconds

	setInterval(function() {
    	jQuery("#cm-widget-live-refresh").load(location.href+" #cm-widget-live-refresh", function() {
    		jQuery("#addweb-commentary").customScrollbar();
    	});
	}, refresh_seconds); // seconds to wait, miliseconds

	setInterval(function() {
    	jQuery("#sc-widget-live-refresh").load(location.href+" #sc-widget-live-refresh", function() {
	    	jQuery("#score").customScrollbar();
        	jQuery("#addweb_fixture").click(function() {
				document.getElementById("addweb_fixture").click();
		    	jQuery("#fixture").customScrollbar();
			});
			jQuery("#addweb_live").click(function() {
				document.getElementById("addweb_live").click();
		    	jQuery("#live").customScrollbar();
			});
	    	
	    	/*Score Widget jQuery*/
			jQuery('#addweb_score').click(function(){
				jQuery('#addweb_score').addClass('addweb-sw-active-tab');
				jQuery('#addweb_live').removeClass('addweb-sw-active-tab');
				jQuery('#addweb_fixture').removeClass('addweb-sw-active-tab');
				jQuery('#score').removeClass('addweb-display-none');
				jQuery('#fixture').addClass('addweb-display-none');
				jQuery('#live').addClass('addweb-display-none');
			});
			jQuery('#addweb_live').click(function(){
				jQuery('#addweb_live').addClass('addweb-sw-active-tab');
				jQuery('#addweb_score').removeClass('addweb-sw-active-tab');
				jQuery('#addweb_fixture').removeClass('addweb-sw-active-tab');
				jQuery('#live').removeClass('addweb-display-none');
				jQuery('#fixture').addClass('addweb-display-none');
				jQuery('#score').addClass('addweb-display-none');
			});
			jQuery('#addweb_fixture').click(function(){
				jQuery('#addweb_fixture').addClass('addweb-sw-active-tab');
				jQuery('#addweb_score').removeClass('addweb-sw-active-tab');
				jQuery('#addweb_live').removeClass('addweb-sw-active-tab');
				jQuery('#fixture').removeClass('addweb-display-none');
				jQuery('#score').addClass('addweb-display-none');
				jQuery('#live').addClass('addweb-display-none');
			});
    	});
	}, refresh_seconds); // seconds to wait, miliseconds
});