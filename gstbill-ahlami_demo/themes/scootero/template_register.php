<?php
$theme_path = $this->config->item('theme_locations') . 'scootero';
$is_logo_allowed = $this->config->item('is_logo_allowed');
$is_favicon_allowed = $this->config->item('is_favicon_allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->config->item('site_title'); ?></title>
        <?php if ($is_favicon_allowed): ?>
            <link rel="icon" type="image/png" href="<?php echo $theme_path ?>/assets/images/favicon.png" />
        <?php endif; ?>

        <!-- Global stylesheets -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/icons/icomoon/styles.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/core.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/colors.css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/app.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/login.js"></script>
        <!-- /theme JS files -->

        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/node_modules/material-datetimepicker/bootstrap-material-datetimepicker.css">
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/pnotify.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/jgrowl.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/anytime.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/legacy.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/pnotify.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/widgets.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/effects.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/app.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/form_multiselect.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/components_modals.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/form_checkboxes_radios.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/form_inputs.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/pages/picker_date.js"></script>
    </head>
    <body class="login-container">
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $theme_path; ?>/assets/images/logo1.png" alt=""></a>
                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav navbar-right"></ul>
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <?php echo $content; ?>
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>