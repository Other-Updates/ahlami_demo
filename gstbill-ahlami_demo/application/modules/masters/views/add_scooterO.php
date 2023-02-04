<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add ScooterO</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <?php $locations = ($setting[0]['current_location']) ? unserialize($setting[0]['current_location']) : '';
        $latitude = ($locations) ? $locations['latitude'] : '';
        $longitude = ($locations) ? $locations['longitude'] : '';
    ?>
    <div class="panel-body">
        <?php echo form_open_multipart('masters/scooterO/add', 'name="add_scooterO" id="add_scooterO" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Serial Number:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[serial_number]" id="scooterO_serial_number" class="form-control required" value="<?php echo $serial_number;?>"  readonly placeholder="Enter Serial Number" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-bike"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Lattitude:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[scoo_lat]" id="scoo_lat" class="form-control required" value="<?php echo $latitude;?>" placeholder="Enter Scootero Lattitude" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-battery-charging"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Battery Life:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[battery_life]" id="scooterO_battery_life" class="form-control required" placeholder="Enter Battery Life" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-battery-charging"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>QR Code Text:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[qr_code]" id="scooterO_qr_code" class="form-control required" placeholder="Enter QR Code" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-qrcode"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Longitude:</strong></label><span class="req">*</span>
                                <input type="text" name="scooterO[scoo_long]" id="scoo_long" class="form-control required" value="<?php echo $longitude;?>" placeholder="Enter Scootero Longitude" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-qrcode"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="user_type[status]" class="form-control required">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-6">
                <div class="text-left">
                    <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('masters/scooterO/index'); ?>'" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <button type="submit" name="submit" class="btn btn-primary submit" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
                </div>
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