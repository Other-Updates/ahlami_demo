<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage User Types
            <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'add')): ?>
                <a href="<?php echo base_url(); ?>users/user_types/add" title="Add New"><span class="label bg-info">Add New</span></a>
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
                <th>S.No</th>
                <th>User Type Name</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'edit') || $this->user_auth->is_action_allowed('users', 'user_types', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($user_types)) {
                $s = 1;
                foreach ($user_types as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ucfirst($list['user_type_name']); ?></td>
                        <td align="center"><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'edit') || $this->user_auth->is_action_allowed('users', 'user_types', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>users/user_types/view/<?php echo $list['id']; ?>" class="btn btn-warning btn-xs" title="View Settings"><i class="icon-cog3"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>users/user_types/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('users', 'user_types', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_user_type" user_type_id="<?php echo $list['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    $s++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('th.sorting_disabled').css('width', '135px');

        $('.delete_user_type').click(function () {
            id = $(this).attr('user_type_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>users/user_types/delete',
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            if (data == '1') {
                                window.location = '<?php echo base_url(); ?>users/user_types';
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