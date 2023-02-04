<?php
$theme_path = $this->config->item('theme_locations') . 'scootero';
$filter = $this->session_view->get_session('dashboard', 'index');
?>
<style type="text/css">
    #panel, #flip {
        padding: 5px;
        text-align: center;
        background-color: #e5eecc;
        border: solid 1px #c3c3c3;
    }
    .event_details {
        display: none;
    }
    .date-cntr tr td:nth-child(5) {
        text-align: center !important;
    }
    .datea-cntr tr td:nth-child(6) {
        text-align: center !important;
    }
</style>
<div class="form-group dash-icons">
    <div class="form-group dash-icons">
        <div class="col-lg-12" style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-lg-6">
                    <button onclick="window.location = '<?php echo base_url('masters/scooterO'); ?>'"class="btn bg-pink-400 btn-block hvr-ripple-out" type="button" >
                        <i class="icon-checkmark-circle"></i> <h3 class ="no-margin"><?php ?><?php echo (!empty($all_scootero)) ? count($all_scootero) : 0; ?><?php ?></h3> <span>Total Scooter</span>
                    </button>
                </div>
                <div class="col-lg-6">
                    <button onclick="window.location = '<?php echo base_url('masters/customers'); ?>'" class="btn bg-teal-400 btn-block hvr-ripple-out" type="button">
                        <i class="icon-clipboard5"></i> <h3 class="no-margin"><?php ?><?php echo (!empty($all_customers)) ? count($all_customers) : 0; ?><?php ?></h3> <span>Total User</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12" id="tdy">
                <div class="panel panel-flat" >
                    <div class="panel-heading">
                        <?php if (count($all_scootero) > 5) { ?>
                            <h5 class="panel-title">Scooter List <a href="masters/scooterO"><span style="float:right; margin-right: 49px;" class="view_more" title="View More"> View More</span></a></h5>
                        <?php } else { ?>
                            <h5 class="panel-title">Scooter List</h5>
                        <?php } ?>
                        </h5>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table  table-bordered table-striped table-hover date-cntr datea-cntr">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Serial Number</th>
                                <th>Battery Life</th>
                                <th>Lock Status</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($all_scootero)) :
                            foreach($all_scootero as $key=>$scoototro) : ?>
                        	<tr>
                            	<td><?php echo $key+1;?></td>
                                <td><?php echo ucfirst($scoototro['serial_number']) ;?></td>
                                <td><?php echo $scoototro['battery_life'];?></td>
                                <td><span class="label label-<?php echo ($scoototro['lock_status'] == 1) ? 'success' : 'primary';?>"><?php echo ($scoototro['lock_status'] == 1) ? 'UnLock' : 'Lock';?></span></td>
                                <td><span class="label label-<?php echo ($scoototro['status'] == 1) ? 'success' : 'danger';?>"><?php echo ($scoototro['status'] == 1) ? 'Active' : 'InActive';?></span></td>
                            </tr>
                            <?php endforeach;?>
                            <?php else: ?>
                            <tr><td colspan="4">No Data Found</td></tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat" >
                    <div class="panel-heading">
                        <?php if (count($all_subscriptions) > 5) { ?>
                            <h5 class="panel-title">Ride Plans <a href="masters/subscriptions"><span style="float:right; margin-right: 49px;" class="view_more"> View More</span></a></h5>
                        <?php } else { ?>
                            <h5 class="panel-title">Ride Plans</h5>
                        <?php } ?>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table  table-bordered table-striped table-hover date-cntr datea-cntr text-center">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Plan Name</th>
                                <th>Mins</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($all_subscriptions)) :
                            foreach($all_subscriptions as $key=>$subscriptions) : ?>
                        	<tr>
                            	<td><?php echo $key+1;?></td>
                                <td><?php echo ucfirst($subscriptions['name']) ;?></td>
                                <td><?php echo $subscriptions['mins']." Mins";?></td>
                                <td><?php echo $subscriptions['amount']." SAR";?></td>
                                <td><span class="label label-<?php echo ($subscriptions['status'] == 1) ? 'success' : 'danger';?>"><?php echo ($subscriptions['status'] == 1) ? 'Active' : 'InActive';?></span></td>
                            </tr>
                            <?php endforeach;?>
                            <?php else: ?>
                            <tr><td colspan="4">No Data Found</td></tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">Events Calendar</h5>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="fullcalendar-event-colors" id="item-id"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$events_arr = array ();
if (!empty($all_events)) {
    foreach ($all_events as $list) {
        $color = $this->user_auth->random_color();
        $app_url = "http://localhost/f2factive/trunk/events/";
        $events_arr[] = '{ title: "' . $list['event_name'] . '", start: "' . $list['formatted_from_date'] . '", end: "' . $list['formatted_to_date'] . '", color: "' . $color . '", url: "' . $app_url . 'events/view/' . $list['id'] . '"}';
    }
}
?>
<script type="text/javascript">
    $(function () {
//        $("#item-id").draggable({disabled: false});


        // Events
        var eventsArr = [<?php echo implode(',', $events_arr); ?>];
        $('.fullcalendar-event-colors').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: new Date(),
            draggable: false,
            editable: false,
            events: eventsArr,
        });
    });


</script>