<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/form_select2.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDqCaUcj4_XFkzC32uLa4HUFdzvAmjXbpg&sensor=false&libraries=places'></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/location-picker/dist/locationpicker.jquery.min.js"></script>
<style type="text/css">
    .ui-datepicker { z-index: 9999 !important; }
    .center { text-align: center;}
    #imagePreview{ width:100px; height:100px; }
    image {
        width: 100px;
        height: 100px;
        position: relative;
    }
    .btn-delete {
        position: absolute;
        left: 100%;
        margin-left: -10px;
        margin-top: 2px;
        cursor: pointer;
    }
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
</style>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Event</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('events/edit/' . $event[0]['id'], 'name="edit_event" id="edit_event" class="form-horizontal"'); ?>
        <input type="hidden" name="event_id" id="event_id" value="<?php echo $event[0]['id']; ?>">
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
                                            <option value="<?php echo $type['id']; ?>" <?php echo ($type['id'] == $event[0]['event_type_id']) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($type['event_type_name']); ?></option>
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
                                <input type="text" name="event[event_name]" id="event_name" class="form-control required" value="<?php echo $event[0]['event_name']; ?>" placeholder="Enter Event Name" maxlength="200">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-clipboard2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event Start Date:</strong></label><span class="req">*</span>
                                <input type="text" name="event[from_date]" id="from_date" class="form-control required" value="<?php echo $event[0]['formatted_from_date']; ?>" placeholder="Select Event From Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 form-group">
                            <div class="form-group has-feedback has-feedback-left">
                                <label><strong>Event End Date:</strong></label><span class="req">*</span>
                                <input type="text" name="event[to_date]" id="to_date" class="form-control required" value="<?php echo $event[0]['formatted_to_date']; ?>" placeholder="Select Event To Date">
                                <span class="error_msg"></span>
                                <div class="form-control-feedback">
                                    <i class="icon-calendar3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                    <?php
                    $family_types = array ();
                    if (!empty($event[0]['family_types'])) {
                        $family_types = explode(',', $event[0]['family_types']);
                    }
                    ?>
                        <div class="col-md-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Family Type(s):</strong></label><span class="req">*</span>
                                <select name="event[family_types][]" id="family_types" class="form-control required" multiple="multiple">
                    <?php
                    if (!empty($groups)) {
                        foreach ($groups as $group) {
                            ?>
                                                                                                                                                                                                                                                                                                                                                            <option value="<?php echo $group['id']; ?>" <?php echo (in_array($group['id'], $family_types)) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($group['group_name']); ?></option>
                            <?php
                        }
                    }
                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    <?php
                    $streets_arr_list = array ();
                    if (!empty($event[0]['streets'])) {
                        $streets_arr_list = explode(',', $event[0]['streets']);
                    }
                    ?>
                        <div class="col-md-3 form-group">
                            <div class="form-group has-feedback">
                                <label><strong>Street(s):</strong></label><span class="req">*</span>
                                <select name="event[streets][]" id="streets" class="form-control required" multiple="multiple">
                    <?php
                    if (!empty($streets)) {
                        foreach ($streets as $street) {
                            ?>
                                                                                                                                                                                                                                                                                                                                                            <option value="<?php echo $street['id']; ?>" <?php echo (in_array($street['id'], $streets_arr_list)) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($street['street_name']); ?></option>
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
                                <label><strong>Upload Invitation:</strong></label>
                                <input type="file" name="invitation_image" id="invitation_image" class="form-control" placeholder="Choose file" multiple="multiple">
                                <div class="form-control-feedback">
                                    <i class="icon-file-picture"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="event[status]" class="form-control required">
                                    <option value="1" <?php echo ($event[0]['status'] == 1) ? 'selected="selected"' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($event[0]['status'] == 0) ? 'selected="selected"' : ''; ?>>Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>-->
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
                        <div class="col-xs-3">
                            <div class="form-group has-feedback">
                                <label><strong>Status:</strong></label><span class="req">*</span>
                                <select name="event[status]" class="form-control required">
                                    <option value="1" <?php echo ($event[0]['status'] == 1) ? 'selected="selected"' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($event[0]['status'] == 0) ? 'selected="selected"' : ''; ?>>Inactive</option>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-sm-6 form-group">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="event[sent_event_to_all_members]" value="1" <?php echo ($event[0]['sent_event_to_all_members'] == '1') ? 'checked="checked"' : ''; ?>>
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
                    <legend class="text-bold">Invite Members</legend>
                    <?php
                    $invited_members = json_decode($event_invited_members[0]['invited_members'], TRUE);
                    ?>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="well border-left-success border-left-lg" style="margin-bottom:15px;">
                                        <ul class="event_tree_structure">
                                            <?php
                                            $city_label = array (1 => 'Kayalpattinam', 2 => 'Others');
                                            if (!empty($members_tree)) {
                                                foreach ($members_tree as $city => $city_list) {
                                                    $city_members_arr = array_column($city_list, 'id');
                                                    $city_checked = (!array_diff($city_members_arr, $invited_members)) ? 'checked="checked"' : '';
                                                    ?>
                                                    <li class="city_tree">
                                                        <div class="city_section">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="event_city[]" class="city_item styled" value="<?php echo $city; ?>" <?php echo $city_checked; ?>> <?php echo $city_label[$city]; ?>
                                                                </label>
                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right city_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                            </div>
                                                        </div>
                                                        <ul class="city_tree_structure" style="display: none;">
                                                            <?php
                                                            if (!empty($city_list)) {
                                                                foreach ($city_list as $street_id => $street_list) {
                                                                    $street_members_arr = array_column($street_list, 'id');
                                                                    $street_checked = (!array_diff($street_members_arr, $invited_members)) ? 'checked="checked"' : '';
                                                                    ?>
                                                                    <li class="street_tree">
                                                                        <div class="street_section">
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" name="event_street[<?php echo $city; ?>][]" class="street_item styled" value="<?php echo $street_id; ?>" <?php echo $street_checked; ?>> <?php echo $streets_arr[$street_id]['street_name']; ?>
                                                                                </label>
                                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right street_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="street_tree_structure" style="display: none;">
                                                                            <?php
                                                                            if (!empty($street_list)) {
                                                                                foreach ($street_list as $group_id => $family_group) {
                                                                                    $group_members_arr = array_column($family_group, 'id');
                                                                                    $group_checked = (!array_diff($group_members_arr, $invited_members)) ? 'checked="checked"' : '';
                                                                                    ?>
                                                                                    <li class="group_tree">
                                                                                        <div class="group_section">
                                                                                            <div class="checkbox">
                                                                                                <label>
                                                                                                    <input type="checkbox" name="event_group[<?php echo $city; ?>][<?php echo $street_id; ?>][]" class="group_item styled" value="<?php echo $group_id; ?>" <?php echo $group_checked; ?>> <?php echo $groups_arr[$group_id]['group_name']; ?>
                                                                                                </label>
                                                                                                <a href="javascript:void(0);" class="btn bg-teal btn-xs pull-right group_btn"><i class="glyphicon glyphicon-plus"></i></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul class="group_tree_structure" style="display: none;">
                                                                                            <?php
                                                                                            if (!empty($family_group)) {
                                                                                                foreach ($family_group as $member_key => $member_list) {
                                                                                                    $member_checked = (in_array($member_list['id'], $invited_members)) ? 'checked="checked"' : '';
                                                                                                    ?>
                                                                                                    <li class="member_list"><input type="checkbox" name="event_member[<?php echo $city; ?>][<?php echo $street_id; ?>][<?php echo $group_id; ?>][]" class="member_item styled" value="<?php echo $member_list['id']; ?>" <?php echo $member_checked; ?>> <?php echo $member_list['firstname'] . ' ' . $member_list['lastname'] . '' . '-' . $member_list['relation']; ?></li>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table id="features_table" class="table table-bordered table-striped table-hover dtr-inline margin0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">S.No</th>
                                            <th style="width: 80%; text-align: center;">Invitations</th>
                                            <th style="width: 10%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($event_invitations) && !empty($event_invitations)) {
                                            $s = 1;
                                            foreach ($event_invitations as $value) {
                                                ?>
                                                <tr>
                                                    <td class="s_no"><?php echo $s; ?></td>
                                                    <td class="center">
                                                        <a href="javascript:void(0);"><img src="<?php echo base_url() . 'attachments/events/invitations/' . $value['file_name']; ?>" class="delete<?php echo $value['id']; ?>" style="width: 100%; height: 150px; border: 1px #ccc solid; padding: 3px;" title="<?php echo $value['file_name']; ?>" ></a>
                                                    </td>
                                                    <td class="center">
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_invitation" img_id="<?php echo $value['id']; ?>"><i class="icon-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $s++;
                                            }
                                        } else {
                                            ?>
                                            <tr><td colspan="3">No Invitations found</td></tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px; margin-bottom: 15px;">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label><strong>Event Location:</strong></label>
                                <div id="map" style="height: 400px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="event_fields" style="margin:15px 0px 15px 0px;">
                        <?php
                        $form_text = '';
                        $form_field_text = '';
                        $num = 1;
                        if (!empty($event_dynamic_fields)) {
                            foreach ($event_dynamic_fields as $field_id => $fieldInfo) {
                                $dynamic_data = $event_dynamic_values[$field_id];
                                $fieldData = json_decode($fieldInfo['field_data'], TRUE);
                                $fieldID = (!empty($dynamic_data['field_id'])) ? $dynamic_data['field_id'] : $fieldInfo['id'];
                                $fieldType = $fieldData['type'];
                                $fieldLabel = $fieldData['label'];
                                $fieldValue = $dynamic_data['value'];
                                $fieldOptions = !empty($fieldData['values']) ? $fieldData['values'] : array ();
                                $fieldRequired = (!empty($fieldData['required'])) ? $fieldData['required'] : 0;
                                $fieldPlaceholder = (!empty($fieldData['placeholder'])) ? $fieldData['placeholder'] : '';
                                $fieldLength = (!empty($fieldData['maxlength'])) ? $fieldData['maxlength'] : '';
                                $fieldRows = (!empty($fieldData['rows'])) ? $fieldData['rows'] : '';
                                $is_multiple = (!empty($fieldData['multiple'])) ? $fieldData['multiple'] : 0;
                                $is_required = ($fieldRequired == 1) ? 'required' : '';
                                $required_text = ($fieldRequired == 1) ? '<span class="req">*</span>' : '';
                                $maxlength_text = ($fieldLength != '') ? 'maxlength="' . $fieldLength . '"' : '';
                                $multiple_text = ($is_multiple == 1) ? 'multiple="multiple"' : '';
                                $field_text = '';
                                switch ($fieldType) {
                                    case 'text':
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback has-feedback-left">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= '<input type="text" name="dynamic[' . $fieldID . ']" class="form-control ' . $is_required . '" value="' . $fieldValue . '" placeholder="' . $fieldPlaceholder . '" ' . $maxlength_text . '>';
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-clipboard2"></i></div>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'date':
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback has-feedback-left">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= '<input type="text" name="dynamic[' . $fieldID . ']" class="form-control dynamic_datepicker ' . $is_required . '" value="' . $fieldValue . '" readonly="readonly" placeholder="' . $fieldPlaceholder . '">';
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-calendar3"></i></div>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'number':
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback has-feedback-left">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= '<input type="number" name="dynamic[' . $fieldID . ']" class="form-control ' . $is_required . '" value="' . $fieldValue . '" placeholder="' . $fieldPlaceholder . '">';
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-clipboard2"></i></div>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'file':
                                        $fieldValue_arr = explode(',', $fieldValue);
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= '<input type="file" name="dynamic[' . $fieldID . ']" class="form-control dynamic_file ' . $is_required . '" placeholder="' . $fieldPlaceholder . '" ' . $multiple_text . '>';
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-file-picture"></i></div>';
                                        $field_text .= '</div>';
                                        $fieldValue_arr = array_filter($fieldValue_arr);
                                        if (!empty($fieldValue_arr)) {
                                            $field_text .= '<table class="table table-bordered table-striped table-hover dynamic_file_table">';
                                            $field_text .= '<thead>
                                                            <tr>
                                                                <th style="width: 10%;">S.No</th>
                                                                <th style="width: 55%; text-align: center;">File Name</th>
                                                                <th style="width: 35%;">Actions</th>
                                                            </tr>
                                                        </thead><tbody>';
                                            $k = 1;
                                            foreach ($fieldValue_arr as $file_name) {
                                                $field_text .= '<tr>
                                                                <td>' . $k . '</td>
                                                                <td>' . $file_name . '</td>
                                                                <td>
                                                                <a href="' . base_url() . '/attachments/events/dynamic_images/' . $file_name . '" class="btn btn-info btn-xs view_dynamic_file" file_name="' . $file_name . '" title="View" target="_blank"><i class="icon-eye"></i></a>&nbsp;
                                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_dynamic_file" file_name="' . $file_name . '" field_id="' . $fieldID . '" event_id="' . $event[0]['id'] . '" title="Delete" target="_blank"><i class="icon-trash"></i></a>
                                                                </td>
                                                            </tr>';
                                                $k++;
                                            }
                                            $field_text .= '</tbody></table>';
                                        }
                                        $field_text .= '</div>';
                                        break;
                                    case 'textarea':
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback has-feedback-left">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= '<textarea name="dynamic[' . $fieldID . ']" class="form-control ' . $is_required . '" placeholder="' . $fieldPlaceholder . '" ' . $maxlength_text . ' rows="' . $fieldRows . '" style="resize:vertical;">' . $fieldValue . '</textarea>';
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-clipboard2"></i></div>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'select':
                                        $multiple_box = ($is_multiple) ? '[]' : '';
                                        $option_text = '';
                                        $option_text .= '<option value="">' . $fieldPlaceholder . '</option>';
                                        $fieldValue_arr = explode(',', $fieldValue);
                                        if (!empty($fieldOptions)) {
                                            foreach ($fieldOptions as $option) {
                                                $selected = (is_array($fieldValue_arr) && in_array($option['value'], $fieldValue_arr)) ? 'selected="selected"' : '';
                                                $option_text .= '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
                                            }
                                        }
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group has-feedback has-feedback-left">';
                                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        if ($is_multiple) {
                                            $field_text .= '<select name="dynamic[' . $fieldID . '][]" class="form-control ' . $is_required . '" ' . $multiple_text . '>' . $option_text . '</select>';
                                        } else {
                                            $field_text .= '<select name="dynamic[' . $fieldID . ']" class="form-control ' . $is_required . '" ' . $multiple_text . '>' . $option_text . '</select>';
                                        }
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '<div class="form-control-feedback"><i class="icon-clipboard2"></i></div>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'checkbox-group':
                                        $option_text = '';
                                        $fieldValue_arr = explode(',', $fieldValue);
                                        if (!empty($fieldOptions)) {
                                            foreach ($fieldOptions as $option) {
                                                $checked = (is_array($fieldValue_arr) && in_array($option['value'], $fieldValue_arr)) ? 'checked="checked"' : '';
                                                $option_text .= '<div class="checkbox"><label><input type="checkbox" name="dynamic[' . $fieldID . '][]" value="' . $option['value'] . '" ' . $checked . '>' . $option['label'] . '</label></div>';
                                            }
                                        }
                                        $field_text .= '<input type="hidden" name="dynamic[' . $fieldID . ']" value="">';
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group">';
                                        $field_text .= '<label class="text-semibold"><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= $option_text;
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    case 'radio-group':
                                        $option_text = '';
                                        if (!empty($fieldOptions)) {
                                            foreach ($fieldOptions as $option) {
                                                $checked = ($option['value'] == $fieldValue) ? 'checked="checked"' : '';
                                                $option_text .= '<div class="radio"><label><input type="radio" name="dynamic[' . $fieldID . ']" value="' . $option['value'] . '" ' . $checked . '>' . $option['label'] . '</label></div>';
                                            }
                                        }
                                        $field_text .= '<input type="hidden" name="dynamic[' . $fieldID . ']" value="">';
                                        $field_text .= '<div class="col-xs-4">';
                                        $field_text .= '<div class="form-group">';
                                        $field_text .= '<label class="text-semibold"><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                                        $field_text .= $option_text;
                                        $field_text .= '<span class="error_msg"></span>';
                                        $field_text .= '</div>';
                                        $field_text .= '</div>';
                                        break;
                                    default:
                                        break;
                                }
                                //$field_text .= '<input type="hidden" name="dynamic_id[' . $fieldLabel . ']" value="' . $fieldID . '">';
                                $form_field_text .= $field_text;
                                if ($num == 3) {
                                    $form_text .= '<div class="row" style="margin-bottom:15px;">' . $form_field_text . '</div>';
                                    $form_field_text = '';
                                    $num = 0;
                                }
                                $num++;
                            }
                            if ($form_field_text != '') {
                                $form_text .= '<div class="row">' . $form_field_text . '</div>';
                                $form_field_text = '';
                            }
                        }
                        echo $form_text;
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('events'); ?>'" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                        <button type="submit" class="btn btn-success submit" style="float:right;">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $('#map').locationpicker({
        location: {latitude: value = "<?php echo $event[0]['latitude']; ?>", longitude: value = "<?php echo $event[0]['longitude']; ?>"},
        radius: 0,
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

    $('#event_type_id').on('change', function () {
        var event_type_id = $('#event_type_id').is(':selected');
        if (event_type_id != false) {
            $(this).closest('div.form-group').find('#evetype_err').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('#evetype_err').text('').slideUp('500');
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
            if (!$(e.target).hasClass('group_item')) {
                $(this).closest('.group_tree').find('a.group_btn i').toggleClass('glyphicon-plus glyphicon-minus');
                this_ele.closest('.group_tree').find('.group_tree_structure').slideToggle(500);
            }
        });

        $('.street_section').click(function (e) {
            this_ele = $(this);
            if (!$(e.target).hasClass('street_item')) {
                $(this).closest('.street_tree').find('a.group_btn i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                $(this).closest('.street_tree').find('a.street_btn i').toggleClass('glyphicon-plus glyphicon-minus');
                this_ele.closest('.street_tree').find('.group_tree_structure').slideUp(500);
                this_ele.closest('.street_tree').find('.street_tree_structure').slideToggle(500);
            }
        });

        $('.city_section').click(function (e) {
            this_ele = $(this);
            if (!$(e.target).hasClass('city_item')) {
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
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', false);
            }
        });

        $('.group_item').change(function () {
            is_checked = $(this).prop('checked');
            if (is_checked) {
                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $(this).closest('.group_tree').find('input[type="checkbox"]').prop('checked', false);
            }
            total_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"][class="group_item"]').length);
            selected_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"][class="group_item"]:checked').length);
            if (total_groups == selected_groups) {
                $(this).closest('.street_tree').find('input[type="checkbox"][class="street_item"]').prop('checked', true);
            } else {
                $(this).closest('.street_tree').find('input[type="checkbox"][class="street_item"]').prop('checked', false);
            }
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', false);
            }
        });

        $('.member_item').change(function () {
            is_checked = $(this).prop('checked');
            total_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]').length);
            selected_members = Number($(this).closest('.group_tree_structure').find('input[type="checkbox"]:checked').length);
            if (total_members == selected_members) {
                $(this).closest('.group_tree').find('input[type="checkbox"][class="group_item"]').prop('checked', true);
            } else {
                $(this).closest('.group_tree').find('input[type="checkbox"][class="group_item"]').prop('checked', false);
            }
            total_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"][class="group_item"]').length);
            selected_groups = Number($(this).closest('.street_tree_structure').find('input[type="checkbox"][class="group_item"]:checked').length);
            if (total_groups == selected_groups) {
                $(this).closest('.street_tree').find('input[type="checkbox"][class="street_item"]').prop('checked', true);
            } else {
                $(this).closest('.street_tree').find('input[type="checkbox"][class="street_item"]').prop('checked', false);
            }
            total_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]').length);
            selected_streets = Number($(this).closest('.city_tree_structure').find('input[type="checkbox"][class="street_item"]:checked').length);
            if (total_streets == selected_streets) {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', true);
            } else {
                $(this).closest('.city_tree').find('input[type="checkbox"][class="city_item"]').prop('checked', false);
            }
        });

        $('#family_types,#streets').select2({
            minimumResultsForSearch: Infinity
        });

        $('#from_date,#to_date').datetimepicker({
            dateFormat: 'dd/mm/yy', minDate: 0
        });

        $('.dynamic_datepicker').pickadate({
            format: 'dd/mm/yyyy',
            formatSubmit: 'dd/mm/yyyy',
            selectYears: true,
            selectMonths: true,
            selectYears: 100
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
                url: '<?php echo base_url(); ?>events/generate_form_by_event_type/',
                success: function (data) {
                    $('.event_fields').html('');
                    $('.event_fields').append(data)
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

        $('.delete_invitation').click(function () {
            id = $(this).attr('img_id');
            $.confirm({
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>events/events/delete_invitation',
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            if (data == '1') {
                                window.location.reload();
                            }
                        }
                    });
                },
            });
        });

        $('.delete_dynamic_file').click(function () {
            event_id = $(this).attr('event_id');
            field_id = $(this).attr('field_id');
            file_name = $(this).attr('file_name');
            $.confirm({
                confirm: function () {
                    $.ajax({
                        url: '<?php echo base_url(); ?>events/events/delete_dynamic_field_attachment',
                        method: 'POST',
                        data: {event_id: event_id, field_id: field_id, file_name: file_name},
                        success: function (data) {
                            if (data == '1') {
                                window.location.reload();
                            }
                        }
                    });
                },
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