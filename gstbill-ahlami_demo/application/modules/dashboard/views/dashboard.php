<div class="row">
    <div class="col-md-6">
        <!-- Basic pie chart -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Events Summary by Type</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-container has-scroll">
                    <div class="chart has-fixed-height has-minimum-width" id="basic_pie_new"></div>
                </div>
            </div>
        </div>
        <!-- /bacis pie chart -->
    </div>

    <div class="col-md-6">
        <!-- Basic donut chart -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Events Summary by Type</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-container has-scroll">
                    <div class="chart has-fixed-height has-minimum-width" id="basic_donut_new"></div>
                </div>
            </div>
        </div>
        <!-- /basic donut chart -->
    </div>
</div>
<?php
$event_type_names = array();
if (!empty($event_type_summary)) {
    foreach ($event_type_summary as $list) {
        $event_type_names[] = $list['event_type_name'];
    }
}
$event_type_data = array();
if (!empty($event_type_summary)) {
    foreach ($event_type_summary as $list) {
        $event_type_data[] = '{ value: ' . $list['total'] . ', name: "' . $list['event_type_name'] . '"}';
    }
}
?>
<script type="text/javascript">
    var event_type_names = ["<?php echo implode('","', $event_type_names); ?>"];
    var event_type_data = [<?php echo implode(',', $event_type_data); ?>];

    $(function () {
        require.config({
            paths: {
                echarts: '../themes/event/assets/js/plugins/visualization/echarts'
            }
        });

        require(
                [
                    'echarts',
                    'echarts/theme/limitless',
                    'echarts/chart/pie',
                    'echarts/chart/funnel'
                ],
                function (ec, limitless) {
                    var basic_pie_new = ec.init(document.getElementById('basic_pie_new'), limitless);
                    var basic_donut_new = ec.init(document.getElementById('basic_donut_new'), limitless);

                    basic_pie_new_options = {
                        // Add title
                        title: {
                            text: 'Events Summary',
                            subtext: 'Events by Event Type',
                            x: 'center'
                        },
                        // Add tooltip
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b}: {c} ({d}%)"
                        },
                        // Add legend
                        legend: {
                            orient: 'vertical',
                            x: 'left',
                            data: event_type_names
                        },
                        // Display toolbox
                        toolbox: {
                            show: true,
                            orient: 'vertical',
                            feature: {
                            }
                        },
                        // Enable drag recalculate
                        calculable: true,
                        // Add series
                        series: [{
                                name: 'Event Types',
                                type: 'pie',
                                radius: '70%',
                                center: ['50%', '57.5%'],
                                data: event_type_data
                            }]
                    };

                    basic_donut_new_options = {
                        // Add title
                        title: {
                            text: 'Events Summary',
                            subtext: 'Events by Event Type',
                            x: 'center'
                        },
                        // Add legend
                        legend: {
                            orient: 'vertical',
                            x: 'left',
                            data: event_type_names
                        },
                        // Display toolbox
                        toolbox: {
                            show: true,
                            orient: 'vertical',
                            feature: {
                            }
                        },
                        // Enable drag recalculate
                        calculable: true,
                        // Add series
                        series: [
                            {
                                name: 'Event Types',
                                type: 'pie',
                                radius: ['50%', '70%'],
                                center: ['50%', '57.5%'],
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true
                                        },
                                        labelLine: {
                                            show: true
                                        }
                                    },
                                    emphasis: {
                                        label: {
                                            show: true,
                                            formatter: '{b}' + '\n\n' + '{c} ({d}%)',
                                            position: 'center',
                                            textStyle: {
                                                fontSize: '17',
                                                fontWeight: '500'
                                            }
                                        }
                                    }
                                },
                                data: event_type_data
                            }
                        ]
                    };

                    basic_pie_new.setOption(basic_pie_new_options);
                    basic_donut_new.setOption(basic_donut_new_options);

                    window.onresize = function () {
                        setTimeout(function () {
                            basic_pie_new.resize();
                            basic_donut_new.resize();
                        }, 200);
                    }
                }
        );
    });

</script>