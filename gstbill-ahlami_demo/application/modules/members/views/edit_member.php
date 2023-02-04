<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Form horizontal -->
<style type="text/css">
    .radio_button { margin: 12px 0px 8px 0px !important; }
    #profile {
        height:50px;
        width: 50px;
        border: 1px solid #d8d8d8;
        margin-left: 10px;
        margin-top: 16px;
        transition: transform .2s;
    }
    #profile:hover {
        -ms-transform: scale(1.5); /* IE 9 */
        -webkit-transform: scale(1.5); /* Safari 3-8 */
        transform: scale(1.5);
        height:60px;
        width:60px;
    }
    input[type="radio"], input[type="checkbox"] {
        margin: 9px 0 0;
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
        <h5 class="panel-title">Edit Member</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('members/edit/' . $member[0]['id'], 'name="edit_member" id="edit_member" class="form-horizontal"'); ?>
        <input type="hidden" name="member_user_id" id="member_user_id" value="<?php echo $member[0]['id']; ?>">
        <fieldset class="content-group">
            <legend class="text-bold">Members Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Member ID:</strong></label><span class="req">*</span>
                                <input type="text" name="member[member_id]" id="member_id" class="form-control required" value="<?php echo $member[0]['member_id']; ?>" readonly="readonly" placeholder="Enter Member ID" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Username:</strong></label><span class="req">*</span>
                                <input type="text" name="member[username]" id="username" class="form-control required" value="<?php echo $member[0]['username']; ?>" placeholder="Enter Username" maxlength="50">
                                <input type="hidden" name="current_username" id="current_username" value="<?php echo $member[0]['username']; ?>">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Email Address:</strong></label><span class="req">*</span>
                                <input type="text" name="member[email_address]" id="email" class="form-control required" value="<?php echo $member[0]['email_address']; ?>" placeholder="Enter Email Address" maxlength="100">
                                <input type="hidden" name="current_email_address" id="current_email_address" value="<?php echo $member[0]['email_address']; ?>">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mail5"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <?php
                                $image_name = !empty($member[0]['profile_image']) ? pathinfo($member[0]['profile_image'], PATHINFO_FILENAME) : '';
                                $image_ext = !empty($member[0]['profile_image']) ? pathinfo($member[0]['profile_image'], PATHINFO_EXTENSION) : '';
                                $exists = file_exists(FCPATH . 'attachments/member_image/' . $image_name . '.' . $image_ext);
                                if (!empty($member[0]['profile_image']))
                                    $image_path = base_url() . 'attachments/member_image/' . $image_name . '.' . $image_ext;
                                else if (!empty($member[0]['gender'] == 'male'))
                                    $image_path = base_url() . 'themes/event/assets/images/men_1.png';
                                else if (!empty($member[0]['gender'] == 'female'))
                                    $image_path = base_url() . 'themes/event/assets/images/female.jpg';
                                else if (!empty($member[0]['gender'] == 'child'))
                                    $image_path = base_url() . 'themes/event/assets/images/child_2.png';
                                ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        <label><strong>Profile Picture:</strong></label> <span class="req">(Min. resolution 150x150)</span>
                                        <input type="file" name="profile_image" id="profile_image" class="form-control" placeholder="Choose Profile Picture">
                                        <div class="form-control-feedback">
                                            <i class="icon-file-picture"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);"><img id="profile" class="imagePreview" src="<?php echo $image_path; ?>"></a>
                                    </div>
                                </div>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>First Name:</strong></label><span class="req">*</span>
                                <input type="text" name="member[firstname]" id="firstname" class="form-control required" value="<?php echo $member[0]['firstname']; ?>" placeholder="Enter First Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Password:</strong></label><span class="req" style="font-size: 12px;"> (Leave as empty, if you do not change password)</span>
                                <input type="password" name="member[password]" id="password" class="form-control" placeholder="Enter Password">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-lock"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-right">
                                <label><strong>Mobile Number:</strong></label><span class="req">*</span>
                                <input type="text" name="member[mobile_number]" id="mobile" class="form-control required" value="<?php echo $member[0]['mobile_number']; ?>" placeholder="Enter Mobile Number" maxlength="10">
                                <input type="hidden" name="current_mobile_number" id="current_mobile_number" value="<?php echo $member[0]['mobile_number']; ?>">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile2"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback adjust">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="member[status]" class="form-control required">
                                    <option value="1" <?php echo ($member[0]['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($member[0]['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Last Name:</strong></label><span class="req">*</span>
                                <input type="text" name="member[lastname]" id="lastname" class="form-control required" value="<?php echo $member[0]['lastname']; ?>" placeholder="Enter Last Name" maxlength="50">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label ><strong>Gender:</strong></label>
                                <div class="radio_list">
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="male" <?php echo ($member[0]['gender'] == 'male') ? 'checked="checked"' : ''; ?>/>&nbsp;&nbsp;&nbsp; Male &nbsp;
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="female" <?php echo ($member[0]['gender'] == 'female') ? 'checked="checked"' : ''; ?>/>&nbsp;&nbsp;&nbsp; Female &nbsp;
                                    <input type="radio" name="member[gender]" class="gender radio_button" value="child" <?php echo ($member[0]['gender'] == 'child') ? 'checked="checked"' : ''; ?>/>&nbsp;&nbsp;&nbsp; Child &nbsp;
                                </div>
                                <span class="error_msg"></span>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>DOB:</strong></label><span class="req">*</span>
                                <input type="text" name="member[dob]" id="dob" class="form-control required datepicker" value="<?php echo date('d/m/Y', strtotime($member[0]['dob'])); ?>" placeholder="Select Date of Birth">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <legend class="text-bold">Address Information</legend>
            <?php
            $duration_range_css = ($member[0]['on_kayalpattinam'] != 'temporary') ? 'style="display:none;"' : '';
            $duration_range_disabled = ($member[0]['on_kayalpattinam'] != 'temporary') ? 'disabled="disabled"' : '';
            $duration_range_class = ($member[0]['on_kayalpattinam'] == 'temporary') ? 'required' : '';
            ?>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Permanent Address: (Kayalpattinam)</strong></label><span class="req">*</span>
                                <input type="text" name="member[address_line_1]" id="address_line_1" class="form-control required" value="<?php echo $member[0]['address_line_1'] != '' ? $member[0]['address_line_1'] : 'Kalyalpattinam,Tamilnadu'; ?>" placeholder="Enter Permanent Address" maxlength="150">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-location4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left duration_range" <?php echo $duration_range_css; ?>>
                                <label><strong>From Date:</strong></label><span class="req">*</span>
                                <input type="text" name="member[duration_from]" id="from_date" class="form-control datepicker <?php echo $duration_range_class; ?>" readonly="readonly" placeholder="Select From Date" <?php echo $duration_range_disabled; ?> value="<?php echo (!empty($member[0]['duration_from'])) ? date('d/m/Y', strtotime($member[0]['duration_from'])) : ''; ?>">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Current Address:</strong></label><span class="req">*</span>
                                <input type="text" name="member[address_line_2]" id="address_line_2" class="form-control required" value="<?php echo $member[0]['address_line_2']; ?>" placeholder="Enter Current Address">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-location4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left duration_range" <?php echo $duration_range_css; ?>>
                                <label><strong>To Date:</strong></label><span class="req">*</span>
                                <input type="text" name="member[duration_to]" id="to_date" class="form-control datepicker <?php echo $duration_range_class; ?>" readonly="readonly" placeholder="Select To Date" <?php echo $duration_range_disabled; ?> value="<?php echo (!empty($member[0]['duration_to'])) ? date('d/m/Y', strtotime($member[0]['duration_to'])) : ''; ?>">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <label><strong>On Kayalpattinam:</strong><span class="req">*</span></label>
                                <?php if ($member[0]['on_kayalpattinam'] == 'permanent' && $location == 0) { ?>
                                    <div class="radio_list">
                                        <input type="radio" name="member[on_kayalpattinam]" id="temporary" class="on_kayalpattinam radio_button" value="temporary"> Temporary &nbsp;
                                        <input type="radio" name="member[on_kayalpattinam]" id="permanent" class="on_kayalpattinam radio_button" value="permanent"> Permanent &nbsp;
                                        <input type="radio" name="member[on_kayalpattinam]" id="out_of_kayalpattinam" class="on_kayalpattinam radio_button" value="out_of_kayalpattinam" checked="checked"> Out of Kayalpattinam
                                    </div>
                                <?php } else { ?>
                                    <div class="radio_list">
                                        <input type="radio" name="member[on_kayalpattinam]" id="temporary" class="on_kayalpattinam radio_button" value="temporary" <?php echo ($member[0]['on_kayalpattinam'] == 'temporary') ? 'checked="checked"' : ''; ?>> Temporary &nbsp;
                                        <input type="radio" name="member[on_kayalpattinam]" id="permanent" class="on_kayalpattinam radio_button" value="permanent" <?php echo ($member[0]['on_kayalpattinam'] == 'permanent') ? 'checked="checked"' : ''; ?>> Permanent &nbsp;
                                        <input type="radio" name="member[on_kayalpattinam]" id="out_of_kayalpattinam" class="on_kayalpattinam radio_button" value="out_of_kayalpattinam" <?php echo ($member[0]['on_kayalpattinam'] == 'out_of_kayalpattinam') ? 'checked="checked"' : ''; ?>> Out of Kayalpattinam
                                    </div>
                                <?php } ?>
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
                                            <input type="radio" name="member[city]" id="city" style="width:18px; margin-top:-7px"class="form-control city" value="1" <?php echo ($member[0]['city'] == '1') ? 'checked="checked"' : ''; ?>/>Kayalpattinam &nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="member[city]" id="others" style="width:18px; margin-top:-7px"  class="form-control city" value="2"<?php echo ($member[0]['city'] == '2') ? 'checked="checked"' : ''; ?> />Others &nbsp;
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
                                    <?php
                                    if (!empty($streets)) {
                                        foreach ($streets as $street) {
                                            ?>
                                            <option value="<?php echo $street['id']; ?>" <?php echo ($street['id'] == $member[0]['street_id']) ? 'selected' : ''; ?>><?php echo ucfirst($street['street_name']); ?></option>
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
                                <label><strong>Family Type:</strong></label><span class="req">*</span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal" title="Track Family"> <i class="icon-search4"></i> Track</button>
                                <select name="member[family_id]" id="family_type" class="form-control required" disabled="disabled">
                                    <?php
                                    if (!empty($groups)) {
                                        foreach ($groups as $family) {
                                            ?>
                                            <option value="<?php echo $family['id']; ?>" <?php echo ($family['id'] == $member[0]['family_id']) ? 'selected' : ''; ?>><?php echo ucfirst($family['group_name']); ?></option>
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
                                <label><strong>Relation:</strong></label><span class="req">*</span>
                                <select name="member[relation]" id="relation" class="form-control required">
                                    <?php
                                    if (!empty($relation_arr)) {
                                        foreach ($relation_arr as $relation_key => $relation_val) {
                                            ?>
                                            <option value="<?php echo $relation_key; ?>" <?php echo($member[0]['relation'] == $relation_key) ? 'selected="selected"' : ''; ?>><?php echo $relation_val; ?></option>
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
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('members'); ?>'" title="Cancel"style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
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
        $('#myModal').on('hidden.bs.modal', function () {
            $(this).find('input,textarea,select').val('').end();
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
            if (family_mobile_number == "")
            {
                $('#family_mobile_error').append('This field is required');
                setTimeout(function () {
                    $('#family_mobile_error').html('');
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
                    if (response.family_id != 0) {
                        $('#family_type option[value=' + response.family_id + ']').attr('selected', '');
                        setTimeout(function () {
                            $('.error_msg').html('');
                        }, 1000);
                    } else if (response.family_id == 0) {
                        $('#family_type').closest('div.form-group').find('.error_msg').text('Family Name not found').slideDown('500').css('display', 'inline-block');
                    }
                }
            });
        });
        $(".city").on("change", function () {
            $('#street_name').select2();
            var city = $(this).val();
            $('#street_name').empty();
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

                },
            });
        });
        $("#street_name").on("change", function () {
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

                },
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

        $('#firstname,#lastname').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $('#firstname,#lastname').closest('div.form-group').find('.error_msg').text('').slideUp('500');
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

        $('#street_id').on('change', function () {
            var street = $('#street_id').is(':selected');
            if (street != false) {
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

        $('#username').on('keyup blur', function () {
            this_val = $.trim($(this).val());
            if ($.trim($(this).val()) == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {username: $.trim($('#username').val()), id: $('#member_user_id').val()},
                    url: '<?php echo base_url(); ?>members/members/is_user_name_available/',
                    success: function (data) {
                        if (data != 0) {
                            $('#username').closest('div.form-group').find('.error_msg').text('This User Name is already taken').slideDown('500').css('display', 'inline-block');
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
                    data: {email: $.trim($('#email').val()), id: $('#member_user_id').val()},
                    url: '<?php echo base_url(); ?>members/members/is_email_address_available/',
                    success: function (data) {
                        if (data != 0) {
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
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            } else if (!is_valid) {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Mobile Number').slideDown('500').css('display', 'inline-block');
            } else {
                $.ajax({
                    type: 'POST',
                    data: {mobile: $.trim($('#mobile').val()), id: $('#member_user_id').val()},
                    url: '<?php echo base_url(); ?>members/members/is_mobile_number_available/',
                    success: function (data) {
                        if (data != 0) {
                            $('#mobile').closest('div.form-group').find('.error_msg').text('This Mobile Number is already taken').slideDown('500').css('display', 'inline-block');
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
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
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
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });

            var password = $.trim($('#password').val());
            var password_length = password.length;
            if (password != '' && password_length <= 5 && password_length >= 16) {
                $('#password').closest('div.form-group').find('.error_msg').text('Password should be between 6-15 characters').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                $('#password').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }

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
                current_username = $('#current_username').val();
                new_username = $('#username').val();
                if (current_username != new_username) {
                    $.ajax({
                        type: 'POST',
                        async: false,
                        data: {username: $.trim($('#username').val()), id: $('#member_user_id').val()},
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
                }

                current_email_address = $('#current_email_address').val();
                new_email_address = $('#email').val();
                if (current_email_address != new_email_address) {
                    $.ajax({
                        type: 'POST',
                        async: false,
                        data: {email: $.trim($('#email').val()), id: $('#member_user_id').val()},
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
                }

                current_mobile_number = $('#current_mobile_number').val();
                new_mobile_number = $('#mobile').val();
                if (current_mobile_number != new_mobile_number) {
                    $.ajax({
                        type: 'POST',
                        async: false,
                        data: {mobile: $.trim($('#mobile').val()), id: $('#member_user_id').val()},
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
