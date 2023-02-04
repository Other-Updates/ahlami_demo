<?php
$theme_path = $this->config->item('theme_locations') . 'scootero';
$is_logo_allowed = $this->config->item('is_logo_allowed');
$is_favicon_allowed = $this->config->item('is_favicon_allowed');
$is_user_module_allowed = $this->config->item('user_modules');
$is_user_section_allowed = $this->config->item('user_sections');
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
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo $theme_path; ?>/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $theme_path; ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $theme_path; ?>/assets/css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $theme_path; ?>/assets/css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $theme_path; ?>/assets/css/colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/blockui.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/bootstrap-confirmation.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/jquery.confirm.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/pnotify.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/jgrowl.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
        <!-- Full Calendar -->
        <?php if (in_array($this->router->class, array ('dashboard'))): ?>
            <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/anytime.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/pickers/pickadate/legacy.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/notifications/pnotify.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <!-- E Charts -->
        <?php if (in_array($this->router->class, array ('dashboard'))): ?>
            <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/visualization/echarts/echarts.js"></script>
        <?php endif; ?>

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

        <!-- E Charts -->
        <!--<script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/charts/echarts/pies_donuts.js"></script>-->

        <script type="text/javascript">
            var base_url = '<?php echo $this->config->item('base_url'); ?>';
            var ct_class = '<?php echo $this->router->class; ?>';
            var ct_method = '<?php echo $this->router->method; ?>';
        </script>
        <!-- /theme JS files -->
    </head>
    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                    <img src="<?php echo $theme_path; ?>/assets/images/logo1.png" alt="" style="width:18%;">
                </a>
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3 ml--75"></i></a></li>
                </ul>
                <?php
                $file_name = $this->user_auth->get_profile_image();
                $prefix = pathinfo($file_name, PATHINFO_FILENAME);
                $suffix = pathinfo($file_name, PATHINFO_EXTENSION);
                $thumb_name = $prefix . '_thumb' . '.' . $suffix;
                $exists = base_url() . 'attachments/member_image/' . $prefix . '.' . $suffix;
                $profile_image = (!empty($thumb_name) && $exists) ? $thumb_name : 'default_profile_image.png';
                ?>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $exists; ?>" alt="">
                                <span><?php echo ucfirst($this->user_auth->get_username()); ?></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="<?php echo base_url() . 'members/user/member_profile'; ?>"><i class="icon-user-plus"></i> My profile</a></li>
                                <li><a href="<?php echo base_url() . 'users/logout'; ?>"><i class="icon-switch2"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /main navbar -->
        <!-- Page container -->

        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">
                        <!-- User menu -->
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">
                                    <a href="javascript:void(0);" class="media-left"><img src="<?php echo $exists; ?>" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">
                                        <?php
                                        $user_location = $this->user_auth->get_user_location();
                                        $username = $this->user_auth->get_username();
                                        $username = (strlen($username) > 13) ? substr($username, 0, 13) . '...' : $username;
                                        ?>
                                        <span class="media-heading text-semibold"><?php echo ucfirst($username); ?></span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-pin text-size-small"></i> &nbsp;<span class="user_location"><?php echo $user_location; ?></span>
                                        </div>
                                    </div>
                                    <div class="media-right media-middle">
                                        <ul class="icons-list">
                                            <li><a href="<?php echo base_url() . 'users/users/logout'; ?>"><i class="icon-switch2"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /user menu -->

                        <?php
                        # Initialize
                        $breadcrumb_title_1 = $breadcrumb_title_2 = $title = '';
                        $dashboard = $home = $analytics = '';
                        $members = $manage_members = '';
                        $events = $manage_events = $manage_event_types = '';

                        # Dashboard - Home
                        if (($this->uri->uri_string() == 'events/dashboard') || ($this->uri->uri_string() == 'events/dashboard/index') || ($this->router->class == 'dashboard' && $this->router->method == 'index')) {
                            $dashboard = $home = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Dashboard';
                            $breadcrumb_title_2 = '';
                        }

                        # Dashboard - My Events
                        if (($this->uri->uri_string() == 'events/dashboard/my_events') || ($this->router->class == 'dashboard' && $this->router->method == 'my_events')) {
                            $dashboard = $home = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Dashboard';
                            $breadcrumb_title_2 = 'My Events';
                        }

                        # Dashboard - Today Events
                        if (($this->uri->uri_string() == 'events/dashboard/today_events') || ($this->router->class == 'dashboard' && $this->router->method == 'today_events')) {
                            $dashboard = $home = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Dashboard';
                            $breadcrumb_title_2 = 'Today Events';
                        }

                        # Dashboard - Upcoming Events
                        if (($this->uri->uri_string() == 'events/dashboard/upcoming_events') || ($this->router->class == 'dashboard' && $this->router->method == 'upcoming_events')) {
                            $dashboard = $home = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Dashboard';
                            $breadcrumb_title_2 = 'Upcoming Events';
                        }

                        # Dashboard - Analytics
                        if (($this->uri->uri_string() == 'events/dashboard/analytics') || ($this->router->class == 'dashboard' && $this->router->method == 'analytics')) {
                            $dashboard = $analytics = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Analytics';
                            $breadcrumb_title_2 = '';
                        }

                        # My Profile
                        if (($this->uri->uri_string() == 'members/user/member_profile') || ($this->router->class == 'user' && $this->router->method == 'member_profile')) {
                            $users = $manage_users = 'active';
                            $title = 'Memebers - My Profile';
                            $breadcrumb_title_1 = 'Members';
                            $breadcrumb_title_2 = 'My Profile';
                        }

                        # Members
                        if (($this->uri->uri_string() == 'members/user') || ($this->uri->uri_string() == 'members/user/add') || ($this->router->class == 'user' && $this->router->method == 'edit') || ($this->router->class == 'members' && $this->router->method == 'view') || ($this->router->class == 'members/member_index' && $this->router->method == 'view')) {
                            $members = $manage_members = 'active';
                            $title = 'Members - Manage Members';
                            $breadcrumb_title_1 = 'Members';
                            $breadcrumb_title_2 = 'Manage Members';
                        }


                        # Upload Members
                        if (($this->uri->uri_string() == 'members/upload_members') || ($this->uri->uri_string() == 'members/upload_members/index')) {

                            $members = $manage_members = 'active';
                            $title = 'Members - Import Members';
                            $breadcrumb_title_1 = 'Members';
                            $breadcrumb_title_2 = 'Import Members';
                        }

                        # Events
                        if (($this->uri->uri_string() == 'members/events') || ($this->uri->uri_string() == 'members/events/index') || ($this->uri->uri_string() == 'members/events/add') || ($this->router->class == 'events' && $this->router->method == 'edit') || ($this->router->class == 'events' && $this->router->method == 'view')) {
                            $events = $manage_events = 'active';
                            $title = 'Events - Manage Events';
                            $breadcrumb_title_1 = 'Events';
                            $breadcrumb_title_2 = 'Manage Events';
                        }

                        # Events - Invited Members
                        if (($this->router->class == 'events' && $this->router->method == 'invited_members')) {
                            $events = $manage_events = 'active';
                            $title = 'Events - Event Invited Members';
                            $breadcrumb_title_1 = 'Events';
                            $breadcrumb_title_2 = 'Event Invited Members';
                        }

                        # Events - Accepted Members
                        if (($this->router->class == 'events' && $this->router->method == 'accept_members')) {
                            $events = $manage_events = 'active';
                            $title = 'Events - Event Accepted Members';
                            $breadcrumb_title_1 = 'Events';
                            $breadcrumb_title_2 = 'Event Accepted Members';
                        }

                        # Events - Rejected Members
                        if (($this->router->class == 'events' && $this->router->method == 'reject_members')) {
                            $events = $manage_events = 'active';
                            $title = 'Events - Event Rejected Members';
                            $breadcrumb_title_1 = 'Events';
                            $breadcrumb_title_2 = 'Event Rejected Members';
                        }

                        # Event Types
                        if (($this->uri->uri_string() == 'members/event_types') || ($this->uri->uri_string() == 'members/event_types/index') || ($this->uri->uri_string() == 'members/event_types/add') || ($this->router->class == 'event_types' && $this->router->method == 'edit')) {
                            $events = $manage_event_types = 'active';
                            $title = 'Event Types - Manage Event Types';
                            $breadcrumb_title_1 = 'Event Types';
                            $breadcrumb_title_2 = 'Manage Event Types';
                        }
                        ?>
                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <ul class="navigation navigation-main navigation-accordion">
                                    <!-- Main -->
                                    <!--<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>-->
                                    <?php if ($this->user_auth->is_module_allowed('dashboard')): ?>
                                        <li class="<?php echo $dashboard; ?>">
                                            <a href="javascript:void(0);"><i class="icon-home2"></i> <span>Dashboard</span></a>
                                            <ul>
                                                <li class="<?php echo $home; ?>"><a href="<?php echo base_url() . 'members/dashboard'; ?>"><i class="icon-chevron-right"></i>Home</a></li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->user_auth->is_module_allowed('members')): ?>
                                        <li class="<?php echo $members; ?>">
                                            <a href="javascript:void(0);"><i class="icon-collaboration"></i> <span>Members</span></a>
                                            <ul>
                                                <?php
                                                if ($this->user_auth->is_section_allowed('members', 'members')):
                                                    ?>
                                                    <li class="<?php echo $manage_members; ?>"><a href="<?php echo base_url() . 'members/user'; ?>"><i class="icon-chevron-right"></i>Manage Members</a></li>
                                                <?php endif; ?>

                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->user_auth->is_module_allowed('events')): ?>
                                        <li class="<?php echo $events; ?>">
                                            <a href="javascript:void(0);"><i class="icon-clipboard2"></i> <span>Events</span></a>
                                            <ul>
                                                <?php if ($this->user_auth->is_section_allowed('events', 'events')): ?>
                                                    <li class="<?php echo $manage_events; ?>"><a href="<?php echo base_url() . 'members/events'; ?>"><i class="icon-chevron-right"></i>Manage Events</a></li>
                                                <?php endif; ?>
                                            </ul>
                                            <ul>
                                                <?php if ($this->user_auth->is_section_allowed('events', 'event_types')): ?>
                                                                                                                                                            <!--<li class="<?php echo $manage_event_types; ?>"><a href="<?php // echo base_url() . 'members/event_types';                           ?>"><i class="icon-chevron-right"></i>Manage Event Types</a></li>-->
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                    <!-- /main -->
                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->
                    </div>
                </div>
                <!-- /main sidebar -->

                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Page header -->
                    <div class="page-header page-header-default">
                        <!--<div class="page-header-content">
                            <div class="page-title">
                                <h4><span class="text-semibold"><?php echo $title; ?></span></h4>
                            </div>
                        </div>-->

                        <?php
                        $active_class_1 = ($breadcrumb_title_2 == '') ? 'active' : '';
                        $active_class_2 = ($breadcrumb_title_2 != '') ? 'active' : '';
                        ?>
                        <div class="breadcrumb-line">
                            <ul class="breadcrumb">
                                <li><a href="<?php echo base_url(); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
                                <li class="<?php echo $active_class_1; ?>"><?php echo $breadcrumb_title_1; ?></li>
                                <?php if ($breadcrumb_title_2 != ''): ?>
                                    <li class="<?php echo $active_class_2; ?>"><?php echo $breadcrumb_title_2; ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /page header -->

                    <!-- Content area -->
                    <div class="content">
                        <div class="session_msg">
                            <?php echo $session_msg; ?>
                        </div>
                        <?php echo $content; ?>

                        <!-- Footer -->
                        <div class="footer text-muted">
                            <span style="float:left;"><?php echo $this->config->item('site_footer') ?></span>&nbsp;
                            <span style="float:right;">Powered by <a href="http://www.f2fsolutions.co.in" target="_blank" class="powered_link">F2F Solutions</a></span>
                        </div>
                        <!-- /footer -->
                    </div>
                    <!-- /content area -->
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
        <div id="ajax-loader" style="display:none;"></div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').submit(function () {
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('button[type="submit"]').html('Please wait Processing');
        });
        if ((ct_class == 'service_entry' || ct_class == 'for_service' || ct_class == 'for_dispatch') && (ct_method == 'index'))
            $('th.sorting_disabled').css('width', '160px');
        else if ((ct_class == 'technician') && (ct_method == 'index'))
            $('th.sorting_disabled').css('width', '100px');
        else
            $('th.sorting_disabled').css('width', '135px');
        $('input[type="text"]').attr('autocomplete', 'off');
    });
    function session_message() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'api/load_session_message'; ?>',
            success: function (session_msg) {
                $('.session_msg').html(session_msg);
            }
        });
    }
</script>
<style type="text/css">
    #ajax-loader {
        position:fixed;
        top:0px;
        right:0px;
        width:100%;
        height:100%;
        background-color:#1b1515;
        background-size: 7%;
        background-image:url('../themes/event/assets/images/ajax-loader/loading.gif');
        background-repeat:no-repeat;
        background-position:center;
        z-index:10000000;
        opacity: 0.7;
        filter: alpha(opacity=40);
    }
</style>