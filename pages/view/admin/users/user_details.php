<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo (($action == 'add') ? 'Add new ' : 'Edit ') . (($user_type) ? 'administrator' : 'user') ?></h1>
        </div>        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">   
                <div class="panel-heading">
                    <input type="submit" value="Save" class="btn btn-default" form="form1"/>
                    <a href="admin/<?php echo ($user_type) ? 'administrators' : 'users'; ?>" class="btn btn-default">Return</a>
                </div>
                <div class="panel panel-body">
                    <?php if ($action == 'edit') { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#user_data" data-toggle="tab">
                                            User data
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#locations" data-toggle="tab">
                                            Managed locations <span class="badge"><?php echo count($locations); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#donations_issued" data-toggle="tab">
                                            Issued donations <span class="badge"><?php echo count($donations_issued); ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#donations_taken" data-toggle="tab">
                                            Taken donations <span class="badge"><?php echo count($donations_used); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($action == 'edit') { ?>
                        <div class="tab-content">
                        <?php } ?>
                        <?php if ($action == 'edit') { ?>
                            <div class="tab-pane active" id="user_data">
                            <?php } ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form id="form1" role="form" method="post" class="form-horizontal">                            
                                        <div class="row">
                                            <div class="col-md-<?php echo (($action == 'add') ? '12' : '9'); ?>">
                                                <?php if (($action == 'edit') && ($user_type == 0)) { ?>
                                                    <fieldset>
                                                        <legend>Status</legend>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ban" class="control-label col-md-4">Status</label>
                                                                    <div class="col-md-8">
                                                                        <select id="ban" name="ban" class="form-control">
                                                                            <option value="0" <?php echo ($ban == 0) ? 'selected="selected"' : ''; ?>>Active</option>
                                                                            <option value="1" <?php echo ($ban == 1) ? 'selected="selected"' : ''; ?>>Banned</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="advanced" class="control-label col-md-4">Volunteer</label>
                                                                    
                                                                    <div class="col-md-8">
                                                                        <select id="advanced" name="advanced" class="form-control">
                                                                            <option value="0" <?php echo ($advanced == 0) ? 'selected="selected"' : ''; ?>>No</option>
                                                                            <option value="1" <?php echo ($advanced == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                <?php } ?>
                                                <fieldset>
                                                    <legend>Login data</legend>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-2">E-mail</label>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" <?php echo (($action == 'edit') ? ' readonly="readonly"' : ''); ?> name="email" id="email" type="text" placeholder="Enter e-mail" value="<?php echo isset($email) ? $email : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('email');
                                                                        ?>
                                                                    </span>
                                                                </div>                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pass1" class="control-label col-md-4">Password</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" name="pass1" id="pass1" type="password" placeholder="Enter password" value="<?php echo isset($pass1) ? $pass1 : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('pass1');
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pass2" class="control-label col-md-4">Repeat password</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" name="pass2" id="pass1" type="password" placeholder="Enter the password again"value="<?php echo isset($pass2) ? $pass2 : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('pass2');
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend>Personal details</legend>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="first_name" class="control-label col-md-4">First name</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" name="first_name" id="first_name" type="text" placeholder="First name" value="<?php echo isset($first_name) ? $first_name : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('first_name');
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="last_name" class="control-label col-md-4">Last name</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" name="last_name" id="last_name" type="text" placeholder="Last name"value="<?php echo isset($last_name) ? $last_name : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('last_name');
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="mobile_phone" class="control-label col-md-2">Mobile phone</label>
                                                                <div class="col-lg-4">
                                                                    <input class="form-control" name="mobile_phone" id="mobile_phone" type="text" placeholder="Mobile phone" value="<?php echo isset($mobile_phone) ? $mobile_phone : ''; ?>"/>
                                                                    <span class="small-alert">
                                                                        <?php
                                                                        echo $this->showErrors('mobile_phone');
                                                                        ?>
                                                                    </span>
                                                                </div>                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <?php if ($action != 'add') { ?>
                                                <div class="col-md-3">
                                                    <fieldset>
                                                        <legend>Image (click to upload)</legend>   
                                                        <div class="align-center">
                                                            <label for="user_image">
                                                                <img src="<?php echo $profile_image; ?>" class="img-upload img img-responsive img-centered img-thumbnail" style="max-width:250px"/>
                                                            </label>                                            
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset>
                                                    <legend>Dietary preferences</legend>
                                                    <div class="form-group">
                                                        <label for="preferences" class="control-label col-md-2">Dietary preferences</label>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="preferences" id="preferences">
                                                                <option <?php echo (isset($preferences) && ($preferences == 0) ) ? 'selected="selected"' : ''; ?> value="0">No dietary preferences</option>
                                                                <option <?php echo (isset($preferences) && ($preferences == 1) ) ? 'selected="selected"' : ''; ?>value="1">Vegetarian</option>
                                                                <option <?php echo (isset($preferences) && ($preferences == 2) ) ? 'selected="selected"' : ''; ?>value="2">Vegan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </fieldset>                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset>
                                                    <legend>
                                                        Allergies information
                                                    </legend>
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
                                                </fieldset>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if ($action == 'edit') { ?>
                            </div>   <!--closing tab pane #user_data-->
                            <?php if ($action == 'edit') { ?>
                                <div class="tab-pane" id="locations">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php
                                            if (count($locations) == 0) {
                                                echo 'No locations are managed by this user.';
                                            } else {
                                                echo '<div class="list-group">';
                                                foreach ($locations as $location) {
                                                    echo '<div class="list-group-item">';
                                                    echo '<a class="btn btn-block btn-default" href="admin/locations/edit?id=' . $location['id'] . '">';
                                                    if ($location['location_logo'] != '')
                                                        echo '<img src="' . $location['location_logo'] . '" style="height:50px;width:auto;margin-right:32px"/>';

                                                    echo $location['location_title'] . ' / ' . $location['location_country'] . ' / ' . $location['location_state'] . ' / ' . $location['location_city'];
                                                    echo '</a>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="donations_issued">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php
                                            if (count($donations_issued) == 0) {
                                                echo 'No donations issued by this user.';
                                            } else {
                                                echo '<div class="list-group">';
                                                foreach ($donations_issued as $donation) {
                                                    echo '<div class="list-group-item">';

                                                    echo '<div class="row">';

                                                    echo '<div class="col-md-12">';
                                                    echo '<div class="well well-sm align-center">';
                                                    echo '<div class="countdown" data-time="' . strtotime($donation['date_expire']) . '"></div>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '</div>';

                                                    echo '<div class="row">';
                                                    echo '<div class="align-center col-md-12">';
                                                    echo '<a target="_blank" class="btn btn-md btn-info" href="admin/donations/edit?id=' . $donation['id'] . '">' . $donation['title'] . '</a>';
                                                    echo ' in ';
                                                    echo '<a target="_blank" class="btn btn-md btn-info" href="admin/locations/edit?id=' . $donation['location_id'] . '">' . $donation['location_data']['location_title'] . '</a>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '<br>';
                                                    echo '<div class="row">';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'Country : <strong>' . $donation['location_data']['location_country'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'State : <strong>' . $donation['location_data']['location_state'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'City : <strong>' . $donation['location_data']['location_city'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '</div>';

                                                    echo '<div class="row">';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'Quantity : <strong>' . $donation['quantity'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'Booked : <strong>' . $donation['quantity_booked'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '<div class="col-md-4">';
                                                    echo '<div class="well well-sm">';
                                                    echo 'Remain : <strong>' . $donation['quantity_remain'] . '</strong>';
                                                    echo '</div>';
                                                    echo '</div>';

                                                    echo '</div>';

                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="donations_taken">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php
                                            if (count($donations_used) == 0) {
                                                echo 'No donations taken or booked by this user.';
                                            } else {
                                                echo '<div class="list-group">';
                                                foreach ($donations_used as $donation) {
                                                    echo '<div class="list-group-item">';

                                                    echo '<div class="row">';
                                                    echo '<div class="align-center col-md-6">';
                                                    echo '<a target="_blank" class="btn btn-md btn-info" href="admin/donations/edit?id=' . $donation['id'] . '&tab=1">' . $donation['donation_title'] . ' x ' . $donation['quantity'] . '</a>';
                                                    echo ' in ';
                                                    echo '<a target="_blank" class="btn btn-md btn-info" href="admin/locations/edit?id=' . $donation['location_id'] . '">' . $donation['location_title'] . '</a>';
                                                    echo '</div>';

                                                    echo '<div class="align-center col-md-6">';
                                                    echo 'Booked at : <strong>' . $donation['date_booked'] . '</strong> UTC time';
                                                    echo '</div>';

                                                    echo '</div>';

                                                    echo '<br>';

                                                    echo '<div class="row">';
                                                    echo '  <div class="col-md-12">';
                                                    echo '      <div class="well well-sm align-center">';
                                                    if ($donation['delivered']) {
                                                        echo '<div class="align-center" style="color:green"><i class="fa fa-thumbs-o-up fa-2x"></i> <span style="font-size:1.5em">Taken</span></div>';
                                                    } else {
                                                        echo '<div class="countdown" data-time="' . strtotime($donation['date_expire']) . '"></div>';
                                                    }
                                                    echo '      </div>';
                                                    echo '  </div>';
                                                    echo '</div>';

                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($action == 'edit') { ?>
                        </div>   <!--closing tab content-->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="form_2" role="form" method="post" enctype="multipart/form-data">
    <input type="file" id="user_image" name="user-image" style="display: none;" onchange="document.getElementById('form_2').submit();"/>
</form>