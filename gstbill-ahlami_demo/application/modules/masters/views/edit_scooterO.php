<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit ScooterO</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('masters/scooterO/edit/' . $scooterO[0]['id'], 'name="edit_user_type" id="edit_user_type" class="form-horizontal"'); ?>
        <input type="hidden" name="scooterO_id" id="scooterO_id" value="<?php echo $scooterO[0]['id']; ?>">
        <input type="hidden" name="old_scoo_lat" id="scooterO_id" value="<?php echo $scooterO[0]['scoo_lat']; ?>">
        <input type="hidden" name="old_scoo_long" id="scooterO_id" value="<?php echo $scooterO[0]['scoo_long']; ?>">
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Serial Number:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[serial_number]" id="scooterO_serial_number" class="form-control required" value="<?php echo $scooterO[0]['serial_number']; ?>" readonly placeholder="Enter Serial Number" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-bike"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Lattitude:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[scoo_lat]" id="scoo_lat" class="form-control required" value="<?php echo $scooterO[0]['scoo_lat']; ?>" placeholder="Enter Scootero Lattitude" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-qrcode"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Battery Life:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[battery_life]" id="scooterO_battery_life" class="form-control required" value="<?php echo $scooterO[0]['battery_life']; ?>" placeholder="Enter Battery Life" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-battery-charging"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>QR Code Text:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[qr_code]" id="scooterO_qr_code" class="form-control required" value="<?php echo $scooterO[0]['qr_code']; ?>" placeholder="Enter QR Code" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-qrcode"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Longitude:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[scoo_long]" id="scoo_long" class="form-control required" value="<?php echo $scooterO[0]['scoo_long']; ?>" placeholder="Enter Scootero Longitude" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-qrcode"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="scooterO[status]" class="form-control required">
                                    <option value="1" <?php echo ($scooterO[0]['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($scooterO[0]['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('masters/scooterO/index'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
            if (m > 0)
                return false;
        });
    });
</script>