<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<!-- Theme JS files -->
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/form_select2.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDqCaUcj4_XFkzC32uLa4HUFdzvAmjXbpg&sensor=false&libraries=places'></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/location-picker/dist/locationpicker.jquery.min.js"></script>
<style type="text/css">
    .ui-datepicker { z-index: 9999 !important; }
    #imagePreview{ width:100px; height:100px; }
    .event_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        cursor: pointer;
    }
    .city_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
    }
    .city_tree {
        margin-bottom: 7px;
    }
    .city_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .street_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        margin-bottom: 10px;
    }
    .street_tree {
        margin-bottom: 7px;
    }
    .street_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .group_tree_structure {
        list-style-type: none;
        border: 1px #ddd solid;
        padding: 10px;
        margin-bottom: 10px;
    }
    .group_tree {
        margin-bottom: 7px;
    }
    .group_section {
        border: 1px #ddd solid;
        background-color: #e2e2e2;
        padding: 7px;
    }
    .member_list {
        list-style-type: none;
    }
    .event_tree_structure .checkbox {
        min-height: 35px;
    }
    .badge {
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #f44336de;
        border-radius: 10px;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Add New Event</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('members/events/add', 'name="add_event" id="add_event" class="form-horizontal"'); ?>
        <fieldset class="content-group">
            <legend class="text-bold">Event Information</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event Type:</strong></label><span class="req">*</span>
                                <select name="event[event_type_id]" id="event_type_id" class="form-control required">
                                    <option value="">Select Event Type</option>
                                    <?php
                                    if (!empty($event_types)) {
                                        foreach ($event_types as $type) {
                                            ?>
                                            <option value="<?php echo $type['id']; ?>"><?php echo ucfirst($type['event_type_name']); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-stack"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event Name:</strong></label><span class="req">*</span>
                                <input type="text" name="event[event_name]" id="event_name" class="form-control required" placeholder="Enter Event Name" maxlength="200">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-clipboard2"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event Start Date:</strong></label><span class="req">*</span>
                                <input type="text" name="event[from_date]" id="from_date" class="form-control required" placeholder="Select Event From Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event End Date:</strong></label><span class="req">*</span>
                                <input type="text" name="event[to_date]" id="to_date" class="form-control required" placeholder="Select Event To Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Upload Invitation:</strong></label>
                                <input type="file" name="invitation_image" id="invitation_image" class="form-control" placeholder="Choose file" multiple="multiple">
                                <div class="form-control-feedback">
                                    <i class="icon-file-picture"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Latitude:</strong></label>
                                <input type="text" name="event[latitude]" id="latitude" class="form-control" placeholder="Enter Latitude">
                                <div class="form-control-feedback">
                                    <i class="icon-location3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Longitude:</strong></label>
                                <input type="text" name="event[longitude]" id="longitude" class="form-control" placeholder="Enter Longitude">
                                <div class="form-control-feedback">
                                    <i class="icon-location3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="event[status]" class="form-control required">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-md-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Family Type(s):</strong></label><span class="req">*</span>
                                <select name="event[family_types][]" id="family_types" class="form-control required" multiple="multiple">
                    <?php
                    if (!empty($groups)) {
                        foreach ($groups as $group) {
                            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <option value="<?php echo $group['id']; ?>"><?php echo ucfirst($group['group_name']); ?></option>
                            <?php
                        }
                    }
                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Street(s):</strong></label><span class="req">*</span>
                                <select name="event[streets][]" id="streets" class="form-control required" multiple="multiple">
                    <?php
                    if (!empty($streets)) {
                        foreach ($streets as $street) {
                            ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <option value="<?php echo $street['id']; ?>"><?php echo ucfirst($street['street_name']); ?></option>
                            <?php
                        }
                    }
                    ?>
                                </select>
                                <span class="error_msg"></span>
                                <span id="street_err" class="val" style="color:#F00; font-style:oblique;"></span>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Upload Invitation:</strong></label>
                                <input type="file" name="invitation_image" id="invitation_image" class="form-control" placeholder="Choose file" multiple="multiple">
                                <div class="form-control-feedback">
                                    <i class="icon-file-picture"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="event[status]" class="form-control required">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="event[sent_event_to_all_members]" value="1">
                                        <b>Send event to all Kayalpattinam members</b>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Latitude:</strong></label>
                                <input type="text" name="event[latitude]" id="latitude" class="form-control" placeholder="Enter Latitude">
                                <div class="form-control-feedback">
                                    <i class="icon-location3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Longitude:</strong></label>
                                <input type="text" name="event[longitude]" id="longitude" class="form-control" placeholder="Enter Longitude">
                                <div class="form-control-feedback">
                                    <i class="icon-location3"></i>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <legend class="text-bold">Invite Members <span class="heading-text" style="float:right; font-size: 13px; color: #3a352a; font-weight: bold;">Total Invited Members : <span id="mem_count" class="badge bg-info-400 heading-text text-bold position-right">0</span></span></legend>
                    <div class="form-group">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="well border-left-success border-left-lg" style="margin-bottom:15px;">
                                        <ul class="event_tree_structure">
                                            <?php
                                            $city_label = array (1 => 'Kayalpattinam', 2 => 'Others');
                                            if (!empty($members_tree)) {
                                                foreach ($members_tree as $city => $city_list) {
                                                    $count_city = $members_count['city'][$city];
                                                    ?>
                                                    <li class="city_tree">
                                                        <div class="city_section">
                                                            <div class="checkbox">
                                                                <label class="city_label">
                                                                    <input type="checkbox" name="event_city[]" class="city_item" value="<?php echo $city; ?>"> <?php echo $city_label[$city]; ?>
                                                                </label>
                                                                <span class="badge bg-pink"><?php echo $count_city; ?></span>
                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right city_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                            </div>
                                                        </div>
                                                        <ul class="city_tree_structure" style="display: none;">
                                                            <?php
                                                            if (!empty($city_list)) {
                                                                foreach ($city_list as $street_id => $street_list) {
                                                                    $count_street = $members_count['street'][$street_id];
                                                                    ?>
                                                                    <li class="street_tree">
                                                                        <div class="street_section">
                                                                            <div class="checkbox">
                                                                                <label class="street_label">
                                                                                    <input type="checkbox" name="event_street[<?php echo $city; ?>][]" class="street_item" value="<?php echo $street_id; ?>"> <?php echo $streets_arr[$street_id]['street_name']; ?>
                                                                                </label>
                                                                                <span class="badge bg-pink"><?php echo $count_street; ?></span>
                                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right street_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="street_tree_structure" style="display: none;">
                                                                            <?php
                                                                            if (!empty($street_list)) {
                                                                                foreach ($street_list as $group_id => $family_group) {
                                                                                    $count_family = $members_count['group'][$group_id];
                                                                                    ?>
                                                                                    <li class="group_tree">
                                                                                        <div class="group_section">
                                                                                            <div class="checkbox">
                                                                                                <label class="group_label">
                                                                                                    <input type="checkbox" name="event_group[<?php echo $city; ?>][<?php echo $street_id; ?>][]" class="group_item" value="<?php echo $group_id; ?>"> <?php echo $groups_arr[$group_id]['group_name']; ?>
                                                                                                </label>
                                                                                                <span class="badge bg-pink"><?php echo $count_family; ?></span>
                                                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right group_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul class="group_tree_structure" style="display: none;">
                                                                                            <?php
                                                                                            if (!empty($family_group)) {
                                                                                                foreach ($family_group as $member_key => $member_list) {
                                                                                                    ?>
                                                                                                    <li class="member_list"><input type="checkbox" name="event_member[<?php echo $city; ?>][<?php echo $street_id; ?>][<?php echo $group_id; ?>][]" class="member_item" value="<?php echo $member_list['id']; ?>"> <?php echo $member_list['firstname'] . ' ' . $member_list['lastname']; ?></li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </ul>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">&nbsp;</div>
                        <div class="row" style="margin-top:15px; margin-bottom: 15px;">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label><strong>Event Location:</strong></label>
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="event_fields" style="margin:15px 0px 15px 0px;"></div>
                    </div>
                    <div class="row" style="margin-top:7px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('members/events'); ?>'" style="float:left;" title="Cancel"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                            <button type="submit" class="btn btn-success submit" style="float:right;" title="Submit">Submit <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $('#map').locationpicker({
        location: {latitude: 8.565985, longitude: 78.123793},
        radius: 0,
        locationName: '',
        inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude'),
            radiusInput: null,
            locationNameInput: null
        }
    });

    $('#event_name').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if (this_val == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#from_date,#to_date').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if (this_val == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#event_type_id').on('change', function () {
        var event_type_id = $('#event_type_id').is(':selected');
        if (event_type_id != false) {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });

    $('#family_types').on('change', function () {
        var this_val = $('#family_types').val();
        if (this_val == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });

    $('#streets').on('change', function () {
        var this_val = $('#streets').val();
        if (this_val == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });

    $(document).ready(function () {
        $('.group_section').click(function (e) {
            this_ele = $(this);
            if (!$(e.target).hasClass('group_item') && !$(e.target).hasClass('group_label')) {
                $(this).closest('.group_tree').find('a.group_btn i').toggleClass('glyphicon-plus glyphicon-minus');
                this_ele.closest('.group_tree').find('.group_tree_structure').slideToggle(500);
            }
        });

        $('.street_section').click(function (e) {
            this_ele = $(this);
            if (!$(e.target).hasClass('street_item') && !$(e.target).hasClass('street_label')) {
                $(this).closest('.street_tree').find('a.group_btn i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                $(this).closest('.street_tree').find('a.street_btn i').toggleClass('glyphicon-plus glyphicon-minus');
                this_ele.closest('.street_tree').find('.group_tree_structure').slideUp(500);
                this_ele.closest('.street_tree').find('.street_tree_structure').slideToggle(500);
            }
        });

        $('.city_section').click(function (e) {
            this_ele = $(this);
            if (!$(e.target).hasClass('city_item') && !$(e.target).hasClass('city_label')) {
                $(this).closest('.city_tree').find('a.group_btn i,a.street_btn i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                $(this).closest('.city_tree').find('a.city_btn i').toggleClass('glyphicon-plus glyphicon-minus');
                this_ele.closest('.city_tree').find('.street_tree_structure,.group_tree_structure').slideUp(500);
                this_ele.closest('.city_tree').find('.city_tree_structure').slideToggle(500);
            }
        });

        $('.city_item').change(function () {
            is_checked = $(this).prop('checked');
            if (is_checked) {
                $(this).closest('.city_tree').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"]').prop('checked', false);
            }
        });

        $('.street_item').change(function () {
            is_checked = $(this).prop('checked');
            if (is_checked) {
                $(this).closest('.street_tree').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $(this).closest('.street_tree').find('input[type="checkbox"]').prop('checked', false);
            }
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', false);
            }
        });

        $('.group_item').change(function () {
            is_checked = $(this).prop('checked');
            if (is_checked) {
                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', false);
            }
            total_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"].group_item').length);
            selected_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"].group_item:checked').length);
            if (total_groups == selected_groups) {
                $(this).closest('.street_tree').find('input[type="checkbox"].street_item').prop('checked', true);
            } else {
                $(this).closest('.street_tree').find('input[type="checkbox"].street_item').prop('checked', false);
            }
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', false);
            }
        });

        $('.member_item').change(function () {
            is_checked = $(this).prop('checked');
            total_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]').length);
            selected_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]:checked').length);
            if (total_members == selected_members) {
                $(this).closest('.group_tree').find('input[type="checkbox"].group_item').prop('checked', true);
            } else {
                $(this).closest('.group_tree').find('input[type="checkbox"].group_item').prop('checked', false);
            }
            total_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"].group_item').length);
            selected_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"].group_item:checked').length);
            if (total_groups == selected_groups) {
                $(this).closest('.street_tree').find('input[type="checkbox"].street_item').prop('checked', true);
            } else {
                $(this).closest('.street_tree').find('input[type="checkbox"].street_item').prop('checked', false);
            }
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"].street_item:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"].city_item').prop('checked', false);
            }
        });

        $('#family_types,#streets').select2({
            minimumResultsForSearch: Infinity
        });

        $('#from_date,#to_date').datetimepicker({
            dateFormat: 'dd/mm/yy', minDate: 0
        });
        $('.event_tree_structure').change(function () {
            var total = $('.member_item:checked').size();
            $('#mem_count').text(total);
        });
        /*$('#from_date').on('dp.change', function (e) {
         $('#to_date').data('DateTimePicker').minDate(e.date);
         });

         $('#to_date').on('dp.change', function (e) {
         minDate: today;
         $('#from_date').data('DateTimePicker').maxDate(e.date);
         });*/

        $('#invitation_image').on('change', function () {
            var files = this.files;
            if (files && files[0]) {
                readImage(files[0], '#invitation_image');
            }
        });

        $('#event_type_id').on('change', function () {
            event_type_id = $(this).val();
            $.ajax({
                type: 'POST',
                data: {event_type: event_type_id},
                url: '<?php echo base_url(); ?>members/events/generate_form_by_event_type/',
                success: function (data) {
                    $('.event_fields').html('');
                    $('.event_fields').append(data);
                    $('.dynamic_datepicker').pickadate({
                        format: 'dd/mm/yyyy',
                        formatSubmit: 'dd/mm/yyyy',
                        selectYears: true,
                        selectMonths: true,
                        selectYears: 100
                    });
                    return false;
                }
            });
        });

        $('.submit').click(function () {
            m = 0;
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else if (this_id == 'to_date' && from_date != '' && to_date != '' && from_date > to_date) {
                    $(this).closest('div.form-group').find('.error_msg').text('Event End Date should be greater than Event Start Date').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
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
                        error = 0;
                    } else {
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