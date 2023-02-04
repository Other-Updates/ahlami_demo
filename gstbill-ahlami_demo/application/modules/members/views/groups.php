<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Groups
            <?php if ($this->user_auth->is_action_allowed('members', 'groups', 'add')): ?>
                <a href="<?php echo base_url(); ?>members/groups/add" title="Add New"><span class="label bg-success">Add New</span></a>
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
                <th>City</th>
                <th>Street</th>
                <th>Group Name</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('members', 'groups', 'edit') || $this->user_auth->is_action_allowed('members', 'groups', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($groups)) {
                $s = 1;
                foreach ($groups as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ($list['city'] == 1) ? 'Kayalpattinam' : 'Others' ?></td>
                        <td><?php echo ucfirst($list['street_name']); ?></td>
                        <td><?php echo ucfirst($list['group_name']); ?></td>
                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('members', 'groups', 'edit') || $this->user_auth->is_action_allowed('members', 'groups', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('members', 'groups', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>members/groups/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('members', 'groups', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_group" group_id="<?php echo $list['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

        $('.delete_group').click(function () {
            id = $(this).attr('group_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        method: 'POST',
                        url: '<?php echo base_url(); ?>members/groups/delete',
                        data: {id: id},
                        success: function (data) {
                            if (data == '1') {
                                window.location = '<?php echo base_url(); ?>members/groups';
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