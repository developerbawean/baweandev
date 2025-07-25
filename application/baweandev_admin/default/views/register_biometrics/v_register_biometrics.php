<style>
    .scan-group-icon {
        font-size: 26px;
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register Biometrics, Card UID / Fingerprint / Vein / Face</h5>

                <form id="biometricForm">
                    <div class="row mb-5">
                        <div class="col-sm-4">
                            <label class="form-label fw-bold">User</label>
                            <?php echo az_select_user(); ?>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-label fw-bold">Biometrics</label>

                            <div class="input-group mb-3">
                                <span class="input-group-text">Card UID</span>
                                <input type="text" class="form-control" name="card_uid" id="card_uid" placeholder="Scan UID card" readonly>
                                <button type="button" id="scan_card" class="btn btn-outline-secondary"><i class="ri-body-scan-line scan-group-icon"></i></button>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">Fingerprint</span>
                                <input type="text" class="form-control" name="fingerprint" id="fingerprint" placeholder="Scan Fingerprints">
                                <span class="input-group-text"><i class="ri-body-scan-line scan-group-icon"></i></span>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Vein</span>
                                <input type="text" class="form-control" name="vein" id="vein" placeholder="Scan Vein">
                                <span class="input-group-text"><i class="ri-body-scan-line scan-group-icon"></i></span>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Face</span>
                                <input type="text" class="form-control" name="face" id="face" placeholder="Scan Face">
                                <span class="input-group-text"><i class="ri-body-scan-line scan-group-icon"></i></span>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>

                <div id="result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
