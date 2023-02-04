<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Form horizontal -->
<style type="text/css">
    .radio_button { margin: 12px 0px 8px 0px !important; }
    #profile {
        height:50px;
        width: 50px;
        border: 1px solid #d8d8d8;
        margin-left: 10px;
        margin-top: 11px;
    }
    input[type="radio"], input[type="checkbox"] {
        margin: 9px -3px 0;
        margin-top: 1px \9;
        line-height: normal;
    }
</style>
<?php
$relation_arr = array (
'parent' => 'Parent',
 'children' => 'Children',
 'siblings' => 'Siblings',
 'relatives' => 'Relatives',
 'others' => 'Others'
);
?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add New Member</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('members/add', 'name="add_member" id="add_member" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <legend class="text-bold">Members Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Member ID:</strong></label><span class="req">*</span>
                                <input type="text" name="member[member_id]" id="member_id" class="form-control required" value="<?php echo $member_id; ?>" readonly="readonly" placeholder="Enter Member ID" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left" id="dev2">
                                <label><strong>Username:</strong></label><span class="req">*</span>
                                <input type="text" name="member[username]" id="username" class="form-control required" placeholder="Enter Username" maxlength="50" tabindex="3">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Email Address:</strong></label><span class="req">*</span>
                                <input type="text" name="member[email_address]" id="email" class="form-control required" placeholder="Enter Email Address" maxlength="100" tabindex="6">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mail5"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Gender:</strong></label><span class="req">*</span>
                                <div class="radio_list" tabindex="9">
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="male">&nbsp;&nbsp;&nbsp; Male &nbsp;
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="female">&nbsp;&nbsp;&nbsp; Female &nbsp;
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="child">&nbsp;&nbsp;&nbsp; Child &nbsp;
                                </div>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>First Name:</strong></label><span class="req">*</span>
                                <input type="text" name="member[firstname]" id="firstname" class="form-control required" placeholder="Enter First Name" maxlength="50" tabindex="1">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Password:</strong></label><span class="req">*</span>
                                <input type="password" name="member[password]" id="password" class="form-control required" placeholder="Enter Password" tabindex="4">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Mobile Number:</strong></label><span class="req">*</span>
                                <input type="text" name="member[mobile_number]" id="mobile" class="form-control required" placeholder="Enter Mobile Number" maxlength="10" tabindex="7">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile2"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label><strong>Profile Picture:</strong></label> <span>(Min. resolution 150x150)</span>
                                        <input type="file" name="profile_image" id="profile_image" class="form-control" placeholder="Choose Profile Picture">
                                        <div class="form-control-feedback">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);"><img src="<?php echo $theme_path; ?>/assets/images/default_image.png" id="profile" class="imagePreview"></a>
                                    </div>
                                </div>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Last Name:</strong></label><span class="req">*</span>
                                <input type="text" name="member[lastname]" id="lastname" class="form-control required " placeholder="Enter Last Name" maxlength="50"  tabindex="2">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Retype Password:</strong></label><span class="req">*</span>
                                <input type="password" name="retype_password" id="retype_password" class="form-control required " placeholder="Retype Password" tabindex="5">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>DOB:</strong></label><span class="req">*</span>
                                <input type="text" name="member[dob]" id="dob" class="form-control required " placeholder="Select Date of Birth" tabindex="8">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="member[status]" class="form-control required tab" tabindex="-1">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <legend class="text-bold">Address Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Permanent Address:&nbsp;(Kayalpattinam)</strong></label><span class="req">*</span>
                                <input type="text" name="member[address_line_1]" class="form-control required tab" placeholder="Enter Permanent Address" value="Kalyalpattinam,Tamilnadu" tabindex="-1">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-location4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left duration_range" style="display: none;">
                                <label><strong>From Date:</strong></label><span class="req">*</span>
                                <input type="text" name="member[duration_from]" id="from_date" class="form-control datepicker" disabled="disabled" placeholder="Select From Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Current Address:</strong></label><span class="req">*</span>
                                <input type="text" name="member[address_line_2]" class="form-control required " id="address_line_2" placeholder="Enter Current Address" tabindex="10">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-location4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left duration_range" style="display: none;">  <label><strong>To Date:</strong></label><span class="req">*</span>
                                <input type="text" name="member[duration_to]" id="to_date" class="form-control datepicker" disabled="disabled" placeholder="Select To Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <label><strong>On Kayalpattinam:</strong></label><span class="req">*</span>
                                <div class="radio_list" tabindex="11">
                                    <input type="radio" name="member[on_kayalpattinam]" id="temporary" class="on_kayalpattinam radio_button" value="temporary"> Temporary &nbsp;
                                    <input type="radio" name="member[on_kayalpattinam]" id="permanent" class="on_kayalpattinam radio_button" value="permanent"> Permanent &nbsp;
                                    <input type="radio" name="member[on_kayalpattinam]" id="out_of_kayalpattinam" class="on_kayalpattinam radio_button" value="out_of_kayalpattinam"> Out of Kayalpattinam
                                </div>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <legend class="text-bold">Family Role Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>City:</strong></label><span class="req">*</span><br/>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="member[city]" id="city" style="width:18px; margin-top:-7px"class="form-control city" value="1" />Kayalpattinam &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="member[city]" id="others" style="width:18px; margin-top:-7px"  class="form-control city" value="2" />Others &nbsp;
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
                                <select name="member[street_id]" id="street_name" class="form-control required" disabled="disabled">
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <label><strong>Family Type:</strong></label><span class="req">*</span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal" title="Track Family"> <i class="icon-search4"></i> Track</button>
                                <select name="member[family_id]" id="family_type" class="form-control required" disabled="disabled">

                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <label><strong>Relation:</strong></label><span class="req">*</span>
                                <select name="member[relation]" id="relation" class="form-control required">
                                    <option value="">Select Relation</option>
                                    <?php
                                    if (!empty($relation_arr)) {
                                        foreach ($relation_arr as $relation_key => $relation_val) {
                                            ?>
                                            <option value="<?php echo $relation_key; ?>"><?php echo $relation_val; ?></option>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('members'); ?>'" title="Cancel" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" title="Submit" style="float:right;">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="modal" id="myModal" style="margin-top: 130px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title">Track Family</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group has-feedback">
                                <label><strong>Mobile Number:</strong></label><span class="req">*</span>
                                <input type="text" name="search" class="form-control family_mobile_number" placeholder="Enter Your Family Mobile Number">
                            </div>
                        </div>
                    </div>
                </div>
                <span style="color:red; margin-left: 10px;" id="track_family_error"></span>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success track_family" data-dismiss="modal">Go</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#firstname').focus();

        $('#myModal').on('hidden.bs.modal', function () {
            $(this).find('input,textarea,select').val('').end();
        });

        var today = new Date();
        from_year = today.getFullYear() - 40;
        $('#dob').pickadate({
            min: [from_year, 0, 1],
            max: [today.getFullYear(), today.getMonth(), today.getDate()],
            format: 'dd/mm/yyyy',
            formatSubmit: 'dd/mm/yyyy',
            selectYears: true,
            selectMonths: true
        });





        $('.city').on('change', function () {
            $('#street_name').select2();
            var city = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>members/groups/get_street_by_city_name/' + city,
                type: 'POST',
                data: {city: city},
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select Street Name</option>';
                        $.each(result, function (key, value) {
                            option_text += '<option value="' + value.id + '">' + value.street_name + '</option>';
                        });
                        $('#street_name').html(option_text);
                        $('#street_name').removeAttr('disabled');
                    }
                }
            });
        });

        $('#street_name').on('change', function () {
            $('#family_type').select2();
            var street_id = $(this).val();
            $('#family_type').empty();
            $.ajax({
                url: '<?php echo base_url(); ?>members/members/get_family_type_by_street_id/' + street_id,
                type: 'POST',
                data: {street_id: street_id},
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select Family Type</option>';
                        $.each(result, function (key, value) {
                            option_text += '<option value="' + value.id + '">' + value.group_name + '</option>';
                        });
                        $('#family_type').html(option_text);
                        $('#family_type').removeAttr('disabled');
                    }
                }
            });
        });

        $('.track_family').click(function (e) {
            e.preventDefault();
            var family_mobile_number = $('input.family_mobile_number').val();
            if (family_mobile_number == "")
            {
                $('#track_family_error').append('This field is required');
                setTimeout(function () {
                    $('#track_family_error').html('');
                }, 3000);
                return false;
            }
            $("#myModal").modal("toggle");
            $.ajax({
                url: '<?php echo base_url(); ?>members/search_family',
                type: 'POST',
                data: {mobile_number: family_mobile_number},
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        city = response.city;
                        street_id = response.street_id;
                        family_id = response.family_id;
                        streets = response.streets;
                        family_types = response.family_types;

                        street_text = '';
                        street_text += '<option value="" disabled="disabled">Select Street Name</option>';
                        $.each(streets, function (key, value) {
                            selected = (value.id == street_id) ? 'selected="selected"' : '';
                            street_text += '<option value="' + value.id + '" ' + selected + '>' + value.street_name + '</option>';
                        });
                        family_type_text = '';
                        family_type_text += '<option value="" disabled="disabled">Select Family Type</option>';
                        $.each(family_types, function (key, value) {
                            selected = (value.id == family_id) ? 'selected="selected"' : '';
                            family_type_text += '<option value="' + value.id + '" ' + selected + '>' + value.group_name + '</option>';
                        });

                        $('input[name="member[city]"][value="' + city + '"]').attr('checked', true);
                        $('#street_name').removeAttr('disabled');
                        $('#street_name').html(street_text);
                        $('#street_name').select2();
                        $('#family_type').removeAttr('disabled');
                        $('#family_type').html(family_type_text);
                        $('#family_type').select2();
                        $('#family_type').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    } else {
                        $('#family_type').closest('div.form-group').find('.error_msg').text('Family Name not found').slideDown('500').css('display', 'inline-block');
                    }
                }
            });
        });

        $('.on_kayalpattinam').change(function () {
            this_val = $('input[name="member[on_kayalpattinam]"]:checked').val();
            if (this_val == 'temporary') {
                $('.duration_range').show();
                $('.duration_range').find('input').removeAttr('disabled');
                $('.duration_range').find('input').addClass('required');
            } else {
                $('.duration_range').find('input').attr('disabled', 'disabled');
                $('.duration_range').find('input').removeClass('required');
                $('.duration_range').hide();
            }
        });

        $('#firstname,#lastname,#address_line_2').on('keyup change', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $('#firstname,#lastname,#address_line_2').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#password').on('keyup change', function () {
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

        $('#retype_password').on('keyup change', function () {
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

        $('#dob').on('change', function () {
            var dob = $(this).val();
            if (dob == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('.gender').on('change', function () {
            var gender = $('.gender:checked').length;
            if (gender == 0) {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('.on_kayalpattinam').on('change', function () {
            var on_kayalpattinam = $('.on_kayalpattinam:checked').length;
            if (on_kayalpattinam == 0) {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#family_type').on('change', function () {
            var family = $('#family_type').is(':selected');
            if (family != false) {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
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

        $('#relation').on('change', function () {
            var relation = $(this).val();
            if (relation == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#username').on('keyup change', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {username: $.trim($('#username').val())},
                    url: '<?php echo base_url(); ?>members/members/is_user_name_available/',
                    success: function (data) {
                        if (data != 0) {
                            $('#username').closest('div.form-group').find('.error_msg').text('This User Name is already used').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#username').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('#email').on('keyup change', function () {
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
                    url: '<?php echo base_url(); ?>members/members/is_email_address_available/',
                    success: function (data) {
                        if (data != 0) {
                            $('#email').closest('div.form-group').find('.error_msg').text('This Email Address is already used').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#email').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        $('#mobile').on('keyup change', function () {
            this_val = $.trim($(this).val());
            pattern_phone = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
            is_valid = pattern_phone.test(this_val);
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (!is_valid) {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Mobile Number').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {mobile: $.trim($('#mobile').val())},
                    url: '<?php echo base_url(); ?>members/members/is_mobile_number_available/',
                    success: function (data) {

                        if (data != 0) {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('This Mobile Number is already used').slideDown('500').css('display', 'inline-block');
                        } else {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
        });

        var imageTag = document.getElementById('profile');
        $('input[name="member[gender]"]').change(function () {
            gender_val = $('input[name="member[gender]"]:checked').val();
            console.log(gender_val);
            if (gender_val == 'male') {
                imageTag.src = '<?php echo base_url() . 'themes/event/assets/images/men_1.png'; ?>';
            } else if (gender_val == 'female') {
                imageTag.src = '<?php echo base_url() . 'themes/event/assets/images/female.jpg'; ?>';
            } else if (gender_val == 'child') {
                imageTag.src = '<?php echo base_url() . 'themes/event/assets/images/child_2.png'; ?>';
            }
        });

        $('#profile_image').on('change', function () {
            var files = this.files;
            if (files && files[0]) {
                readImage(files[0], '#profile_image');
            } else {
                default_src = $('.imagePreview').attr('default_src');
                $('.imagePreview').attr('src', default_src);
            }
        });

        $('.submit').click(function () {
            m = 0;
            var checkbox = $(".city").is(":checked");

            if (checkbox == false)
            {
                $('#radio_error').empty();
                $('#radio_error').append('This field is required');
                setTimeout(function () {
                    $('#radio_error').html('');
                }, 3000);
                m++;
            }
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

            var gender = $('.gender:checked').length;
            var on_kayalpattinam = $('.on_kayalpattinam:checked').length;
            if (gender == 0) {
                $('.gender').closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                $('.gender').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
            if (on_kayalpattinam == 0) {
                $('.on_kayalpattinam').closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                $('.on_kayalpattinam').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }

            if (m == 0) {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {username: $.trim($('#username').val())},
                    url: '<?php echo base_url(); ?>members/members/is_user_name_available/',
                    success: function (data) {
                        if (data != 0) {
                            $('#username').closest('div.form-group').find('.error_msg').text('This User Name is already taken').slideDown('500').css('display', 'inline-block');
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
                    url: '<?php echo base_url(); ?>members/members/is_email_address_available/',
                    success: function (data) {
                        if (data != 0) {
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
                    url: '<?php echo base_url(); ?>members/members/is_mobile_number_available/',
                    success: function (data) {

                        if (data != 0) {
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

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && ((charCode != 46 && charCode != 45 && charCode != 43 && charCode < 48) || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
</script>