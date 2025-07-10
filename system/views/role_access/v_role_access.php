<style>
    :root {
        --primary-color: #4e73df;
        --bg-color: #f8f9fc;
        --text-color: #343a40;
        --muted-color: #6c757d;
        --card-shadow: rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Nunito', sans-serif;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0 20px var(--card-shadow);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid #dee2e6;
        font-weight: 700;
        color: var(--primary-color);
    }

    .menu-name {
        font-weight: 600;
        color: var(--text-color);
    }

    .submenu-name {
        margin-left: 1.5rem;
        font-weight: 500;
        color: var(--muted-color);
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    select.form-select {
        max-width: 300px;
    }

    .form-check-label {
        margin-left: 0.25rem;
    }
</style>

<section class="section">
    <div class="mb-3">
        <label for="outletSelect" class="form-label fw-bold">Outlet</label>
        <select id="outletSelect" class="form-select">
            <option selected>Bawean Dev</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="roleAccessSelect" class="form-label fw-bold">Role Access</label>
        <select id="roleAccessSelect" class="form-select select2">
            <option selected>Administrator</option>
            <option>Editor</option>
            <option>Viewer</option>
        </select>
    </div>

    <div class="card">
        <div class="card-header">
            <span>Menu List and Access Rights</span>
        </div>
        <div class="card-body">
            <?php echo $menu_view; ?>

            <!-- <div class="row fw-bold border-bottom pb-2 mb-2">
                <div class="col-md-3">Menu</div>
                <div class="col-md-1">Access</div>
                <div class="col-md-8">Role Access</div>
            </div>
            <div class="row align-items-center py-2 border-bottom">
                <div class="col-md-3">
                    <span class="menu-name">ASIK</span>
                </div>
                <div class="col-md-1">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
                <div class="col-md-8"></div>
            </div>
            <div class="row align-items-center py-2 border-bottom">
                <div class="col-md-3">
                    <span class="submenu-name">Data Karyawan</span>
                </div>
                <div class="col-md-1">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
                <div class="col-md-8 d-flex gap-3 flex-wrap">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editSalary1">
                        <label class="form-check-label" for="editSalary1">Edit Salary</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editPosition">
                        <label class="form-check-label" for="editPosition">Edit Position</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editStatus">
                        <label class="form-check-label" for="editStatus">Edit Status</label>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
