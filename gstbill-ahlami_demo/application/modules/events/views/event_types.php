<style type="text/css">
    .status-cntr tr td:nth-child(3) {
        text-align: center !important;
    }
</style>
<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Event Types
            <?php if ($this->user_auth->is_action_allowed('events', 'event_types', 'add')): ?>
                <a href="<?php echo base_url(); ?>events/event_types/add"><span class="label bg-success">Add New</span></a>
            <?php endif; ?>
        </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table class="table datatable-basic table-bordered table-striped table-hover status-cntr">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Event Type Name</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('events', 'event_types', 'edit') || $this->user_auth->is_action_allowed('events', 'event_types', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($event_types)) {
                $s = 1;
                foreach ($event_types as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ucfirst($list['event_type_name']); ?></td>
                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                        <?php if ($this->user_auth->is_action_allowed('events', 'event_types', 'edit') || $this->user_auth->is_action_allowed('events', 'event_types', 'delete')): ?>
                            <td class="text-center">
                                <?php if ($this->user_auth->is_action_allowed('events', 'event_types', 'edit')): ?>
                                    <a href="<?php echo base_url(); ?>events/event_types/edit/<?php echo $list['id']; ?>" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
                                <?php endif; ?>
                                <?php if ($this->user_auth->is_action_allowed('events', 'event_types', 'delete')): ?>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-xs delete_event_type" event_type_id="<?php echo $list['id']; ?>" data-original-title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

        $('.delete_event_type').click(function () {
            id = $(this).attr('event_type_id');
            $.confirm({
                title: 'Delete',
                text: 'Are you sure to Delete?',
                confirm: function (button) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>events/event_types/delete',
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            if (data == '1') {
                                window.location = '<?php echo base_url(); ?>events/event_types';
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