<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<style type="text/css">
    #profile {
        height:50px;
        width: 50px;
        border: 1px solid #d8d8d8;
        margin-left: 10px;
        margin-top: 11px;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add New User</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('users/add', 'name="add_user" id="add_user" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <legend class="text-bold">User Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>First Name:</strong></label><span class="req">*</span>
                                <input type="text" name="user[firstname]" id="firstname" class="form-control required" placeholder="Enter First Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>User ID:</strong></label><span class="req">*</span>
                                <input type="text" name="user[user_id]" id="user_id" class="form-control required" value="<?php echo $user_id; ?>" readonly="readonly" placeholder="Enter User ID">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Username:</strong></label><span class="req">*</span>
                                <input type="text" name="user[username]" id="username" class="form-control required" placeholder="Enter Username" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Password:</strong></label><span class="req">*</span>
                                <input type="password" name="user[password]" id="password" class="form-control required" placeholder="Enter Password">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Last Name:</strong></label><span class="req">*</span>
                                <input type="text" name="user[lastname]" id="lastname" class="form-control required" placeholder="Enter Last Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Mobile Number:</strong></label><span class="req">*</span>
                                <input type="text" name="user[mobile_number]" id="mobile" class="form-control required" placeholder="Enter Mobile Number" maxlength="10">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile2"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Address:</strong></label>
                                <input type="text" name="user[address]" class="form-control" placeholder="Enter Address" maxlength="150">
                                <div class="form-control-feedback">
                                    <i class="icon-address-book"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Retype Password:</strong></label><span class="req">*</span>
                                <input type="password" name="retype_password" id="retype_password" class="form-control required" placeholder="Retype Password" minlength="6">
                                <span class="error_msg" ></span>
                                <div class="form-control-feedback">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>DOB:</strong></label><span class="req">*</span>
                                <input type="text" name="user[dob]" id="dob" class="form-control required datepicker" placeholder="Select Date of Birth">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Email Address:</strong></label><span class="req">*</span>
                                <input type="text" name="user[email_address]" id="email" class="form-control required" placeholder="Enter Email Address" maxlength="100">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mail5"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label><strong>Profile Picture:</strong></label> <span class="req">(Min. resolution 150x150)</span>
                                        <input type="file" name="profile_image" id="profile_image" class="form-control" placeholder="Choose Profile Picture">
                                        <div class="form-control-feedback">
                                            <i class="icon-file-picture"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);"><img src="<?php echo $theme_path; ?>/assets/images/default_image.png" id="profile" class="imagePreview"></a>
                                    </div>
                                </div>
                                <span class="error_msg"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="user[status]" id="status" class="form-control required">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <legend class="text-bold">User Role Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <label><strong>User Type:</strong></label><span class="req">*</span>
                                <select name="user[user_type_id]" id="user_type" class="form-control required">
                                    <option value="">Select User Type</option>
                                    <?php
                                    if (!empty($user_types)) {
                                        foreach ($user_types as $type) {
                                            ?>
                                            <option value="<?php echo $type['id']; ?>"><?php echo ucfirst($type['user_type_name']); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('users'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {


        $('#dob').datepicker({
            dateFormat: "dd/MM/yy",
            changeMonth: true,
            changeYear: true,
            ignoreReadonly: true,
            maxDate: 'now'
        });

        $('#dob').find('.ui-datepicker-next').remove();


        $('#profile_image').on('change', function () {
            var files = this.files;
            if (files && files[0]) {
                readImage(files[0], '#profile_image');
            } else {
                default_src = $('.imagePreview').attr('default_src');
                $('.imagePreview').attr('src', default_src);
            }
        });

        $('#firstname, #lastname').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#user_type').on('change', function () {
            var user_type = $('#user_type').val();
            if (user_type == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#password, #retype_password').on('keyup blur', function () {
            password = $.trim($('#password').val());
            retype_password = $.trim($('#retype_password').val());
            this_val = $.trim($(this).val());
            this_length = this_val.length;

            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (this_length <= 5 || this_length >= 12) {
                $(this).closest('div.form-group').find('.error_msg').text('Password should be between 6-12 characters').slideDown('500').css('display', 'inline-block');
            } else if (password != '' && retype_password != '' && password != retype_password) {
                $(this).closest('div.form-group').find('.error_msg').text('Password and Retype Password should be same').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#dob').on('change', function () {
            var dob = $('#dob').val();
            if (dob == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#username').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {username: $.trim($('#username').val())},
                    url: '<?php echo base_url(); ?>users/is_user_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#username').closest('div.form-group').find('.error_msg').text('This Username is already taken').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#username').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('#email').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            is_valid = emailRegexStr.test(this_val);
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (!is_valid) {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Email Address').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {email: $.trim($('#email').val())},
                    url: '<?php echo base_url(); ?>users/is_email_address_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#email').closest('div.form-group').find('.error_msg').text('This Email Address is already taken').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#email').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('#mobile').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            pattern_phone = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            is_valid = pattern_phone.test(this_val);
            if ($.trim($(this).val()) == '') {
                s
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (!is_valid) {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Mobile Number').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {mobile: $.trim($('#mobile').val())},
                    url: '<?php echo base_url(); ?>users/is_mobile_number_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('This Mobile Number is already taken').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('.submit').click(function () {
            m = 0;
            password = $.trim($('#password').val());
            retype_password = $.trim($('#retype_password').val());
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_length = this_val.length;
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else if ((this_id == 'password' || this_id == 'retype_password') && this_length <= 5 || this_length >= 12) {
                    $(this).closest('div.form-group').find('.error_msg').text('Password should be between 6-12 characters').slideDown('500').css('display', 'inline-block');
                    m++;
                } else if (this_id == 'retype_password' && password != '' && retype_password != '' && password != retype_password) {
                    $(this).closest('div.form-group').find('.error_msg').text('Password and Retype Password should be same').slideDown('500').css('display', 'inline-block');
                    m++;
                } else if (this_id == 'email') {
                    emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    is_valid = emailRegexStr.test(this_val);
                    if (!is_valid) {
                        $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Email Address').slideDown('500').css('display', 'inline-block');
                        m++;
                    } else {
                        $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    }
                } else if (this_id == 'mobile') {
                    pattern_phone = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
                    is_valid = pattern_phone.test(this_val);
                    if (!is_valid) {
                        $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Mobile Number').slideDown('500').css('display', 'inline-block');
                        m++;
                    } else {
                        $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    }
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });

            if (m == 0) {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {username: $.trim($('#username').val())},
                    url: '<?php echo base_url(); ?>users/is_user_name_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#username').closest('div.form-group').find('.error_msg').text('This Username is already taken').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#username').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });

                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {email: $.trim($('#email').val())},
                    url: '<?php echo base_url(); ?>users/is_email_address_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#email').closest('div.form-group').find('.error_msg').text('This Email Address is already taken').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#email').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });

                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {mobile: $.trim($('#mobile').val())},
                    url: '<?php echo base_url(); ?>users/is_mobile_number_available/',
                    success: function (data) {
                        if (data == 'yes') {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('This Mobile Number is already taken').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });
    function readImage(file, element) {
        error = 1;
        file_name = file.name;
        var exts = ['jpg', 'jpeg', 'png'];
        var get_ext = file_name.split('.');
        get_ext = get_ext.reverse();
        if ($.inArray(get_ext[0].toLowerCase(), exts) == -1) {
            $(element).val('');
            $(element).closest('div.form-group').find('.error_msg').text('File format not allowed').slideDown('500').css('display', 'inline-block');
            default_src = $('.imagePreview').attr('default_src');
            $('.imagePreview').attr('src', default_src);
            error = 0;
        } else {
            var reader = new FileReader();
            var image = new Image();
            reader.readAsDataURL(file);
            reader.onload = function (_file) {
                image.src = _file.target.result;
                image.onload = function () {
                    width = this.width;
                    height = this.height;
                    if (width < 150 || height < 150) {
                        $(element).closest('div.form-group').find('.error_msg').text('Image resolution should be higher than 150x150').slideDown('500').css('display', 'inline-block');
                        $(element).val('');
                        s
                        default_src = $('.imagePreview').attr('default_src');
                        $('.imagePreview').attr('src', default_src);
                        error = 0;
                    } else {
                        $('.imagePreview').attr('src', _file.target.result);
                        $(element).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    }
                }
            }
        }
        return error;
    }
</script>