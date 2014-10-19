<?php
if (isset($shortcut_data) && is_array($shortcut_data['shortcut_keys'])) {
    Assets::add_js($this->load->view('ui/shortcut_keys', $shortcut_data, true), 'inline');
}
?>





<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie ie6 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="ie ie7 lt-ie9 lt-ie8"        lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="ie ie8 lt-ie9"               lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="ie ie9"                      lang="en"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-ie">
    <!--<![endif]-->
    <head>
        <!-- Meta-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <title>Creative Cartels : CMS Admin Panel</title>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script><script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?php echo Template::theme_url('app/css/bootstrap.css'); ?>">
        <!-- Vendor CSS-->
        <link rel="stylesheet" href="<?php echo Template::theme_url('vendor/fontawesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo Template::theme_url('vendor/animo/animate+animo.css'); ?>">
        <link rel="stylesheet" href="<?php echo Template::theme_url('vendor/csspinner/csspinner.min.css'); ?>">
        <!-- START Page Custom CSS-->
        <!-- END Page Custom CSS-->
        <!-- App CSS-->
        <?php echo Assets::css(null, true); ?>
        <link rel="stylesheet" href="<?php echo Template::theme_url('app/css/app.css'); ?>">
        <!-- Modernizr JS Script-->
        <script src="<?php echo Template::theme_url('vendor/modernizr/modernizr.js'); ?>" type="application/javascript"></script>
        <!-- FastClick for mobiles-->
        <script src="<?php echo Template::theme_url('vendor/fastclick/fastclick.js'); ?>" type="application/javascript"></script>
    </head>
    <body>
        <noscript>
        <p>Javascript is required to use Bonfire's admin.</p>
        </noscript>

        <!-- START Main wrapper-->
        <section class="wrapper">
            <nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
                <!-- START navbar header-->
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">
                        <div class="brand-logo"><img src="<?php echo Template::theme_url('app/img/c-logo.png'); ?>"  alt="Creative Cartels"></div>
                        <div class="brand-logo-collapsed"><img src="<?php echo Template::theme_url('app/img/c-logo-small.png'); ?>"  alt="Creative Cartels"></div>
                    </a>
                </div>
                <!-- END navbar header-->
                <!-- START Nav wrapper-->
                <div class="nav-wrapper">
                    <?php Template::block('sub_nav', ''); ?>
                    <!-- START Left navbar-->
                    <!--                    <ul class="nav navbar-nav">
                                            <li>
                                                <a href="#" data-toggle="aside">
                                                    <em class="fa fa-align-left"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="navbar-search">
                                                    <em class="fa fa-search"></em>
                                                </a>
                                            </li>
                                        </ul>-->
                    <!-- END Left navbar-->
                    <!-- START Right Navbar-->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- START Messages menu (dropdown-list)-->
                        <li class="dropdown dropdown-list">
                            <a href="#" data-toggle="dropdown" data-play="bounceIn" class="dropdown-toggle">
                                <em class="fa fa-envelope"></em>
                                <div class="label label-danger">300</div>
                            </a>
                            <!-- START Dropdown menu-->
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-header">You have 5 new messages</li>
                                <li>
                                    <div class="scroll-viewport">
                                        <!-- START list group-->
                                        <div class="list-group scroll-content">
                                            <!-- START list group item-->
                                            <a href="#" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <img style="width: 48px; height: 48px;" src="<?php echo Template::theme_url('app/img/user/01.jpg') ?>" alt="Image" class="media-object img-rounded">
                                                    </div>
                                                    <div class="media-body clearfix">
                                                        <small class="pull-right">2h</small>
                                                        <strong class="media-heading text-primary">
                                                            <div class="point point-success point-lg"></div>Sheila Carter</strong>
                                                        <p class="mb-sm">
                                                            <small>Cras sit amet nibh libero, in gravida nulla. Nulla...</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- END list group item-->
                                            <!-- START list group item-->
                                            <a href="#" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <img style="width: 48px; height: 48px;" src="<?php echo Template::theme_url('app/img/user/04.jpg') ?>" alt="Image" class="media-object img-rounded">
                                                    </div>
                                                    <div class="media-body clearfix">
                                                        <small class="pull-right">3h</small>
                                                        <strong class="media-heading text-primary">
                                                            <div class="point point-success point-lg"></div>Rich Reynolds</strong>
                                                        <p class="mb-sm">
                                                            <small>Cras sit amet nibh libero, in gravida nulla. Nulla...</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- END list group item-->
                                            <!-- START list group item-->
                                            <a href="#" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <img style="width: 48px; height: 48px;" src="<?php echo Template::theme_url('app/img/user/03.jpg') ?>" alt="Image" class="media-object img-rounded">
                                                    </div>
                                                    <div class="media-body clearfix">
                                                        <small class="pull-right">4h</small>
                                                        <strong class="media-heading text-primary">
                                                            <div class="point point-danger point-lg"></div>Beverley Pierce</strong>
                                                        <p class="mb-sm">
                                                            <small>Cras sit amet nibh libero, in gravida nulla. Nulla...</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- END list group item-->
                                            <!-- START list group item-->
                                            <a href="#" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <img style="width: 48px; height: 48px;" src="<?php echo Template::theme_url('app/img/user/05.jpg') ?>" alt="Image" class="media-object img-rounded">
                                                    </div>
                                                    <div class="media-body clearfix">
                                                        <small class="pull-right">4h</small>
                                                        <strong class="media-heading text-primary">
                                                            <div class="point point-danger point-lg"></div>Perry Cole</strong>
                                                        <p class="mb-sm">
                                                            <small>Cras sit amet nibh libero, in gravida nulla. Nulla...</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- END list group item-->
                                            <!-- START list group item-->
                                            <a href="#" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left">
                                                        <img style="width: 48px; height: 48px;" src="<?php echo Template::theme_url('app/img/user/06.jpg') ?>" alt="Image" class="media-object img-rounded">
                                                    </div>
                                                    <div class="media-body clearfix">
                                                        <small class="pull-right">4h</small>
                                                        <strong class="media-heading text-primary">
                                                            <div class="point point-danger point-lg"></div>Carolyn Carpenter</strong>
                                                        <p class="mb-sm">
                                                            <small>Cras sit amet nibh libero, in gravida nulla. Nulla...</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- END list group item-->
                                        </div>
                                        <!-- END list group-->
                                    </div>
                                </li>
                                <!-- START dropdown footer-->
                                <li class="p">
                                    <a href="#" class="text-center">
                                        <small class="text-primary">READ ALL</small>
                                    </a>
                                </li>
                                <!-- END dropdown footer-->
                            </ul>
                            <!-- END Dropdown menu-->
                        </li>
                        <!-- END Messages menu (dropdown-list)-->
                        <!-- START Alert menu-->
                        <li class="dropdown dropdown-list">
                            <a href="#" data-toggle="dropdown" data-play="bounceIn" class="dropdown-toggle">
                                <em class="fa fa-bell"></em>
                                <div class="label label-info">120</div>
                            </a>
                            <!-- START Dropdown menu-->
                            <ul class="dropdown-menu">
                                <li>
                                    <!-- START list group-->
                                    <div class="list-group">
                                        <!-- list item-->
                                        <a href="#" class="list-group-item">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <em class="fa fa-envelope-o fa-2x text-success"></em>
                                                </div>
                                                <div class="media-body clearfix">
                                                    <div class="media-heading">Unread messages</div>
                                                    <p class="m0">
                                                        <small>You have 10 unread messages</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- list item-->
                                        <a href="#" class="list-group-item">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <em class="fa fa-cog fa-2x"></em>
                                                </div>
                                                <div class="media-body clearfix">
                                                    <div class="media-heading">New settings</div>
                                                    <p class="m0">
                                                        <small>There are new settings available</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- list item-->
                                        <a href="#" class="list-group-item">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <em class="fa fa-fire fa-2x"></em>
                                                </div>
                                                <div class="media-body clearfix">
                                                    <div class="media-heading">Updates</div>
                                                    <p class="m0">
                                                        <small>There are
                                                            <span class="text-primary">2</span>new updates available</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- last list item -->
                                        <a href="#" class="list-group-item">
                                            <small>Unread notifications</small>
                                            <span class="badge">14</span>
                                        </a>
                                    </div>
                                    <!-- END list group-->
                                </li>
                            </ul>
                            <!-- END Dropdown menu-->
                        </li>
                        <!-- END Alert menu-->
                        <!-- START User menu-->
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" data-play="bounceIn" class="dropdown-toggle">
                                <em class="fa fa-user"></em>
                            </a>
                            <!-- START Dropdown menu-->
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="p">
                                        <p>Overall progress</p>
                                        <div class="progress progress-striped progress-xs m0">
                                            <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;" class="progress-bar progress-bar-success">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Profile</a>
                                </li>
                                <li><a href="#">Settings</a>
                                </li>
                                <li><a href="#">Notifications<div class="label label-info pull-right">5</div></a>
                                </li>
                                <li><a href="#">Messages<div class="label label-danger pull-right">10</div></a>
                                </li>
                                <li><a href="#">Logout</a>
                                </li>
                            </ul>
                            <!-- END Dropdown menu-->
                        </li>
                        <!-- END User menu-->
                        <!-- START Contacts button-->
                        <!--                        <li>
                                                    <a href="#" data-toggle="offsidebar">
                                                        <em class="fa fa-align-right"></em>
                                                    </a>
                                                </li>-->
                        <!-- END Contacts menu-->
                    </ul>
                    <!-- END Right Navbar-->
                </div>
                <!-- END Nav wrapper-->
                <!-- START Search form-->
                <form role="search" class="navbar-form">
                    <div class="form-group has-feedback">
                        <input type="text" placeholder="Type and hit Enter.." class="form-control">
                        <div data-toggle="navbar-search-dismiss" class="fa fa-times form-control-feedback"></div>
                    </div>
                    <button type="submit" class="hidden btn btn-default">Submit</button>
                </form>
                <!-- END Search form-->
            </nav>
