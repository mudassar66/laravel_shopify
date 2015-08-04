jQuery(document).ready(function () {
	jQuery('#pwywSettingsForm').submit(function (e) {
		e.preventDefault();

		var data = jQuery(this).serialize();

		jQuery('.loading').removeClass("hide");
		jQuery.post("api.php?action=saveSettings&" + data, function (response) {

			response = jQuery.parseJSON(response);

			jQuery("#messageBox").attr("class", "")
				.addClass(response.class)
				.html(response.message);

			jQuery('.loading').addClass("hide");
		});

	});
});