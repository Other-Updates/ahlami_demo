<?php
$theme_path = $this->config->item('theme_locations') . 'zimson';
$is_logo_allowed = $this->config->item('is_logo_allowed');
?>
<style type="text/css">
    .error_msg {
        font-size:14px;
        border-color:rgba(208, 101, 101, 0.9);
        font-family: inherit;
        font-size: 14px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .p { color: red; }
    .powered_by_text { text-align: center; }
    .powered_link:hover,.powered_link:visited { color: #84c3e0; }
</style>
<!-- Content area -->
<div class="content">
    <!-- Advanced login -->
    <form name="login_form" id="login_form" action="<?php echo base_url('users/login') ?>" method="post">
        <div class="panel panel-body login-form log-bor">
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
                <?php if ($is_logo_allowed): ?>
                    <div class="icon-object border-warning-400 text-warning-400"><img src="<?php echo $theme_path; ?>/assets/images/logo.png" alt="" height="60"></i></div>
                <?php endif; ?>
                <?php if (!$is_logo_allowed): ?>
                    <div class="icon-object border-warning-400 text-warning-400" style="font-family:inherit; font-size:35px; text-transform: uppercase;"><img src="<?php echo $theme_path; ?>/assets/images/logo.png" alt="" height="80"></div>
                <?php endif; ?>
                <h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="text" name="username" id="username" class="form-control required" placeholder="Username" />
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="password" name="password" id="password" class="form-control required" placeholder="Password" />
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn bg-blue btn-block submit">Login <i class="icon-circle-right2 position-right"></i></button>
            </div>
            <div class="powered_by_text">
                <span style="display: block;"><?php echo $this->config->item('site_footer') ?></span>
                Powered by <a href="http://www.f2fsolutions.co.in" target="_blank">F2F Solutions</a>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /advanced login -->
</div>
<!-- /content area -->
<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="username"]').focus();
        $('input').attr('autocomplete', 'off');

        $('input[type=text],input[type=password],input[type=email]').on({
            keydown: function (e) {
                this_id = $(this).attr('id');
                if (this_id == 'username') {
                    var yourInput = $(this).val();
                    re = /[`~!#$%^&*()|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
                    var isSplChar = re.test(yourInput);
                    if (isSplChar) {
                        var no_spl_char = yourInput.replace(/[`~!#$%^&*()|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
                        $(this).val(no_spl_char);
                    }
                }
                if (e.which === 32)
                    return false;
            },
            change: function () {
                this.value = this.value.replace(/\s/g, '');
                this_id = $(this).attr('id');
                if (this_id == 'username') {
                    var yourInput = $(this).val();
                    re = /[`~!#$%^&*()|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
                    var isSplChar = re.test(yourInput);
                    if (isSplChar) {
                        var no_spl_char = yourInput.replace(/[`~!#$%^&*()|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
                        $(this).val(no_spl_char);
                    }
                }
            }
        });

        $('.required').on('keyup blur', function () {
            if ($.trim($(this).val()) == '') {
                $(this).addClass('error_msg').attr('placeholder', 'Field Required');
            } else {
                $(this).removeClass('error_msg').removeAttr('placeholder', '');
                $(this).css('border', '1px #3a9488 solid');
            }
        });

        $('.submit').click(function () {
            s = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                if (this_val == '') {
                    $(this).addClass('error_msg').attr('placeholder', 'Field Required');
                    s++;
                } else {
                    $(this).removeClass('error_msg').removeAttr('placeholder', '');
                }
            });
            if (s > 0)
                return false;
        });
    });
</script>