<div id="page-wrapper">   
    <div class="row">
        <div class="col-md-6">
            <?php if (count($unverified_locations)) { ?>
                <h3>Locations with pending verification 
                    <span class="pull-right">
                        <a href="admin/locations" class="btn btn-danger btn-sm"><i class="fa fa-arrow-right"></i> <?php echo count($unverified_locations); ?></a>
                    </span>
                </h3>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Whereabout</th>
                        </tr>
                        <?php $count_locations = 0; ?>
                        <?php foreach ($unverified_locations as $k => $v) { ?>
                            <?php
                            $count_locations ++;
                            if ($count_locations > 5) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td>
                                    <a href="admin/locations/edit?id=<?php echo $k; ?>" class="block">
                                        <?php echo $v['title']; ?>
                                    </a>                            
                                </td>
                                <td>
                                    <a href="admin/locations/edit?id=<?php echo $k; ?>" class="block"><?php echo $v['description']; ?></a>
                                </td>
                                <td>
                                    <a href="admin/locations/edit?id=<?php echo $k; ?>" class="block">
                                        <?php echo $v['country'] . '/' . $v['state'] . '/' . $v['city']; ?><br>
                                        <?php echo $v['address']; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <hr>
            <?php } ?>
            <?php if (count($active_donations)) { ?>
            <?php } ?>
            <h3>
                Currently active donations
                <span class="pull-right">
                    <a href="admin/donations" class="btn btn-danger btn-sm"><i class="fa fa-arrow-right"></i> <?php echo count($active_donations); ?></a>
                </span>
            </h3>
            <hr>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Food type</th>
                        <th>Remain</th>
                        <th>Timer</th>
                    </tr>
                    <?php $donations_count = 0; ?>
                    <?php foreach ($active_donations as $donation) { ?>
                    <?php 
                        $donations_count++; 
                        if($donations_count>5){
                            continue;
                        }
                    ?>
                        <tr>
                            <td>
                                <a href="admin/donations/edit?id=<?php echo $donation['id']; ?>" class="block">
                                    <?php echo $donation['title']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="admin/locations/edit?id=<?php echo $donation['location_id']; ?>" class="block">
                                    <?php echo $donation['location']; ?>
                                </a>
                            </td>
                            <td><?php echo $donation['food_type']; ?></td>                        
                            <td><?php echo $donation['qty_remain']; ?></td>                                                
                            <td>
                                <span class="countdown" data-time="<?php echo $donation['timer']; ?>"></span>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Quick links</h3><br>
            <div class="row">        
                <div class="col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-map-marker fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Locations</div>
                                    <div><?php echo $dashboard['locations_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/locations">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gift fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Donations</div>
                                    <div><?php echo $dashboard['donations_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/donations">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-location-arrow fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Location types</div>
                                    <div><?php echo $dashboard['location_type_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/location-types">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-spoon fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Food types</div>
                                    <div><?php echo $dashboard['food_types_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/food-types">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Users</div>
                                    <div><?php echo $dashboard['users_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/users">
                            <div class="panel-footer">
                                <span class="pull-left">Manage users</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Administrators</div>
                                    <div><?php echo $dashboard['admin_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/administrators">
                            <div class="panel-footer">
                                <span class="pull-left">Manage users</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>        
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cog fa-4x fa-fw"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">System</div>
                                    <div>Modify the system settings<br></div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/general">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-film fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Slider</div>
                                    <div><?php echo $dashboard['slides_count']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/slider">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>        
        </div>
    </div>

    <br>           
</div>