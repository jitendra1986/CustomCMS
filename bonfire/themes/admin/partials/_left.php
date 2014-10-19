
<!-- START aside-->
<aside class="aside">
    <!-- START Sidebar (left)-->
    <nav class="sidebar">
        <ul class="nav">
            <!-- START user info-->
            <li>
                <div data-toggle="collapse-next" class="item user-block has-submenu">
                    <!-- User picture-->
                    <div class="user-block-picture">
                        <img src="<?php echo Template::theme_url('app/img/user/02.jpg') ?>" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle">
                        <!-- Status when collapsed-->
                        <div class="user-block-status">
                            <div class="point point-success point-lg"></div>
                        </div>
                    </div>
                    <!-- Name and Role-->
                    <div class="user-block-info">
                        <span class="user-block-name item-text">Welcome, <?php echo $current_user->display_name ?></span>
                        <span class="user-block-role"><?php echo $current_user->role_name ?></span>
                        <!-- START Dropdown to change status-->
                        <div class="btn-group user-block-status">
                            <button type="button" data-toggle="dropdown" data-play="fadeIn" data-duration="0.2" class="btn btn-xs dropdown-toggle">
                                <div class="point point-success"></div>Online</button>
                            <ul class="dropdown-menu text-left pull-right">
                                <li>
                                    <a href="#">
                                        <div class="point point-success"></div>Online</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="point point-warning"></div>Away</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="point point-danger"></div>Busy</a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Dropdown to change status-->
                    </div>
                </div>
                <!-- START User links collapse-->
                <ul class="nav collapse">
                    <li><a href="<?php echo site_url(SITE_AREA . '/settings/users/edit') ?>">Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo site_url('logout'); ?>">Logout</a>
                    </li>
                </ul>
                <!-- END User links collapse-->
            </li>
            <!-- END user info-->
            <!-- START Menu-->
            <li class="active">
                <a href="<?php echo site_url(SITE_AREA . '/content') ?>" title="Dashboard" data-toggle="" class="no-submenu">
                    <em class="fa fa-dashboard"></em>
                    <!--<div class="label label-primary pull-right">12</div>-->
                    <span class="item-text">Dashboard</span>
                </a>
            </li>
            <?php echo Contexts::render_menu('text', 'normal'); ?>
            <!-- END Menu-->
            <!-- Sidebar footer    -->
            <li class="nav-footer">
                <div class="nav-footer-divider"></div>
                <!-- START button group-->
                <div class="btn-group text-center">
                    <div class="footer-right">Developed By :<a href="http://offshoredevelopment-india.com" target="_blank">Creative Cartels</a></div>
                    <a href="<?php echo site_url('logout'); ?>" class="btn btn-link"><em class="fa fa-sign-out text-muted"></em></a>
                </div>
                <!-- END button group-->
            </li>
        </ul>
    </nav>
    <!-- END Sidebar (left)-->
</aside>
<!-- End aside-->