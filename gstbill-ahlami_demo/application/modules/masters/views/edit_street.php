<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Street</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('masters/streets/edit/' . $street[0]['id'], 'name="edit_street" id="edit_street" class="form-horizontal"'); ?>
        <input type="hidden" name="street_id" id="street_id" value="<?php echo $street[0]['id']; ?>">
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>City:</strong></label><span class="req">*</span><br/>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="street[city]" id="city" style="width:18px; margin-top:-7px"class="form-control city" value="1" <?php echo ($street[0]['city'] == '1') ? 'checked="checked"' : ''; ?>/>Kayalpattinam &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="street[city]" id="others" style="width:18px; margin-top:-7px"  class="form-control city" value="2"<?php echo ($street[0]['city'] == '2') ? 'checked="checked"' : ''; ?> />Others &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="radio_error">
                                    <span id="radio_error" style="color:#D84315;font-size: 12px;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Street Name:</strong></label><span class="req">*</span>
                                <input type="text" name="street[street_name]" id="street_name" class="form-control required" value="<?php echo $street[0]['street_name']; ?>" placeholder="Enter Street Name" maxlength="100">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-stack2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="street[status]" class="form-control required">
                                    <option value="1" <?php echo ($street[0]['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($street[0]['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('masters/streets'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#street_name').on('keyup blur', function () {
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                var city = $("input[name='street[city]']:checked").val();
                $.ajax({
                    type: 'POST',
                    data: {street_name: $.trim($('#street_name').val()), id: $('#street_id').val(), city: city},
                    url: '<?php echo base_url(); ?>masters/streets/is_street_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#street_name').closest('div.form-group').find('.error_msg').text('This Street Name is not available').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#street_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });
        $('.submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
            if (m == 0) {
                var city = $("input[name='street[city]']:checked").val();
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {street_name: $.trim($('#street_name').val()), id: $('#street_id').val(), city: city},
                    url: '<?php echo base_url(); ?>masters/streets/is_street_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#street_name').closest('div.form-group').find('.error_msg').text('This Street Name is not available').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#street_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });
</script>