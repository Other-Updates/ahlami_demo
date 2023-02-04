<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/js/plugins/datatable/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>
<style type="text/css">
    .sorting_disabled  {
        padding-right: 65px !important;
    }
    .ui-dialog { z-index: 999; }
    .acccent tr td:nth-child(6) {
        text-align:center;
    }
    .invcent tr td:nth-child(7) {
        text-align:center;
    }
    .cente tr td:nth-child(8) {
        text-align:center;
    }
    .cente1 tr td:nth-child(9) {
        text-align:center;
    }
    .cente2 tr td:nth-child(10) {
        text-align:center;
    }
    select[name="eventTable_length"] {
        padding: 7px;
        border: 1px #ddd solid;
        border-radius: 3px;
    }
    .paginate_button { padding: 4px 12px !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        border:1px solid #dddddd;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Manage Events
            <?php if ($this->user_auth->is_action_allowed('events', 'events', 'add')): ?>
                <a href="<?php echo base_url(); ?>members/events/add"><span class="label bg-success">Add New</span></a>
            <?php endif; ?>
        </h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table id="eventTable" class="table table-bordered table-striped table-hover responsive dataTable no-footer dtr-inline status-cntrb cente cente1 acccent invcent cente2" width="100%">
        <thead>
            <tr>
                <th >S.No</th>
                <th >Event&nbsp; Type</th>
                <th>Event&nbsp;Name</th>
                <!--<th>Family Name</th>
                <th>Street Name</th>-->
                <th >Start&nbsp;Date</th>
                <th>End&nbsp;Date</th>
                <th>Invited</th>
                <th>Accepted</th>
                <th>Rejected</th>
                <th>Approved Status</th>
                <th>Status</th>
                <?php if ($this->user_auth->is_action_allowed('events', 'events', 'edit') || $this->user_auth->is_action_allowed('events', 'events', 'delete')): ?>
                    <th class="sorting_disabled">Actions</th>
                    <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('th.sorting_disabled').css('width', '135px');

        var table = $('#eventTable').DataTable({
            'lengthMenu': [[50, 100, 150, -1], [50, 100, 150, 'All']],
            'processing': true, //Feature control the processing indicator.
            'serverSide': true, //Feature control DataTables' server-side processing mode.
            'retrieve': true,
            'order': [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            'ajax': {
                'url': '<?php echo base_url() . 'members/events/events_ajaxList'; ?>',
                'type': 'POST',
            },
            'columnDefs': [{
                    'targets': 0,
                    'searchable': false
                },
                {
                    orderable: false,
                    targets: [-1, -2, -3, -4, -5]
                }
            ],
            createdRow: function (row, data, index) {
                $('td', row).eq(11).addClass('action_style'); // 6 is index of column
            }
        });
    });

    $('body').on('click', '.delete_event', function () {
        id = $(this).attr('event_id');
        $.confirm({
            title: 'Delete',
            text: 'Are you sure to Delete?',
            confirm: function (button) {
                $.ajax({
                    url: '<?php echo base_url(); ?>members/events/delete/' + id,
                    method: 'POST',
                    data: {id: id},
                    success: function (data) {
                        if (data == 1) {
                            window.location = '<?php echo base_url(); ?>members/events';
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
    $(document).ready(function () {
        $('#eventTable').DataTable();
    });
</script>