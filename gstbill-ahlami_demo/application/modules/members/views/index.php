<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/js/plugins/datatable/jquery.dataTables.min.css">
<style type="text/css">
    select[name="memberTable_length"] {
        padding: 7px;
        border: 1px #ddd solid;
        border-radius: 3px;
    }
    .paginate_button { padding: 4px 12px !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        border:1px solid #dddddd;
    }
    th.sorting_disabled { width: 70px !important; }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Members
            <?php if ($this->user_auth->is_action_allowed('members', 'members', 'add')): ?>
                <a href="<?php echo base_url(); ?>members/add" title="Add New"><span class="label bg-success">Add New</span></a>
            <?php endif; ?>
        </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table id="memberTable" class="table table-bordered table-striped table-hover responsive dataTable no-footer dtr-inline">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Family Name</th>
                <th>Relation</th>
                <th>Street</th>
                <th>City</th>
                <th>Approved Status</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('members', 'members', 'edit') || $this->user_auth->is_action_allowed('members', 'members', 'delete')): ?>
                    <th class="text-center">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" style="float:right; margin-right: 15px;" onclick="window.location = '<?php echo base_url('members/upload_members'); ?>'" title="Import Members"><i class="icon-upload4 position-left"></i> Import Members</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('th.sorting_disabled').css('width', '70px');
    });

    function delete_members(id) {
        $.confirm({
            title: 'Delete',
            text: 'Are you sure to Delete?',
            confirm: function (button) {
                $.ajax({
                    url: '<?php echo base_url(); ?>members/members/delete/' + id,
                    method: "POST",
                    data: {id: id},
                    success: function (data) {
                        if (data == 1) {
                            window.location = '<?php echo base_url(); ?>members';
                        }
                    }
                });
            },
            cancel: function (button) {
            },
            confirmButton: 'Yes',
            cancelButton: 'No'
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var table;
        table = $('#memberTable').DataTable({
            'lengthMenu': [[50, 100, 150, -1], [50, 100, 150, 'All']],
            'processing': true, //Feature control the processing indicator.
            'serverSide': true, //Feature control DataTables' server-side processing mode.
            'retrieve': true,
            'order': [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            'ajax': {
                'url': '<?php echo base_url() . 'members/members_ajaxList'; ?>',
                'type': 'POST',
            },
            'columnDefs': [{
                    'targets': 0,
                    'searchable': false
                },
                {
                    orderable: false,
                    targets: [-1]
                }
            ]
        });
    });
</script>
