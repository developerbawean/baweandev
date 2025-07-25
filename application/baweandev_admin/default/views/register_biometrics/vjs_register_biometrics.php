<script>
   $('#scan_card').click(function () {
        $('#card_uid').val('Menunggu kartu...');
        $('#scan_card').prop('disabled', true).text('Scanning...');

        let pollingTime = 10000;
        let start = Date.now();

        let interval = setInterval(function () {
            $.get('http://192.168.4.1/get_uid', function (data) {
                if (data.uid) {
                    $('#card_uid').val(data.uid);
                    clearInterval(interval);
                    $('#scan_card').prop('disabled', false).html('<i class="ri-body-scan-line scan-group-icon"></i>');
                }
            }).fail(function () {
                console.log('ESP32 tidak merespon');
            });

            if (Date.now() - start > pollingTime) {
                clearInterval(interval);
                $('#scan_card').prop('disabled', false).html('<i class="ri-body-scan-line scan-group-icon"></i>');
                $('#card_uid').val('');
                alert('Gagal mendapatkan UID, coba lagi.');
            }
        }, 1000);
    });

    $('#biometricForm').submit(function (e) {
        e.preventDefault();
        const card_uid = $('#card_uid').val();
        if (!card_uid) {
            alert('Silakan scan kartu terlebih dahulu.');
            return;
        }

        $.ajax({
            url: app_url + 'register_biometrics/save',
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                $('#result').html('<div class="alert alert-success">Berhasil disimpan!</div>');
                $('#biometricForm')[0].reset();
            },
            error: function () {
                $('#result').html('<div class="alert alert-danger">Gagal menyimpan data.</div>');
            }
        });
    });