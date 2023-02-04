<?php $theme_path = $this->config->item('theme_locations') . 'zimson'; ?>
<!-- Form horizontal -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">User Types - Permissions <span class="label label-default" style="border-color: #FF9800; background-color: #FF9800;"><?php echo strtoupper($user_type[0]['user_type_name']); ?></span></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <?php echo form_open_multipart('users/user_types/view/' . $user_type_id, 'name="user_permission" id="user_permission" class="form-horizontal"'); ?>
        <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
        <div class="row">
            <div class="form-group">
                <div class="checkbox" style="float:right; margin-right: 15px;">
                    <label>
                        <input type="checkbox" name="grand_all" class="grand_all" value="1" <?php echo (isset($user_type[0]['grand_all']) && $user_type[0]['grand_all'] == 1) ? 'checked' : ''; ?>><span class="text-semibold">Grand All</span>
                    </label>
                </div>
            </div>
        </div>
        <?php
        $is_module_allowed = $this->config->item('user_modules');
        $is_section_allowed = $this->config->item('user_sections');
        ?>
        <fieldset class="content-group">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>Section</th>
                            <th>Enable Menu</th>
                            <th>View</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($user_sections)) {
                            foreach ($user_sections as $key => $value) {
                                if (!empty($value['sections'])) {
                                    $k = 1;
                                    foreach ($value['sections'] as $section) {
                                        if (($section['user_section_key'] == 'user_modules' && $is_module_allowed) || ($section['user_section_key'] == 'user_sections' && $is_section_allowed) || (!in_array($section['user_section_key'], array('user_modules', 'user_sections')))) {
                                            $checked_all = (isset($user_permissions[$key][$section['id']]['acc_all']) && $user_permissions[$key][$section['id']]['acc_all'] == 1) ? 'checked' : '';
                                            $checked_view = (isset($user_permissions[$key][$section['id']]['acc_view']) && $user_permissions[$key][$section['id']]['acc_view'] == 1) ? 'checked' : '';
                                            $checked_add = (isset($user_permissions[$key][$section['id']]['acc_add']) && $user_permissions[$key][$section['id']]['acc_add'] == 1) ? 'checked' : '';
                                            $checked_edit = (isset($user_permissions[$key][$section['id']]['acc_edit']) && $user_permissions[$key][$section['id']]['acc_edit'] == 1) ? 'checked' : '';
                                            $checked_delete = (isset($user_permissions[$key][$section['id']]['acc_delete']) && $user_permissions[$key][$section['id']]['acc_delete'] == 1) ? 'checked' : '';
                                            ?>
                                            <tr class="danger">
                                                <td><strong><?php echo ($k == 1) ? ucfirst($value['user_module_name']) : ''; ?></strong></td>
                                                <td><?php echo ucfirst($section['user_section_name']); ?></td>
                                                <td align="center"><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_all]" class="menu_all" value="1" <?php echo $checked_all; ?> /></td>
                                                <?php if ($section['acc_view'] == 1): ?>
                                                    <td align="center"><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_view]" class="allow_access" value="1" <?php echo $checked_view; ?> /></td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_view'] == 0): ?>
                                                    <td align="center">NA</td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_add'] == 1): ?>
                                                    <td align="center"><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_add]" class="allow_access" value="1" <?php echo $checked_add; ?> /></td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_add'] == 0): ?>
                                                    <td align="center">NA</td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_edit'] == 1): ?>
                                                    <td align="center"><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_edit]" class="allow_access" value="1" <?php echo $checked_edit; ?> /></td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_edit'] == 0): ?>
                                                    <td align="center">NA</td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_delete'] == 1): ?>
                                                    <td align="center"><input type="checkbox" name="permissions[<?php echo $key; ?>][<?php echo $section['id']; ?>][acc_delete]" class="allow_access" value="1" <?php echo $checked_delete; ?> /></td>
                                                <?php endif; ?>
                                                <?php if ($section['acc_delete'] == 0): ?>
                                                    <td align="center">NA</td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php
                                            $k++;
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('users/user_types'); ?>'" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
                <button type="submit" class="btn btn-success submit" style="float:right;">Submit <i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /form horizontal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.menu_all').click(function () {
            if ($(this).prop('checked') == true) {
                $(this).closest('tr').find('input.allow_access').prop('checked', true);
            } else {
                $(this).closest('tr').find('input.allow_access').removeAttr('checked');
            }

            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);
            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);
            if (total_checkbox == checked_checkbox) {
                $('input.grand_all').prop('checked', true);
            } else {
                $('input.grand_all').removeAttr('checked');
            }
        });

        $('.grand_all').click(function () {
            if ($(this).prop('checked') == true) {
                $('input.allow_access,input.menu_all').prop('checked', true);
            } else {
                $('input.allow_access,input.menu_all').removeAttr('checked');
            }
        });

        $('.allow_access').click(function () {
            length = Number($(this).closest('tr').find('input.allow_access:checked').length);
            if (length == 4) {
                $(this).closest('tr').find('input.menu_all').prop('checked', true);
            } else {
                $(this).closest('tr').find('input.menu_all').removeAttr('checked');
            }
            total_checkbox = Number($('input[type=checkbox].allow_access,input[type=checkbox].menu_all').length);
            checked_checkbox = Number($('input[type=checkbox].allow_access:checked,input[type=checkbox].menu_all:checked').length);
            if (total_checkbox == checked_checkbox) {
                $('input.grand_all').prop('checked', true);
            } else {
                $('input.grand_all').removeAttr('checked');
            }
        });
    });
</script>