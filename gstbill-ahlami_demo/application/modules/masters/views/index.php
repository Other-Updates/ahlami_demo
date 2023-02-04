<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Streets
            <?php if ($this->user_auth->is_action_allowed('masters', 'streets', 'add')): ?>
                <a href="<?php echo base_url(); ?>masters/streets/add/" title="Add New"><span class="label bg-success">Add New</span></a>
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
                <th>Street Name</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('masters', 'streets', 'edit') || $this->user_auth->is_action_allowed('masters', 'streets', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($streets)) {
                $i = 1;
                foreach ($streets as $street) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo ($street['city'] == 1) ? 'Kayalpattinam' : 'Others' ?></td>
                        <td><?php echo ucfirst($street['street_name']); ?></td>
                        <td><span class="label label-<?php echo ($street['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($street['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('masters', 'streets', 'edit') || $this->user_auth->is_action_allowed('masters', 'streets', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('masters', 'streets', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>masters/streets/edit/<?php echo $street['id']; ?>" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('masters', 'streets', 'delete')): ?>
                                    <a href="javascript:void(0);"  class="btn btn-danger btn-xs delete_street" street_id="<?php echo $street['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

        $('.delete_street').click(function () {

            id = $(this).attr('street_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>masters/streets/delete',
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            if (data == '1') {
                                window.location = '<?php echo base_url(); ?>masters/streets';
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
