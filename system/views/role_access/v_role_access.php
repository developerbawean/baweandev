<style>
    :root {
        --primary-color: #4e73df;
        --bg-color: #f8f9fc;
        --text-color: #343a40;
        --muted-color: #6c757d;
        --card-shadow: rgba(0, 0, 0, 0.05);
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
    .content-form{
        padding-bottom: 15px;
    }
</style>

<section class="section">
    <form id="form-role-access" name="form-role-access" method="POST" action="<?php echo app_url();?>role_access/save">
        <div class="row content-form">
            <div class="col-md-2">
                <label class="form-label fw-bold">Outlet</label>
                <?php echo az_select_outlet(); ?>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Role Access</label>
                <select class="form-select select2" name="idrole" id="idrole">
                    <?php
                        foreach ($role->result() as $key => $value) {
                            echo '<option value="'.$value->idrole.'">'.$value->title.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span>Menu List and Access Rights</span>
            </div>
            <div class="card-body">
                <div class="row fw-bold border-bottom pb-2 mb-2">
                    <div class="col-md-3">Menu</div>
                    <div class="col-md-1">Access</div>
                    <div class="col-md-8">Role Access</div>
                </div>
                <?php echo $menu_view; ?>
            </div>
            <div style="text-align: left; padding: 20px 15px;">
                <button class="btn btn-primary btn-submit" type="button"><i class="ri-save-3-fill"></i> Save Role Access</button>
            </div>
        </div>
    </form>
</section>
