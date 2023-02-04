<?php $theme_path = $this->config->item('theme_locations') . 'scootero'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage ScooterO
            <?php if ($this->user_auth->is_action_allowed('masters', 'scooterO', 'add')): ?>
                <a href="<?php echo base_url(); ?>masters/scooterO/add" title="Add New"><span class="label bg-info">Add New</span></a>
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
                <th>Serial Number</th>
                <th>Battery Life</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('masters', 'scooterO', 'edit') || $this->user_auth->is_action_allowed('masters', 'scooterO', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($scooterO)) {
                $s = 1;
                foreach ($scooterO as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ($list['serial_number']); ?></td>
                        <td align="center"><?php echo ($list['battery_life']); ?></td>
                        <td align="center"><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('masters', 'scooterO', 'edit') || $this->user_auth->is_action_allowed('masters', 'scooterO', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('masters', 'scooterO', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>masters/scooterO/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('masters', 'scooterO', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_scooterO" scooterO_id="<?php echo $list['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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
        $(document).on('click','.delete_scooterO',function(){
            _this = $(this);
            id = _this.attr('scooterO_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>masters/scooterO/delete',
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