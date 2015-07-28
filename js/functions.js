jQuery( document ).ready(function() {


jQuery('#pwywSettingsForm').submit(function(e) {
	
    e.preventDefault();
	
	var data = jQuery(this).serialize();
	var url = jQuery(this).attr('action');
	
	jQuery('.loading').removeClass("hide");
	jQuery.post("api.php?action=saveSettings&"+data, function(response){
		
		response = jQuery.parseJSON(response);
		
		jQuery("#messageBox").attr("class","");
		jQuery("#messageBox").addClass(response.class);
		jQuery("#messageBox").html(response.message);
		
		jQuery('.loading').addClass("hide");
	});
		
});


});