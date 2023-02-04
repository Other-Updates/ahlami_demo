<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Group</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open('members/groups/edit/' . $group[0]['id'], 'name="edit_group" id="edit_group" class="form-horizontal"'); ?>
        <input type="hidden" name="group_id" id="group_id" value="<?php echo $group[0]['id']; ?>">
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>City:</strong></label><span class="req">*</span><br/>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="group[city]" id="city" style="width:18px; margin-top:-7px"class="form-control city" value="1" <?php echo ($group[0]['city'] == '1') ? 'checked="checked"' : ''; ?>/>Kayalpattinam &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="group[city]" id="others" style="width:18px; margin-top:-7px"  class="form-control city" value="2"<?php echo ($group[0]['city'] == '2') ? 'checked="checked"' : ''; ?> />Others &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="radio_error">
                                    <span id="radio_error" style="color:#D84315;font-size: 12px;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <label><strong>Street:</strong></label><span class="req">*</span>
                                <select name="group[street_id]" id="street_name" class="form-control required" >

                                    <?php
                                    if (!empty($streets)) {
                                        foreach ($streets as $street) {
                                            ?>
                                            <option value="<?php echo $street['id']; ?>" <?php echo ($street['id'] == $group[0]['street_id']) ? 'selected' : ''; ?>><?php echo ucfirst($street['street_name']); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Group Name:</strong></label><span class="req">*</span>
                                <input type="text" name="group[group_name]" id="group_name" class="form-control required" value="<?php echo $group[0]['group_name']; ?>" placeholder="Enter Group Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-collaboration"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="group[status]" class="form-control required">
                                    <option value="1" <?php echo ($group[0]['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($group[0]['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('members/groups'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#group_name').on('keyup blur', function () {
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                $.ajax({
                    type: 'POST',
                    data: {group_name: $.trim($('#group_name').val()), id: $('#group_id').val()},
                    url: '<?php echo base_url(); ?>members/groups/is_group_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#group_name').closest('div.form-group').find('.error_msg').text('This Group Name is not available').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#group_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });
        $('#street_name').on('change', function () {
            var street_name = $('#street_name').is(':selected');
            if (street_name != false) {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });
        $(".city").on("change", function () {

            var city = $(this).val();
            $('#street_name').empty();
            $.ajax({
                url: '<?php echo base_url(); ?>members/groups/get_street_by_city_name/' + city,
                type: 'POST',
                data: {city: city},
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select City</option>';
                        $.each(result, function (key, value) {
                            option_text += '<option value="' + value.id + '">' + value.street_name + '</option>';
                        });
                        $('#street_name').html(option_text);
                        $('#street_name').removeAttr('disabled');
                    }

                },
            });
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
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {group_name: $.trim($('#group_name').val()), id: $('#group_id').val()},
                    url: '<?php echo base_url(); ?>members/groups/is_group_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#group_name').closest('div.form-group').find('.error_msg').text('This Group Name is not available').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#group_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });
</script>