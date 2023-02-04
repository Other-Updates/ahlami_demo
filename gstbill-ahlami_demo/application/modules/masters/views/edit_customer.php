    <?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Customer</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('masters/customers/edit/' . $customer[0]['id'], 'name="edit_customer" id="edit_customer" class="form-horizontal"'); ?>
        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer[0]['id']; ?>">
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Customer Name:</strong></label><span class="req">*</span>
                                <input type="text" name="customer[name]" id="firstname" class="form-control required" value="<?php echo $customer[0]['name'];?>" placeholder="Enter  Name" maxlength="50" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Mobile Number:</strong></label><span class="req">*</span>
                                <input type="text" name="customer[mobile_number]" class="form-control required" value="<?php echo $customer[0]['mobile_number'];?>" placeholder="Enter Mobile Number" maxlength="50" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile2"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>OTP Code:</strong></label><span class="req"></span>
                                <input type="text"readonly  class="form-control" value="<?php echo $customer[0]['otp_code'];?>" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-settings"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>DOB:</strong></label><span class="req"></span>
                                <?php $customer[0]['dob'] = ($customer[0]['dob'] != '0000-00-00' && $customer[0]['dob'] != '') ? date('d/m/Y',strtotime($customer[0]['dob'])) : '-'; ?>
                                <input type="text" name="customer[dob]" id="lastname" class="form-control datepicker" value="<?php echo $customer[0]['dob'];?>" placeholder="Select DOB" maxlength="50" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Gender:</strong></label><span class="req"></span>
                                <select name="customer[gender]" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="1" <?php echo ($customer[0]['gender'] == 1) ? 'selected' : ''?>>Male</option>
                                    <option value="2" <?php echo ($customer[0]['gender'] == 2) ? 'selected' : ''?>>Female</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>OTP Verify:</strong></label><span class="req"></span>
                                <input type="text"readonly  class="form-control" value="<?php echo ($customer[0]['otp_verify'] == 1) ? 'Yes' : 'No';?>" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-settings"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Email Address:</strong></label><span class="req">*</span>
                                <input type="text" name="customer[email]" id="email" class="form-control required" value="<?php echo $customer[0]['email'];?>" placeholder="Enter Email Address" maxlength="100" autocomplete="off">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mail5"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="customer[status]" class="form-control required">
                                    <option value="1" <?php echo ($customer[0]['status'] == 1) ? 'selected' : ''?>>Active</option>
                                    <option value="0" <?php echo ($customer[0]['status'] == 0) ? 'selected' : ''?>>Inactive</option>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('masters/customers'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
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