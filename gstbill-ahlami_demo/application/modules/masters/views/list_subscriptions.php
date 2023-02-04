<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Subscriptions
            <?php if ($this->user_auth->is_action_allowed('masters', 'subscriptions', 'add')): ?>
                <a href="<?php echo base_url(); ?>masters/subscriptions/add" title="Add New"><span class="label bg-info">Add New</span></a>
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
                <th>Name</th>
                <th>Mins</th>
                <th>Amount</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('masters', 'subscriptions', 'edit') || $this->user_auth->is_action_allowed('users', 'user_types', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($subscriptions)) {
                $s = 1;
                foreach ($subscriptions as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ucfirst($list['name']); ?></td>
                        <td align="center"><?php echo ($list['mins']); ?> Mins</td>
                        <td align="center"><?php echo ($list['amount']); ?> SAR</td>
                        <td align="center"><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('masters', 'subscriptions', 'edit') || $this->user_auth->is_action_allowed('masters', 'subscriptions', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('masters', 'subscriptions', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>masters/subscriptions/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('masters', 'subscriptions', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_subscriptions" subscriptions_id="<?php echo $list['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                                    <?php endif; ?>
                            </td>
                        <?php endif; ?>
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
        $(document).on('click','.delete_subscriptions',function(){
            _this = $(this);
            id = _this.attr('subscriptions_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>masters/subscriptions/delete',
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            if ($.trim(data)) {
                                _this.closest('tr').remove();
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