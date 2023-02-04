<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add Subscriptions</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('masters/subscriptions/add', 'name="add_subscriptions" id="add_subscriptions" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Subscriptions Name:</strong></label><span class="req">*</span>
                                <input type="text" name="subscriptions[name]" id="subscriptions_name" class="form-control required" placeholder="Enter Subscriptions Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mail5"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Mins:</strong></label><span class="req">*</span>
                                <input type="text" name="subscriptions[mins]" id="subscriptions_mins" class="form-control required" placeholder="Enter Mins" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-database-time2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Amount:</strong></label><span class="req">*</span>
                                <input type="text" name="subscriptions[amount]" id="subscriptions_amount" class="form-control required" placeholder="Enter Amount" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-coin-yen"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="subscriptions[status]" class="form-control required">
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
                    <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('masters/subscriptions/index'); ?>'" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
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