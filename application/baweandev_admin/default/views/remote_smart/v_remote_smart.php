<style>
    .lampu-status {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    #toggleBtn {
      width: 140px;
      height: 60px;
      font-weight: 700;
      font-size: 1.3rem;
      border: none;
    }
    .btn-on {
      background: #0d6efd;
      color: white;
    }
    .btn-off {
      background: #dc3545;
      color: white;
    }
  </style>
  <div class="text-center">
    <div class="lampu-status mb-3">
      Lampu sedang: 
      <span id="statusText" class="fw-bold <?= $status === 'on' ? 'text-success' : 'text-danger' ?>">
        <?= strtoupper($status) ?>
      </span>
    </div>

    <button id="toggleBtn" class="<?= $status === 'on' ? 'btn-off' : 'btn-on' ?>">
      <?= $status === 'on' ? 'Matikan' : 'Nyalakan' ?>
    </button>
  </div>
