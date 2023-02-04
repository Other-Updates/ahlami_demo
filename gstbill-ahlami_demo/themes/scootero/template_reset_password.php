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
        <?php if ($is_favicon_allowed): ?>
            <link rel="icon" type="image/png" href="<?php echo $theme_path ?>/assets/images/favicon.png" />
        <?php endif; ?>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/icons/icomoon/styles.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/bootstrap.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/core.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/components.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/assets/css/colors.css" >
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $theme_path; ?>/assets/js/core/app.js"></script>
        <!-- /theme JS files -->

    </head>

    <body class="login-container">
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="<?php echo $theme_path; ?>/assets/images/logo1.png" alt=""></a>

                <ul class="nav navbar-nav pull-right visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                </ul>
            </div>

            <!--            <div class="navbar-collapse collapse" id="navbar-mobile">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="#">
                                        <i class="icon-display4"></i> <span class="visible-xs-inline-block position-right"> Go to website</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-cog3"></i>
                                        <span class="visible-xs-inline-block position-right"> Options</span>
                                    </a>
                                </li>
                            </ul>
                        </div>-->
        </div>
        <!-- /main navbar -->


        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Content area -->
                    <?php echo $content; ?>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

    </body>
</html>
