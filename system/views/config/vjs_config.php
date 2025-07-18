<script>
    jQuery('body').on('change', '#province', function() {
		generate_city();
	});

	generate_city();
	function generate_city() {
		jQuery('#city').val('').trigger('change');
		jQuery('#city').html("<option value=''>~ select a city / district ~</option>");
		if (jQuery('#province').val() != "") {
			jQuery.ajax({
				url: app_url + 'data/get_city_by_province',
				type: 'POST',
				dataType: 'JSON',
				data: {
					id: jQuery('#province').val()
				},
				success: function(response) {
					var helper_city = jQuery('#helper_city').val();
					jQuery(response).each(function(adata, bdata) {						
						var opt = "<option value='"+bdata.idcity+"'>"+bdata.city_name+"</option>";
						jQuery('#city').append(opt)
					});
					if (helper_city != "") {
						jQuery('#city').val(helper_city).trigger('change');
					}
				},
				error: function(response) {}
			});
		}		
	}

	jQuery('#btn_save').click(function() {
		jQuery.ajax({
			url: app_url + 'config/save',
			type: 'POST',
			dataType: 'JSON',
			data: jQuery('#form_config').serialize(),
			success: function(response) {
				if (response.err_message != "") {
	                var err_response = response.err_message;
	                err_response = err_response.replace(/\n/g, "<br>");
	                showAlertList('Error',err_response, 'error')
	            }
	            else {
					showTimedAlert('Success!', 'Application Config saved successfully.', 'success')
					.then(() => {
						location.reload();
					});
	            }
			},
			error: function(response) {
				showAlertList('Error',err_response, 'error')
			}
		});
	});
	