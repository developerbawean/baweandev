<script>
  // Menangani perubahan izin (permission)
    $('.access').on('change', function () {
        const permissionId = $(this).val();
        const isChecked = $(this).is(':checked') ? 1 : 0;
        // Umpan balik visual
        if (isChecked) {
            $(this).closest('.row').css('background-color', 'rgba(78, 115, 223, 0.05)');
        } else {
            $(this).closest('.row').css('background-color', '');
        }
    });

    // Menangani pemilihan role/menu navigasi
    $('.nav-link').on('click', function () {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    jQuery('.btn-submit').click(function(e) {
        e.preventDefault();

        var formData = jQuery('#form-role-access').serialize();

        $.ajax({
            url: app_url + 'role_access/save',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.err_code == 0) {
                    showTimedAlert('Success!', 'Role Management saved successfully.', 'success')
                        .then(() => {
                            location.reload();
                        });
                } else {
                    showAlertList('Error',response.err_message, 'error')
                }
            },
            error: function(xhr, status, error) {
                showAlert('Error','An error occurred on the server.', 'error')
            }
        });
    });

    jQuery('#idrole').change(function() {
        access_user_role();
    });

    jQuery(document).ready(function() {
        access_user_role();
    });

    function access_user_role() {
        jQuery('.access').prop('checked', false);
        jQuery.ajax({
            url: app_url+'role_access/generate_access',
            type: 'POST',
            dataType: 'JSON',
            data: {
                idrole: jQuery('#idrole').val()
            },
            success: function(response) {
                jQuery(response).each(function(reskey, resvalue) {
                    menu_name = resvalue.menu_name;
                    access = resvalue.access;

                    if (access == 1) {
                        jQuery('.access-'+menu_name).prop('checked', true);
                    }
                    else {
                        jQuery('.access-'+menu_name).prop('checked', false);	
                    }
                });
            },
            error: function(response) {
                console.log('error');
            }
        });
    }