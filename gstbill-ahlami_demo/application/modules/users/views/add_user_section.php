<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add New User Section</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('users/user_sections/add', 'name="add_user_section" id="add_user_section" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>User Section Name:</strong></label><span class="req">*</span>
                                <input type="text" name="user_section[user_section_name]" id="user_section_name" class="form-control required" placeholder="Enter User Section Name" maxlength="100">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-books"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>User Section Key:</strong></label><span class="req">*</span>
                                <input type="text" name="user_section[user_section_key]" id="user_section_key" class="form-control required" placeholder="Enter User Section Key" maxlength="100">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-books"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>User Module:</strong></label><span class="req">*</span>
                                <select name="user_section[module_id]" id="module_id" class="form-control required">
                                    <option value="">Select User Module</option>
                                    <?php
                                    if (!empty($user_modules)) {
                                        foreach ($user_modules as $user_module) {
                                            ?>
                                            <option value="<?php echo $user_module['id']; ?>"><?php echo ucfirst($user_module['user_module_name']); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label>
                                <select name="user_section[status]" class="form-control required">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <legend class="text-bold">Actions</legend>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="actions[acc_view]" class="control-primary actions" value="1">
                                    View
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="actions[acc_add]" class="control-primary actions" value="1">
                                    Add
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="actions[acc_edit]" class="control-primary actions" value="1">
                                    Edit
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="actions[acc_delete]" class="control-primary actions" value="1">
                                    Delete
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('users/user_sections'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#user_section_name').on('keyup blur', function () {
            if ($.trim($(this).val()) != '') {
                $.ajax({
                    type: 'POST',
                    data: {user_section_name: $.trim($('#user_section_name').val())},
                    url: '<?php echo base_url(); ?>users/user_sections/is_user_section_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#user_section_name').closest('div.form-group').find('.error_msg').text('This User Section Name is not available').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#user_section_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('.actions').click(function () {
            is_checked = $(this).prop('checked');
            if (is_checked == true) {
                $(this).attr('checked', 'checked');
            } else {
                $(this).removeAttr('checked');
            }
        });

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

            if (m == 0) {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {user_section_name: $.trim($('#user_section_name').val())},
                    url: '<?php echo base_url(); ?>users/user_sections/is_user_section_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#user_section_name').closest('div.form-group').find('.error_msg').text('This User Section Name is not available').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#user_section_name').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });
</script>