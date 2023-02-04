<?php
$theme_path = $this->config->item('theme_locations') . 'event';
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
                <div class="col-lg-4">
                    <button onclick="window.location = '<?php echo base_url('members/dashboard/my_events'); ?>'"class="btn bg-pink-400 btn-block hvr-ripple-out" type="button" >
                        <i class="icon-checkmark-circle"></i> <h3 class ="no-margin"><?php echo (!empty($my_events)) ? count($my_events) : 0; ?></h3> <span>My Events</span>
                    </button>
                </div>
                <div class="col-lg-4">
                    <button onclick="window.location = '<?php echo base_url('members/dashboard/today_events'); ?>'"class="btn bg-pink-400 btn-block hvr-ripple-out" type="button" >
                        <i class="icon-checkmark-circle"></i> <h3 class ="no-margin"><?php echo (!empty($today_events)) ? count($today_events) : 0; ?></h3> <span>Today Events</span>
                    </button>
                </div>
                <div class="col-lg-4">
                    <button onclick="window.location = '<?php echo base_url('members/dashboard/upcoming_events'); ?>'" class="btn bg-teal-400 btn-block hvr-ripple-out" type="button">
                        <i class="icon-clipboard5"></i> <h3 class="no-margin"><?php echo (!empty($upcoming_events)) ? count($upcoming_events) : 0; ?></h3> <span>Upcoming Events</span>
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
                        <?php if (count($my_events) > 5) { ?>
                            <h5 class="panel-title">My Events <a href="<?php echo base_url(); ?>members/dashboard/my_events"><span style="float:right; margin-right: 49px;" class="view_more" title="View More"> View More</span></a></h5>
                        <?php } else { ?>
                            <h5 class="panel-title">My Events</h5>
                        <?php } ?>
                        </h5>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered table-striped table-hover date-cntr datea-cntr">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Event Type</th>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($my_events)) {
                                $s = 1;
                                foreach ($my_events as $list) {
                                    ?>
                                    <tr>
                                        <td><?php echo $s; ?></td>
                                        <td><?php echo ucfirst($list['event_type_name']); ?></td>
                                        <td onclick="window.location = '<?php echo base_url(); ?>members/events/view/<?php echo $list['id']; ?>'"><?php echo ucfirst($list['event_name']); ?></td>
                                        <td width="25%"><?php echo (!empty($list['from_date'])) ? date('d-M-Y H:i A', strtotime($list['from_date'])) : ''; ?></td>
                                        <td width="25%"><?php echo (!empty($list['to_date'])) ? date('d-M-Y H:i A', strtotime($list['to_date'])) : ''; ?></td>
                                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                                    </tr>
                                    <?php
                                    $s++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat" >
                    <div class="panel-heading">
                        <?php if (count($today_events) > 5) { ?>
                            <h5 class="panel-title">Upcoming Events <a href="<?php echo base_url(); ?>members/dashboard/today_events"><span style="float:right; margin-right: 49px;" class="view_more"> View More</span></a></h5>
                        <?php } else { ?>
                            <h5 class="panel-title">Today Events</h5>
                        <?php } ?>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered table-striped table-hover date-cntr datea-cntr">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Event Type</th>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
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
                                        <td onclick="window.location = '<?php echo base_url(); ?>members/events/view/<?php echo $list['id']; ?>'"><?php echo ucfirst($list['event_name']); ?></td>
                                        <td width="25%"><?php echo (!empty($list['from_date'])) ? date('d-M-Y H:i A', strtotime($list['from_date'])) : ''; ?></td>
                                        <td width="25%"><?php echo (!empty($list['to_date'])) ? date('d-M-Y H:i A', strtotime($list['to_date'])) : ''; ?></td>
                                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                                    </tr>
                                    <?php
                                    $s++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-flat" >
                    <div class="panel-heading">
                        <?php if (count($upcoming_events) > 5) { ?>
                            <h5 class="panel-title">Upcoming Events <a href="<?php echo base_url(); ?>members/dashboard/upcoming_events"><span style="float:right; margin-right: 49px;" class="view_more"> View More</span></a></h5>
                        <?php } else { ?>
                            <h5 class="panel-title">Upcoming Events</h5>
                        <?php } ?>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered table-striped table-hover date-cntr datea-cntr">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Event Type</th>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($upcoming_events)) {
                                $s = 1;
                                foreach ($upcoming_events as $list) {
                                    ?>
                                    <tr>
                                        <td><?php echo $s; ?></td>
                                        <td><?php echo ucfirst($list['event_type_name']); ?></td>
                                        <td onclick="window.location = '<?php echo base_url(); ?>members/events/view/<?php echo $list['id']; ?>'"><?php echo ucfirst($list['event_name']); ?></td>
                                        <td width="25%"><?php echo (!empty($list['from_date'])) ? date('d-M-Y H:i A', strtotime($list['from_date'])) : ''; ?></td>
                                        <td width="25%"><?php echo (!empty($list['to_date'])) ? date('d-M-Y H:i A', strtotime($list['to_date'])) : ''; ?></td>
                                        <td><span class="label label-<?php echo ($list['status'] == 1) ? 'success' : 'default'; ?>"><?php echo ($list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                                    </tr>
                                    <?php
                                    $s++;
                                }
                            }
                            ?>
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
                        <div class="fullcalendar-event-colors"></div>
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
        $app_url = "http://demo.f2fsolutions.co.in/events_v2/";
        $events_arr[] = '{ title: "' . $list['event_name'] . '", start: "' . $list['formatted_from_date'] . '", end: "' . $list['formatted_to_date'] . '", color: "' . $color . '", url: "' . $app_url . 'members/events/view/' . $list['id'] . '"}';
    }
}
?>
<script type="text/javascript">
    $(function () {
        // Events
        var eventsArr = [<?php echo implode(',', $events_arr); ?>];
        $('.fullcalendar-event-colors').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: new Date(),
            editable: false,
            events: eventsArr
        });
    });
</script>