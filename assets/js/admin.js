//Color Picker, Custom Tabs
jQuery(document).ready(function(){
    jQuery('.color-picker').wpColorPicker();
});

//Setting tabs for plugin
jQuery(document).ready(function(){
    var addweb_tabs = jQuery( "#addweb_fa_api-settings" ).tabs({
        activate: function(event, ui) {

            //get the active tab index
            var activetab = jQuery("#addweb_fa_api-settings").tabs("option", "active");
            
            //save it to cookies
            var a = jQuery.cookie("tab", activetab)
        }
    });
    var addweb_active_tab_index = jQuery.cookie("tab");
    //make active needed tab
    if(addweb_active_tab_index !== undefined) {
        addweb_tabs.tabs("option", "active",addweb_active_tab_index);
    }

    if(jQuery('input[name="addweb_fa_refersh"]:checked').length > 0){
        var refresh_val = jQuery('input[name="addweb_fa_refersh"]:checked').val();
        if(refresh_val == 'manual-refresh') {
            jQuery('#ref-seconds').attr("readonly","readonly");
        }
        else {
            jQuery('#ref-seconds').removeAttr("readonly","readonly");
        }
    }    
});

function fun_enable() {
    jQuery('#ref-seconds').removeAttr("readonly","readonly");
}

function fun_disable() {
    jQuery('#ref-seconds').attr("readonly","readonly");
}