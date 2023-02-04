<style>
    .login-container .page-container .login-form, .login-container .page-container .registration-form {
        margin: 0px auto 20px auto;
    }
    .form-horizontal .form-group {
        margin-left: 0px;
        margin-right: 0px;
    }
</style>
<?php 
$disabled = '';
if($confirmation_code != '' && $expire == 1){
    $disabled = 'disabled';
}

?>
<?php if($disabled && !$status) : ?>
    <h4 style="color:red;text-align:center;">Passowrd Recovery Time was Expired</h4>
<?php elseif($confirmation_code && isset($customers) && $customers == '' && !$status) : ?>
    <h4 style="color:red;text-align:center;">Invalid Customer to Password Recovery</h4>
<?php endif;?>
<div class="content">
    <!-- Password recovery -->
    <?php echo form_open_multipart('members/members/reset_password', 'name="reset_password" id="reset_password" class="form-horizontal"'); ?>
    <input type="hidden" name="member[confirmation_code]" value="<?php echo $confirmation_code;?>"/>
    <input type="hidden" name="member[p_status]" value="<?php echo $status;?>"/>
    <input type="hidden" name="member[id]" value="<?php echo $id;?>"/>
    <input type="hidden" name="member[time]" value="<?php echo $time;?>"/>
    <div class="panel panel-body login-form">
        <?php if ($this->session->flashdata('flashError')): ?>
            <div class="alert alert-danger no-border">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Error!</span> <?php echo $this->session->flashdata('flashError') ?>
            </div>
        <?php endif ?>
        <?php if ($this->session->flashdata('flashSuccess')): ?>
            <div class="alert alert-success no-border">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Success!</span> <?php echo $this->session->flashdata('flashSuccess') ?>
            </div>
        <?php endif ?>
        <?php if ($this->session->flashdata('flashFail')): ?>
            <div class="alert alert-danger no-border">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Error!</span> <?php echo $this->session->flashdata('flashFail') ?>
            </div>
        <?php endif ?>
        <div class="text-center">
            <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
            <h5 class="content-group">Password recovery <small class="display-block">Please Enter Member Details</small></h5>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="member[email_address]" id="email" class="form-control required" placeholder="Your email">
            <span class="error_msg"></span>
            <div class="form-control-feedback">
                <i class="icon-mail5 text-muted"></i>
            </div>
        </div>
        <div class="form-group has-feedback">
            <input  type="text" name="member[mobile_number]" id="mobile" class="form-control required" placeholder="Your mobile number" maxlength="10">
            <span class="error_msg"></span>
            <div class="form-control-feedback">
                <i class="icon-mobile2"></i>
            </div>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="member[password]"class="form-control required" placeholder="Your New Password" id="password">
            <span class="error_msg"></span>
            <div class="form-control-feedback">
                <i class="icon-lock"></i>
            </div>
        </div>
        <div class="form-group has-feedback">
            <input  type="password" name="retype_password" class="form-control required" placeholder="Confirm Password" id="retype_password" >
            <span class="error_msg"></span>
            <div class="form-control-feedback">
                <i class="icon-lock"></i>
            </div>
        </div>
        
        <button type="submit" <?php echo $disabled;?> class="btn bg-blue btn-block submit">Reset password <i class="icon-arrow-right14 position-right"></i></button>
        <button type="button" <?php echo $disabled;?> disabled class="btn btn-danger" onclick="window.location = '<?php echo base_url('users/login'); ?>'" title="Back to Login" style="float:left;width: 100%;margin-top: 10px;"><i class="icon-arrow-left13 position-left"></i> Back to Login</button>
    </div>
    <?php echo form_close(); ?>

    <div class="footer text-muted text-center">
        Copyright &copy;  2019 Events,All rights reserved. Powered by<a href="https://f2fsolutions.co.in/"> F2F Solutions</a>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#mobile,#email').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $('#mobile,#email').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#password').on('keyup blur', function () {
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                if ($.trim($('#password').val()) != '' && $.trim($('#retype_password').val()) != '' && $('#password').val() != $('#retype_password').val()) {
                    $('#retype_password').closest('div.form-group').find('.error_msg').text('Password and Retype Password should be same').slideDown('500').css('display', 'inline-block');
                } else {
                    $('#password').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            }
        });

        $('#retype_password').on('keyup blur', function () {
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                if ($.trim($('#password').val()) != '' && $.trim($('#retype_password').val()) != '' && $('#password').val() != $('#retype_password').val()) {
                    $('#retype_password').closest('div.form-group').find('.error_msg').text('Password and Retype Password should be same').slideDown('500').css('display', 'inline-block');
                } else {
                    $('#retype_password').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
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
            }
        });

        $('#mobile').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            pattern_phone = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            is_valid = pattern_phone.test(this_val);
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (!is_valid) {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Mobile Number').slideDown('500').css('display', 'inline-block');
            }
        });
        $('.submit').click(function () {
            m = 0;

            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_length = this_val.length;
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
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
                } else if (this_id == 'password' || this_id == 'retype_password') {
                    if (this_length <= 5 && this_length >= 16) {
                        $(this).closest('div.form-group').find('.error_msg').text('Password(s) should be between 6-15 characters').slideDown('500').css('display', 'inline-block');
                        m++;
                    } else if ($.trim($('#password').val()) != '' && $.trim($('#retype_password').val()) != '' && $('#password').val() != $('#retype_password').val()) {
                        $('#retype_password').closest('div.form-group').find('.error_msg').text('Password and Retype Password should be same').slideDown('500').css('display', 'inline-block');
                        m++;
                    } else {
                        $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    }
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });

            if (m > 0)
                return false;
        });
    });
</script>