<script>
    // sweetalert-helper
    // Alert sederhana
    function showAlertList(title = 'Hello!', html = 'Ini alert biasa', type = 'info') {
        return Swal.fire({
            title: title,
            html: html,
            icon: type,
            confirmButtonText: 'OK'
        });
    }

    function showAlert(title = 'Hello!', text = 'Ini alert biasa', type = 'info') {
        return Swal.fire({
            title: title,
            text: text,
            icon: type,
            confirmButtonText: 'OK'
        });
    }

    // Alert dengan timer otomatis (misal 2 detik)
    function showTimedAlert(title, text, type = 'info', timer = 2000) {
        return Swal.fire({
            title: title,
            text: text,
            icon: type,
            timer: timer,
            showConfirmButton: false,
            timerProgressBar: true
        });
    }

    // Alert konfirmasi dengan callback
    function showConfirmAlert(title, text, confirmCallback, cancelCallback, type = 'question') {
        Swal.fire({
            title: title,
            text: text,
            icon: type,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof confirmCallback === 'function') confirmCallback();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                if (typeof cancelCallback === 'function') cancelCallback();
            }
        });
    }

    // Alert dengan input (prompt)
    function showInputAlert(title, placeholder, callback) {
        Swal.fire({
            title: title,
            input: 'text',
            inputPlaceholder: placeholder,
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                if (typeof callback === 'function') callback(result.value);
            }
        });
    }

    // Alert loading (biasanya digunakan saat proses async)
    function showLoadingAlert(title = 'Mohon tunggu...') {
        Swal.fire({
            title: title,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // Alert sukses dengan redirect setelah konfirmasi
    function showSuccessRedirectAlert(title, text, redirectUrl) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonText: 'Lanjut'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = redirectUrl;
            }
        });
    }
    // end sweetalert-helper

    $(document).ready(function() {
        $('.select2').each(function() {
            const firstOptionText = $(this).find('option:first').text();

            $(this).select2({
                placeholder: firstOptionText,
                allowClear: true,
                width: '100%'
            });
        });
    });

    // action datatable
    function show_modal(id) {
        console.log(id);
        jQuery('.bd-modal-' + id).modal({
            backdrop: 'static',
            keyboard: true
        });
    }

    function edit(url, id, form, table_id, callback, edit_type) {
       
        // show_loading();
        // clear();
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                id: id,
            },
            success: function(response) {
                console.log(response);
                show_modal(table_id);
            },
            error: function(xhr) {
                
            },
        });

    };