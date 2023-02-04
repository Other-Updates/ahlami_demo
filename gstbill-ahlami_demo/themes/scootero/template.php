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
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/core.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/widgets.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery_ui/effects.min.js"></script>
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
                    <?php if ($is_logo_allowed): ?>
                        <img src="<?php echo $theme_path; ?>/assets/images/logo1.png" alt="" >
                    <?php endif; ?>
                    <?php if (!$is_logo_allowed): ?>
                        <img src="<?php echo $theme_path; ?>/assets/images/logo1.png" alt="" >
                    <?php endif; ?>
                </a>
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>
            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>


                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php
                        $image_name = !empty($member[0]['profile_image']) ? pathinfo($member[0]['profile_image'], PATHINFO_FILENAME) : '';
                        $image_ext = !empty($member[0]['profile_image']) ? pathinfo($member[0]['profile_image'], PATHINFO_EXTENSION) : '';
                        $exists = file_exists(FCPATH . 'attachments/member_image/' . $image_name . '.' . $image_ext);
                        if (!empty($member[0]['profile_image']) && $exists) {
                            $image_path = base_url() . 'attachments/member_image/' . $image_name . '.' . $image_ext;
                        } else {
                            $image_path = base_url() . 'themes/event/assets/images/default_image.png';
                        }
                        ?>
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo base_url() . 'attachments/profile_image/thumb/' . $profile_image; ?>" alt="">
                                <span><?php echo ucfirst($this->user_auth->get_username()); ?></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="<?php echo base_url() . 'users/my_profile'; ?>"><i class="icon-user-plus"></i> My profile</a></li>
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
                                    <?php
                                    $file_name = $this->user_auth->get_profile_image();
                                    $prefix = pathinfo($file_name, PATHINFO_FILENAME);
                                    $suffix = pathinfo($file_name, PATHINFO_EXTENSION);
                                    $thumb_name = $prefix . '_thumb' . '.' . $suffix;
                                    $exists = base_url() . 'attachments/profile_image/' . $prefix . '.' . $suffix;
                                    $profile_image = (!empty($thumb_name) && $exists) ? $thumb_name : 'default_profile_image.png';
                                    ?>
                                    <a href="javascript:void(0);" class="media-left"><img src="<?php echo $exists; ?>" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">
                                        <?php
                                        $user_location = $this->user_auth->get_user_location();
                                        $username = $this->user_auth->get_username();
                                        $user_type_id = $this->user_auth->get_user_type_id();

                                        $username = (strlen($username) > 13) ? substr($username, 0, 13) . '...' : $username;
                                        ?>
                                        <span class="media-heading text-semibold"><?php echo ucfirst($username); ?></span>
                                        <div class="text-size-mini text-muted">
                                            <i class="icon-pin text-size-small"></i> &nbsp;<span class="user_location"><?php echo $user_location; ?></span>
                                        </div>
                                    </div>
                                    <div class="media-right media-middle">
                                        <ul class="icons-list">
                                            <li><a href="<?php echo base_url() . 'users/logout'; ?>"><i class="icon-switch2"></i></a></li>
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
                        $masters = $manage_streets = $general_setting = '';
                        $users = $manage_users = $manage_user_types = $manage_user_modules = $manage_user_sections = '';
                        $members = $manage_members = $manage_groups = '';
                        $events = $manage_events = $manage_event_types = '';
                        $site_cms = $manage_contacts = $manage_pricing_and_plans = '';
                        $reports = $invoice_report = $customer_feedback_report = $transaction_report = $wallet_report = '' ;
                        # Dashboard - Home
                        if (($this->uri->uri_string() == 'dashboard') || ($this->uri->uri_string() == 'dashboard/index') || ($this->uri->uri_string() == '') || ($this->uri->uri_string() == 'dashboard/upcoming_events') || ($this->uri->uri_string() == 'dashboard/today_events')) {
                            $dashboard = $home = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Dashboard';
                            $breadcrumb_title_2 = '';
                        }

                        # Dashboard - Analytics
                        if (($this->uri->uri_string() == 'dashboard/analytics') || ($this->router->class == 'dashboard' && $this->router->method == 'analytics')) {
                            $dashboard = $analytics = 'active';
                            $title = 'Dashboard';
                            $breadcrumb_title_1 = 'Analytics';
                            $breadcrumb_title_2 = '';
                        }
                        # Masters - General Setting
                        if (($this->uri->uri_string() == 'masters/setting') || ($this->uri->uri_string() == 'masters/setting/index') || ($this->uri->uri_string() == 'masters/setting/add') || ($this->router->class == 'setting' && $this->router->method == 'edit')) {
                            $masters = $general_setting = 'active';
                            $title = 'Masters - General Setting';
                            $breadcrumb_title_1 = 'Masters';
                            $breadcrumb_title_2 = 'General Setting';
                        }
                        # Masters - ScooterO
                        if (($this->uri->uri_string() == 'masters/scooterO') || ($this->uri->uri_string() == 'masters/scooterO/index') || ($this->uri->uri_string() == 'masters/scooterO/add') || ($this->router->class == 'scooterO' && $this->router->method == 'edit')) {
                            $masters = $scooterO = 'active';
                            $title = 'Masters - ScooterO';
                            $breadcrumb_title_1 = 'Masters';
                            $breadcrumb_title_2 = 'ScooterO';
                        }
                        # Masters - Subscriptions
                        if (($this->uri->uri_string() == 'masters/subscriptions') || ($this->uri->uri_string() == 'masters/subscriptions/index') || ($this->uri->uri_string() == 'masters/subscriptions/add') || ($this->router->class == 'subscriptions' && $this->router->method == 'edit')) {
                            $masters = $subscriptions = 'active';
                            $title = 'Masters - Subscriptions';
                            $breadcrumb_title_1 = 'Masters';
                            $breadcrumb_title_2 = 'Subscriptions';
                        }
                        # Masters - Customers
                        if (($this->uri->uri_string() == 'masters/customers') || ($this->uri->uri_string() == 'masters/customers/index') || ($this->uri->uri_string() == 'masters/customers/add') || ($this->router->class == 'customers' && $this->router->method == 'edit')) {
                            $masters = $customers = 'active';
                            $title = 'Masters - Customers';
                            $breadcrumb_title_1 = 'Masters';
                            $breadcrumb_title_2 = 'Customers';
                        }
                        # Users
                        if (($this->uri->uri_string() == 'users') || ($this->uri->uri_string() == 'users/index') || ($this->uri->uri_string() == 'users/add') || ($this->router->class == 'users' && $this->router->method == 'edit')) {
                            $users = $manage_users = 'active';
                            $title = 'Users - Manage Users';
                            $breadcrumb_title_1 = 'Users';
                            $breadcrumb_title_2 = 'Manage Users';
                        }

                        # My Profile
                        if (($this->uri->uri_string() == 'users/my_profile') || ($this->router->class == 'users' && $this->router->method == 'my_profile')) {
                            $users = $manage_users = 'active';
                            $title = 'Users - My Profile';
                            $breadcrumb_title_1 = 'Users';
                            $breadcrumb_title_2 = 'My Profile';
                        }

                        # User Types
                        if (($this->uri->uri_string() == 'users/user_types') || ($this->uri->uri_string() == 'users/user_types/index') || ($this->uri->uri_string() == 'users/user_types/add') || ($this->router->class == 'user_types' && $this->router->method == 'edit') || ($this->router->class == 'user_types' && $this->router->method == 'view')) {
                            $users = $manage_user_types = 'active';
                            $title = 'Users - Manage User Types';
                            $breadcrumb_title_1 = 'Users';
                            $breadcrumb_title_2 = 'Manage User Types';
                        }

                        # User Modules
                        if (($this->uri->uri_string() == 'users/user_modules') || ($this->uri->uri_string() == 'users/user_modules/index') || ($this->uri->uri_string() == 'users/user_modules/add') || ($this->router->class == 'user_modules' && $this->router->method == 'edit')) {
                            $users = $manage_user_modules = 'active';
                            $title = 'Users - Manage User Modules';
                            $breadcrumb_title_1 = 'Users';
                            $breadcrumb_title_2 = 'Manage User Modules';
                        }

                        # User Sections
                        if (($this->uri->uri_string() == 'users/user_sections') || ($this->uri->uri_string() == 'users/user_sections/index') || ($this->uri->uri_string() == 'users/user_sections/add') || ($this->router->class == 'user_sections' && $this->router->method == 'edit')) {
                            $users = $manage_user_sections = 'active';
                            $title = 'Users - Manage User Sections';
                            $breadcrumb_title_1 = 'Users';
                            $breadcrumb_title_2 = 'Manage User Sections';
                        }
                        
                         # Reports - Invoice Report
                         if (($this->uri->uri_string() == 'report/invoice_report')) {
                            $reports = $invoice_report = 'active';
                            $title = 'Reports - Invoice Report';
                            $breadcrumb_title_1 = 'Reports';
                            $breadcrumb_title_2 = 'Invoice Report';
                        }
                        # Reports - Customer Feedback Report
                        if (($this->uri->uri_string() == 'report/customer_feedback_report')) {
                            $reports = $customer_feedback_report = 'active';
                            $title = 'Reports - Customer Feedback Report';
                            $breadcrumb_title_1 = 'Reports';
                            $breadcrumb_title_2 = 'Customer Feedback Report';
                        }
                        # Reports - Transaction Report
                        if (($this->uri->uri_string() == 'report/transaction_report')) {
                            $reports = $transaction_report = 'active';
                            $title = 'Reports - Transaction Report';
                            $breadcrumb_title_1 = 'Reports';
                            $breadcrumb_title_2 = 'Transaction Report';
                        }
                         # Reports - Wallet Report
                         if (($this->uri->uri_string() == 'report/wallet_report')) {
                            $reports = $wallet_report = 'active';
                            $title = 'Reports - Wallet Report';
                            $breadcrumb_title_1 = 'Reports';
                            $breadcrumb_title_2 = 'Wallet Report';
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
                                            <a href="<?php echo base_url(); ?>"><i class="<?php echo $home; ?> icon-home2"></i> <span>Dashboard</span></a>
                                            <!--<ul>
                                                <li class="<?php echo $home; ?>"><a href="<?php echo base_url(); ?>"><i class="icon-chevron-right"></i>Home</a></li>
                                                <li class="<?php echo $analytics; ?>"><a href="<?php echo base_url() . 'dashboard/analytics'; ?>"><i class="icon-chevron-right"></i>Analytics</a></li>
                                            </ul>-->
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->user_auth->is_module_allowed('masters')): ?>
                                        <li class="<?php echo $masters; ?>">
                                            <a href="javascript:void(0);"><i class="icon-grid"></i> <span>Masters</span></a>
                                            <ul>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'scooterO')): ?> 
                                                    <li class="<?php echo $scooterO; ?>"><a href="<?php echo base_url() . 'masters/scooterO'; ?>"><i class="icon-chevron-right"></i>ScooterO</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'subscriptions')): ?> 
                                                    <li class="<?php echo $subscriptions; ?>"><a href="<?php echo base_url() . 'masters/subscriptions'; ?>"><i class="icon-chevron-right"></i>Subscriptions</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'customers')): ?> 
                                                    <li class="<?php echo $customers; ?>"><a href="<?php echo base_url() . 'masters/customers'; ?>"><i class="icon-chevron-right"></i>Customers</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'setting')): ?> 
                                                    <li class="<?php echo $manage_streets; ?>"><a href="<?php echo base_url() . 'masters/setting'; ?>"><i class="icon-chevron-right"></i>General Settings</a></li> 
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->user_auth->is_module_allowed('users')): ?>
                                        <li class="<?php echo $users; ?>">
                                            <a href="javascript:void(0);"><i class="icon-users4"></i> <span>Users</span></a>
                                            <ul>
                                                <?php if ($this->user_auth->is_section_allowed('users', 'users')): ?>
                                                    <li class="<?php echo $manage_users; ?>"><a href="<?php echo base_url() . 'users'; ?>"><i class="icon-chevron-right"></i>Manage Users</a></li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('users', 'user_types')): ?>
                                                    <li class="<?php echo $manage_user_types; ?>"><a href="<?php echo base_url() . 'users/user_types'; ?>"><i class="icon-chevron-right"></i>Manage User Types</a></li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('users', 'user_modules')): ?>
                                                    <li class="<?php echo $manage_user_modules; ?>"><a href="<?php echo base_url() . 'users/user_modules'; ?>"><i class="icon-chevron-right"></i>Manage User Modules</a></li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('users', 'user_sections')): ?>
                                                    <li class="<?php echo $manage_user_sections; ?>"><a href="<?php echo base_url() . 'users/user_sections'; ?>"><i class="icon-chevron-right"></i>Manage User Sections</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->user_auth->is_module_allowed('reports')): ?>
                                        <li class="<?php echo $reports; ?>">
                                            <a href="javascript:void(0);"><i class="icon-grid"></i> <span>Reports</span></a>
                                            <ul>
                                                <?php if ($this->user_auth->is_section_allowed('reports', 'invoice_report')): ?> 
                                                    <li class="<?php echo $invoice_report; ?>"><a href="<?php echo base_url() . 'reports/invoice_report'; ?>"><i class="icon-chevron-right"></i>Invoice Report</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('reports', 'customer_feedback_report')): ?> 
                                                    <li class="<?php echo $customer_feedback_report; ?>"><a href="<?php echo base_url() . 'reports/customer_feedback_report'; ?>"><i class="icon-chevron-right"></i>Customer Feedback Report</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('reports', 'transaction_report')): ?> 
                                                    <li class="<?php echo $transaction_report; ?>"><a href="<?php echo base_url() . 'reports/transaction_report'; ?>"><i class="icon-chevron-right"></i>Transaction Report</a></li> 
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('reports', 'wallet_report')): ?> 
                                                    <li class="<?php echo $wallet_report; ?>"><a href="<?php echo base_url() . 'reports/wallet_report'; ?>"><i class="icon-chevron-right"></i>Wallet Report</a></li> 
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                        <li>
                                        <a href="<?php echo base_url() . 'gps/index';?>"><i class="icon-grid"></i><span>Gps tracking</span></a>
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
        background-image:url('../themes/scootero/assets/images/ajax-loader/loading.gif');
        background-repeat:no-repeat;
        background-position:center;
        z-index:10000000;
        opacity: 0.7;
        filter: alpha(opacity=40);
    }
</style>