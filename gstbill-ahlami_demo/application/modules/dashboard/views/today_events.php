<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<style type="text/css">
    .ui-dialog { z-index: 999; }
    .cente tr td:nth-child(8) {
        text-align:center;
    }
    .cente1 tr td:nth-child(9){
        text-align:center;
    }
    .cente2 tr td:nth-child(10){
        text-align:center;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Today Events</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
            </ul>
        </div>
    </div>
    <table class="table datatable-basic table-bordered table-striped table-hover status-cntrb cente cente1 cente2">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Event Type</th>
                <th>Event Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Invited</th>
                <th>Accepted</th>
                <th>Rejected</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($today_events)) {
                $s = 1;
                foreach ($today_events as $list) {
                    ?>
                    <tr>
                        <td><?php echo $s; ?></td>
                        <td><?php echo ucfirst($list['event_type_name']); ?></td>
                        <td><?php echo ucfirst($list['event_name']); ?></td>
                        <td width="10%"><?php echo (!empty($list['from_date'])) ? date('d-M-Y', strtotime($list['from_date'])) : ''; ?></td>
                        <td width="10%"><?php echo (!empty($list['to_date'])) ? date('d-M-Y', strtotime($list['to_date'])) : ''; ?></td>
                        <td style="width:10%"><a class="btn btn-success btn-xs" onclick="window.location = '<?php echo base_url(); ?>events/events/accept_members/<?php echo $list['id']; ?>'"><?php echo (!empty($list['accept_count'])) ? $list['accept_count'] : 0; ?></a></td>
                        <td><a class="btn btn-danger btn-xs" onclick="window.location = '<?php echo base_url(); ?>events/events/reject_members/<?php echo $list['id']; ?>'"> <?php echo (!empty($list['reject_count'])) ? $list['reject_count'] : 0; ?></a></td>
                        <td><a class="btn btn-primary btn-xs" onclick="window.location = '<?php echo base_url(); ?>events/events/invited_members/<?php echo $list['id']; ?>'"><?php echo (!empty($list['invited_count'])) ? $list['invited_count'] : 0; ?></a></td>
                        <td ><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                    </tr>
                    <?php
                    $s++;
                }
            }
            ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-danger" onclick="window.location = '<?php echo base_url('dashboard'); ?>'" style="margin-bottom: 18px; margin-left: 10px;"><i class="icon-arrow-left13 position-left"></i> Cancel</button>
        </div>
    </div>
</div>