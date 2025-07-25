<div class="card">
    <div class="card-body pt-3">
        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" tabindex="-1" role="tab">Application Config</button>
            </li>
        </ul>
        <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit" role="tabpanel">
                <form name="form_config" id="form_config">
                    <!-- <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Logo</label>
                        <div class="col-md-8 col-lg-9">
                            <img src="assets/img/profile-img.jpg" alt="Profile">
                            <div class="pt-2">
                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                    </div> -->
                    <?php
                        foreach ($config_application->result() as $key => $value) {
                    ?>
                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label"><?php echo azlang(ucfirst(str_replace('_', ' ', $value->key))); ?></label>
                            <div class="col-md-8 col-lg-9">
                                <?php
                                    if ($value->type == 'photo') {
                                ?>
                                    <?php echo $logo; ?>
                                <?php
                                    }else if ($value->type == 'text') {
                                ?>
                                    <input type="text" class="form-control" value="<?php echo $value->value; ?>" name="<?php echo $value->key; ?>">
                                <?php 
                                    } else if ($value->type == 'textarea') {
                                ?>
                                        <textarea style="height: 100px" class="form-control" name="<?php echo $value->key; ?>"><?php echo $value->value; ?></textarea>
                                <?php
                                    }else if ($value->type == 'select'){
                                ?>
                                    <select class="form-control select2" name="<?php echo $value->key; ?>" id="<?php echo $value->key; ?>">
                                        <option value="">~ Select a <?php echo $value->key; ?> ~</option>
                                        <?php 
                                            if ($value->key == 'province') {
                                                foreach ($province as $prov): ?>
                                                    <option value="<?= $prov['idprovince']; ?>" <?= ($prov['idprovince'] == $value->value) ? 'selected' : '' ?>>
                                                        <?= $prov['province_name']; ?>
                                                    </option>
                                        <?php 
                                            endforeach;
                                            }else if ($value->key == 'city') {
                                        ?>
                                            <input type="hidden" id="helper_city" value="<?php echo $value->value; ?>"> 
                                        <?php
                                            }
                                         ?>
                                    </select>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    <?php
                        }                    
                    ?>
                    <div style="text-align: right; padding: 20px 0px;">
                        <button type="button" id="btn_save" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>