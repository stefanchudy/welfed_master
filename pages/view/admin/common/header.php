<?php echo '<div id="admin-wrapper">'; ?>


<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="admin/dashboard">Site Administration</a>
    </div>
    <ul class="nav navbar-top-links navbar-right">        
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?php
                if ($dashboard['message_unread'] != 0) {
                    echo '<i style="color:#b2003a;" class="fa fa-envelope fa-spin fa-fw"></i> <span style="color:#b2003a;">' . $dashboard['message_unread'] . ' new</span>';
                } else {
                    echo '<i class="fa fa-envelope fa-fw"></i>';
                }
                ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <?php
                foreach ($dashboard['message_preview'] as $msg) {
                    echo '<li>';
                    echo '<a href="admin/messages/read?id=' . $msg['id'] . '">';
                    echo '<div>';
                    echo ($msg['read'] == 0) ? '<span class="label label-danger">New</span><br>' : '';
                    echo '<strong>' . $this->cutString($msg['name'], 30) . '</strong>';
                    echo '<span class="pull-right text-muted">';
                    echo '<em>' . $msg['date'] . '</em>';
                    echo '</span>';
                    echo '</div>';
                    echo '<div>' . \Utility\Messaging::getMessageType($msg['type']) . '</div>';
                    echo '</a>';
                    echo '</li>';
                    echo '<li class="divider"></li>';
                }
                ?>                
                <li>
                    <a class="text-center" href="admin/messages">
                        <strong>Read All Messages</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $user['screen_name']; ?> <i class="fa fa-caret-down"></i>                    
            </a>
            <ul class="dropdown-menu dropdown-user">                
                <li>
                    <a href=""><i class="fa fa-globe fa-fw"></i> Open the front</a>
                </li>
                <li>
                    <a href="admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">                    
                <li>
                    <a href="/admin/dashboard">
                        <i class="fa fa-dashboard fa-fw"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/locations">
                        <i class="fa fa-map-marker fa-fw"></i> Pickup locations
                    </a>
                </li>
                <li>
                    <a href="/admin/donations">
                        <i class="fa fa-gift fa-fw"></i> Donations
                    </a>
                </li>
                <li>
                    <a href="/admin/location-types">
                        <i class="fa fa-location-arrow fa-fw"></i> Pickup location types
                    </a>
                </li>
                <li>
                    <a href="/admin/food-types">
                        <i class="fa fa-spoon fa-fw"></i> Food types
                    </a>
                </li>
                <li>
                    <a href="/admin/working-areas">
                        <i class="fa fa-globe fa-fw"></i> Working areas
                    </a>
                </li>
                <li>
                    <a href="/admin/blog">
                        <i class="fa fa-newspaper-o fa-fw"></i> Blog posts
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-gavel fa-fw"></i> Legal documents<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="admin/legal/food-recipient-agreement">Food Recipient Agreement</a>
                        </li>
                        <li>
                            <a href="admin/legal/food-donation-agreement">Food Donation Agreement</a>
                        </li>
                        <li>
                            <a href="admin/legal/terms-of-website">Terms of Website Use</a>
                        </li>
                        <li>
                            <a href="admin/legal/privacy-policy">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="admin/legal/food-safety-and-hygiene">Food Safety and Hygiene Policy</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-rss fa-fw"></i> API<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/admin/remotelist">Remote sites list</a>
                        </li>
                        <li>
                            <a href="/admin/remote-log">Communication log</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cog fa-fw"></i> System<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/admin/general">General settings</a>
                        </li>
                        <li>
                            <a href="/admin/administrators">Site administrators</a>
                        </li>                        
                        <li>
                            <a href="/admin/users">User management</a>
                        </li>
                    </ul>                    
                </li>                    
            </ul>
        </div>        
    </div>    
</nav>
