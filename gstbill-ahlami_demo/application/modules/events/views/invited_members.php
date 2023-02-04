<?php $theme_path = $this->config->item('theme_locations') . 'event'; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Event Invited Members
            <a href="javascript:void(0);"><span class="label bg-success"><?php echo $event[0]['event_name']; ?></span></a>
        </h5>
        <div class="heading-elements"></div>
    </div>
    <table class="table datatable-basic table-bordered table-striped table-hover status-cntrb">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Mobile Number</th>
                <th>Family Name</th>
                <th>Street Name</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (!empty($invited_members)) {
                $s = 1;
                foreach ($invited_members as $list) {
                    ?>
                    <tr class="delete<?php echo $list['id']; ?>">
                        <td><?php echo $s; ?></td>
                        <td><?php echo ucfirst($list['firstname']) . ' ' . ucfirst($list['lastname']); ?></td>
                        <td><?php echo ucfirst($list['email_address']); ?></td>
                        <td><?php echo ucfirst($list['mobile_number']); ?></td>
                        <td><?php echo ucfirst($list['group_name']); ?></td>
                        <td><?php echo ucfirst($list['street_name']); ?></td>
                    </tr>
                    <?php
                    $s++;
                }
            }
            ?>
        </tbody>
    </table>

</div>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-danger" title="Back" onclick="window.location = '<?php echo base_url('events'); ?>'" style="float:left;"><i class="icon-arrow-left13 position-left"></i> Back</button>
    </div>
</div>