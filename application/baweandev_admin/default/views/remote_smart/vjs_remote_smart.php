<script>
$('#toggleBtn').click(function() {
    $.ajax({
      url: app_url + 'remote_smart/toggle',  // Pastikan URL benar
      method: 'POST',
      dataType: 'json',  // Kita minta response json
      success: function(response) {
        if (response.status === 'on') {
          $('#statusText').text('ON').removeClass('text-danger').addClass('text-success');
          $('#toggleBtn').text('Matikan').removeClass('btn-on').addClass('btn-off');
        } else if (response.status === 'off') {
          $('#statusText').text('OFF').removeClass('text-success').addClass('text-danger');
          $('#toggleBtn').text('Nyalakan').removeClass('btn-off').addClass('btn-on');
        } else {
          alert('Response tidak dikenali: ' + JSON.stringify(response));
        }
      },
      error: function(xhr, status, error) {
        alert('Gagal mengubah status lampu: ' + error);
        console.error('Response error:', xhr.responseText);
      }
    });
  });