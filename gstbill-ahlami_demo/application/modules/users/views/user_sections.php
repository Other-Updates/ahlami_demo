<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage User Sections
            <?php if ($this->user_auth->is_action_allowed('users', 'user_sections', 'add')): ?>
                <a href="<?php echo base_url(); ?>users/user_sections/add" title="Add New"><span class="label bg-success">Add New</span></a>
            <?php endif; ?>
        </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table class="table datatable-basic table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>User Section Name</th>
                <th>User Module Name</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('users', 'user_sections', 'edit') || $this->user_auth->is_action_allowed('users', 'user_sections', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($user_sections)) {
                foreach ($user_sections as $list) {
                    ?>
                    <tr>
                        <td><?php echo ucfirst($list['user_section_name']); ?></td>
                        <td><?php echo ucfirst($list['user_module_name']); ?></td>
                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('users', 'user_sections', 'edit') || $this->user_auth->is_action_allowed('users', 'user_sections', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('users', 'user_sections', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>users/user_sections/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('users', 'user_sections', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_user_section" user_section_id="<?php echo $list['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                                    <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('th.sorting_disabled').css('width', '135px');

        $('.delete_user_section').click(function () {
            id = $(this).attr('user_section_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    user_section_id = ($(this).attr('user_section_id'));
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() . 'users/user_sections/delete/'; ?>' + user_section_id,
                        success: function (data) {
                            if (data == '1') {
                                window.location = '<?php echo base_url(); ?>users/user_sections';
                            }
                        }
                    });
                },
                cancel: function (button) {
                },
                confirmButton: 'Yes',
                cancelButton: 'No'
            });
        });
    });
</script>