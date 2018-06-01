<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo ($id == 'new') ? 'Add new donation' : 'Edit donation'; ?></h1>
        </div>
    </div>
    <div class="panel panel-default">
        <form method="post" id="form1" role="form" enctype="multipart/form-data">
            <div class="panel-heading">            
                <a href="admin/donations" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
                <button type="submit" form="form1" class="btn btn-info"><i class="fa fa-floppy-o"></i> Save</button>                
            </div>            
            <div class="panel-body">
                <?php if ($id != 'new') { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li <?php echo ($active_tab == 0) ? 'class="active"' : ''; ?>>
                                    <a href="#details" data-toggle="tab">Donation details</a>
                                </li>
                                <li <?php echo ($active_tab == 1) ? 'class="active"' : ''; ?>>
                                    <a href="#booking" data-toggle="tab">Booking <?php echo '(' . $quantity_remain . ' remains)'; ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane <?php echo ($active_tab == 0) ? 'active' : ''; ?>" id="details">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                <?php } ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Location, where the donation is issued</h4>
                                        <?php
                                        if (isset($location_id)) {
                                            echo '<input type="hidden" id="location_posted" value="' . $location_id . '"/>';
                                        }
                                        ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="location_country" class="control-label">Country</label>
                                                            <select class="form-control" id="location_country">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="location_state" class="control-label">State</label>
                                                            <select class="form-control" id="location_state">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="location_city" class="control-label">City</label>
                                                            <select class="form-control" id="location_city">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="location_id" class="control-label">Location title</label>
                                                            <select class="form-control" id="location_id" name="location_id">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="control-label">Local time</label>
                                                        <div id="local_time"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="location_display"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Donation details</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="food_type_id">Type of food</label>
                                                    <?php echo $food_types_selector; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="preferences">Dietary preference</label>
                                                <select class="form-control" id="preferences" name="preferences">
                                                    <option <?php echo (isset($preferences) && ($preferences == 0)) ? 'selected="selected"' : ''; ?> value="0">No dietary preference</option>
                                                    <option <?php echo (isset($preferences) && ($preferences == 1)) ? 'selected="selected"' : ''; ?> value="1">Vegetarian</option>
                                                    <option <?php echo (isset($preferences) && ($preferences == 2)) ? 'selected="selected"' : ''; ?> value="2">Vegan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if ($id == 'new') { ?>
                                                    <div class="form-group">
                                                        <label for="expiry_days">Duration</label>
                                                        <div class="input-group">
                                                            <span id="hours" class="input-group-addon"><?php echo (isset($expiry_hours) ? $expiry_hours : 1) . ' h'; ?></span>
                                                            <input type="range" class="form-control" id="expiry_hours" name="expiry_hours" min="1" max="24" value="<?php echo (isset($expiry_hours) ? $expiry_hours : 1); ?>"/>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Expiration in : </label>
                                                            <div class="countdown" data-time="<?php echo $timer; ?>"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Reset the timer</label>                                           
                                                            <div class="form-group input-group">
                                                                <select name="donation_reset" form="form2" class="form-control" style="background-color: #5bc0de;border-color: #46b8da;color: white;">
                                                                    <option value="1">1 hour</option>
                                                                    <option value="2">2 hours</option>
                                                                    <option value="3">3 hours</option>
                                                                    <option value="4">4 hours</option>
                                                                    <option value="5">5 hours</option>
                                                                    <option value="6">6 hours</option>
                                                                    <option value="7">7 hours</option>
                                                                    <option value="8">8 hours</option>
                                                                    <option value="9">9 hours</option>
                                                                    <option value="10">10 hours</option>
                                                                    <option value="11">11 hours</option>
                                                                    <option value="12">12 hours</option>
                                                                    <option value="13">13 hours</option>
                                                                    <option value="14">14 hours</option>
                                                                    <option value="15">15 hours</option>
                                                                    <option value="16">16 hours</option>
                                                                    <option value="17">17 hours</option>
                                                                    <option value="18">18 hours</option>
                                                                    <option value="19">19 hours</option>
                                                                    <option value="20">20 hours</option>
                                                                    <option value="21">21 hours</option>
                                                                    <option value="22">22 hours</option>
                                                                    <option value="23">23 hours</option>
                                                                    <option value="24" selected="selected">24 hours</option>
                                                                </select>
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-info" type="submit" form="form2">
                                                                        Reset
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($title) ? $title : '' ?>"/>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('title');
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo isset($quantity) ? $quantity : 1 ?>"/>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('quantity');
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('description');
                                                        ?>
                                                    </span>
                                                    <textarea class="form-control" rows="6" id="description" name="description" ><?php echo isset($description) ? $description : '' ?></textarea>                                    
                                                </div>
                                            </div>
                                        </div>                        
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Allergens information</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row allergy">
                                            <?php
                                            foreach ($this->config->allergies as $key => $value) {
                                                ?>
                                                <div class="col-lg-3">
                                                    <label class="well">
                                                        <input type="hidden" name="allergy[<?php echo $key; ?>]" value="0"/>
                                                        <input type="checkbox" name="allergy[<?php echo $key; ?>]" value="1" <?php echo($allergy[$key] ? ' checked="checked"' : ''); ?>/>
                                                        <?php echo $value; ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($id != 'new') { ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane  <?php echo ($active_tab == 1) ? 'active' : ''; ?>" id="booking">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <button type="button" <?php echo (($timer <= 0) || ($quantity_remain < 1)) ? 'disabled="disabled"' : ''; ?> data-toggle="modal" data-target="#new_booking" class="btn btn-success"><i class="fa fa-gift"></i> New Booking</button>
                                            <?php
                                            if ($timer <= 0) {
                                                echo '<br>';
                                                echo '<h3>The donation timer has expired. You need to restart it before you make a booking.</h3>';
                                            }
                                            ?>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            if (count($booking)) {
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tr>
                                                            <th>User</th>
                                                            <th>Delivery</th>
                                                            <th style="width:100px">Quantity</th>
                                                            <th style="width:150px">Time remain</th>
                                                            <th style="width:100px">Control</th>
                                                        </tr>
                                                        <?php
                                                        foreach ($booking as $k => $v) {
                                                            echo '<tr>';
                                                            echo '<td>';
                                                            if ($users[$v['user_id']]['data']['profile_image']) {
                                                                echo '<span class="pull-left" style="margin-right:36px;">';
                                                                echo '<img src="' . $users[$v['user_id']]['data']['profile_image'] . '" style="height:50px;width:auto" class="img img-responsive"/>';
                                                                echo '</span>';
                                                            } else {
                                                                echo '<span class="pull-left" style="margin-right:36px;">';
                                                                echo '<img src="https://placeholdit.imgix.net/~text?txtsize=12&txt=No%20image&w=67&h=50" style="height:50px;width:auto" class="img img-responsive"/>';
                                                                echo '</span>';
                                                            }
                                                            echo '<i class="fa fa-at"></i> <a target="_blank" href="' . $users[$v['user_id']]['admin_link'] . '">' . $users[$v['user_id']]['email'] . '</a><br>';
                                                            if ($users[$v['user_id']]['screen_name'] && ($users[$v['user_id']]['screen_name'] != $users[$v['user_id']]['email'])) {
                                                                echo '<i class="fa fa-user"></i> ' . $users[$v['user_id']]['screen_name'] . '<br>';
                                                            }
                                                            if ($users[$v['user_id']]['data']['mobile_phone']) {
                                                                echo '<i class="fa fa-phone-square"></i> ' . $users[$v['user_id']]['data']['mobile_phone'];
                                                            }

                                                            echo '</td>';
                                                            echo '<td>';
                                                            if ($v['requested_delivery']) {
                                                                echo $v['delivery_address'];
                                                            } 
                                                            echo '</td>';
                                                            echo '<td class="align-right"><h4>' . $v['quantity'] . '</h4></td>';
                                                            if ($v['delivered']) {
                                                                echo '<td class="align-center" style="color:green"><i class="fa fa-thumbs-o-up fa-2x"></i><br><span style="font-size:1.5em">Taken</span></td>';
                                                            } else {
                                                                echo '<td><div class="countdown" data-time="' . strtotime($v['date_expire']) . '"></div></td>';
                                                            }

                                                            echo '<td>';
                                                            if (!$v['delivered']) {
                                                                echo '  <a href="admin/booking/taken?id=' . $k . '"  class="btn btn-xs btn-block btn-info">Mark as taken</a>';
                                                                echo '  <a href="admin/booking/reset?id=' . $k . '" class="btn btn-xs btn-block btn-success">Reset timer</a>';
                                                            }
                                                            echo '  <a href="admin/booking/delete?id=' . $k . '" class="btn btn-xs btn-block btn-danger">Delete</button>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                                <?php
                                            } else {
                                                echo 'No booking entries yet.';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>
<form id="form2" method="post"></form>
<?php if ($id != 'new') { ?>
    <div class="modal fade" id="new_booking" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form3">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add new booking</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="booking_user_id">Book to user</label>
                                    <?php echo $user_selector; ?>
                                </div>
                                <div class="form-group">
                                    <label for="booking_qty">Quantity</label>
                                    <input type="number" id="booking_qty" name="booking_qty" value="1" min="1" max="<?php echo $quantity_remain; ?>" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<style>
    #location_display strong{
        min-width: 110px;
        display: inline-block;
    }
    #location_display{
        border: 1px solid #ccc;
        padding: 16px;
        box-shadow: 3px 3px 3px rgba(0,0,0,0.5);
    }
    #admin-wrapper .input-group{
        border: 1px solid #aaa;
        border-radius: 4px;
    }
    #admin-wrapper .input-group .input-group-addon {
        border: none;
        min-width: 80px;
        background-color: #aaa;
        color: white;
    }
    #admin-wrapper input[type="range"]{
        cursor: pointer;
    }   

</style>
<script>
    $(document).ready(function () {
        $('#expiry_hours').change(function () {
            $('#hours').html(this.value + ' h');
        });


    });

</script>