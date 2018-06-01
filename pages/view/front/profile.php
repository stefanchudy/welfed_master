<div class="header-spacer"></div>
<div class="error-wrapper">
    <?php
    echo $this->showErrors('general');
    if (isset($success_message)) {
        echo $this->showAlert($success_message, 'S');
    }
    ?>
</div>
<!-- Page Tittle Start -->
<section class="section-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="pdd-horizon-40">
                    <form method="post"  enctype="multipart/form-data" role="form" id="upload_image">
                        <label class="profile-img" style="background-image: url(<?php echo $profile_image . '?' . uniqid(); ?>)">
                            <input type="file" style="display:none" name="user_image" id="user_image"  onchange="document.getElementById('upload_image').submit();"/>
                        </label>
                    </form>                    
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-white text-center-sm">
                    <h2 class="no-mrg-btm"><?php echo $full_name; ?></h2>
                    <p><?php echo $user_profile['email']; ?></p>
                    <div class="mrg-top-40">
                        <label for="user_image" class="btn btn-md border-radius-6 btn-theme mrg-right-10">Upload image</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Tittle End -->

<!-- My Account Start -->
<section class="section-2 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools">
                    <h3>Tools</h3>
                    <div class="mrg-top-30">
                        <ul class="font-size-18">
                            <li class="mrg-btm-20 <?php echo (($tab == 0) ? ' active' : ''); ?>">
                                <a class="text-gray" data-toggle="tab" href="#general"><i class="fa fa-user mrg-right-10 theme-color"></i> Personal details</a>
                            </li>
                            <li class="mrg-btm-20 <?php echo (($tab == 1) ? ' active' : ''); ?>">
                                <a class="text-gray" data-toggle="tab" href="#change_password"><i class="fa fa-lock mrg-right-10 theme-color"></i> Change password</a>
                            </li>
                            <li class="mrg-btm-20 <?php echo (($tab == 2) ? ' active' : ''); ?>">
                                <a class="text-gray" data-toggle="tab" href="#locations"><i class="fa fa-map-marker mrg-right-10 theme-color"></i> My locations</a>
                            </li>
                            <li class="mrg-btm-20 <?php echo (($tab == 3) ? ' active' : ''); ?>">
                                <a class="text-gray" data-toggle="tab" href="#donations_issued"><i class="fa fa-gift mrg-right-10 theme-color"></i> Issued donations</a>
                            </li>                                

                            <?php if ($user['data']['advanced'] || $is_admin) { ?>
                                <li class="mrg-btm-20 <?php echo (($tab == 5) ? ' active' : ''); ?>">
                                    <a class="text-gray" data-toggle="tab" href="#donations_taken"><i class="fa fa-cutlery mrg-right-10 theme-color"></i> Taken donations</a>
                                </li>
                            <?php } else { ?>
                                <?php if ($user_profile['data']['upgrade_application'] != 2) { ?>
                                    <li class="mrg-btm-20 <?php echo (($tab == 4) ? ' active' : ''); ?>">
                                        <a class="text-gray" data-toggle="tab" href="#account_upgrade"><i class="fa fa-caret-square-o-up mrg-right-10 theme-color"></i> Upgrade my account</a>
                                    </li>
                                <?php } ?>
                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content">
                    <div class="tab-pane  <?php echo (($tab == 0) ? ' active' : ''); ?>" id="general">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <form id="form_general" role="form" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <legend>Personal details</legend>
                                    <div class="form-group">
                                        <label for="profile_detail_first_name" class="control-label">First name</label>
                                        <input type="text" class="form-control" name="profile[first_name]" id="profile_detail_first_name" placeholder="First name" value="<?php echo $user_profile['data']['first_name']; ?>"/>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('first_name');
                                            ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_detail_last_name" class="control-label">Last name</label>
                                        <input type="text" class="form-control" name="profile[last_name]" id="profile_detail_last_name" placeholder="Last name" value="<?php echo $user_profile['data']['last_name']; ?>"/>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('last_name');
                                            ?>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_detail_mobile_phone" class="control-label">Mobile phone</label>
                                        <input type="text" class="form-control" name="profile[mobile_phone]" id="profile_detail_mobile_phone" placeholder="Mobile phone" value="<?php echo $user_profile['data']['mobile_phone']; ?>"/>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('mobile_phone');
                                            ?>
                                        </span>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Dietary preference</legend>
                                    <div class="form-group">
                                        <label for="profile_preferences" class="control-label">Select dietary preferences</label>
                                        <select id="profile_preferences" name="profile[preferences]" class="form-control">
                                            <option <?php echo ($user_profile['data']['preferences'] == 0) ? 'selected="selected"' : ''; ?> value="0">No dietary preference</option>
                                            <option <?php echo ($user_profile['data']['preferences'] == 1) ? 'selected="selected"' : ''; ?> value="1">Vegetarian</option>
                                            <option <?php echo ($user_profile['data']['preferences'] == 2) ? 'selected="selected"' : ''; ?> value="2">Vegan</option>
                                        </select>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Allergies</legend>

                                    <?php
                                    foreach ($this->config->allergies as $key => $value) {
                                        ?>                                    
                                        <input type="hidden" name="profile[allergy][<?php echo $key; ?>]" value="0"/>
                                        <input class="allergy" id="<?php echo 'allergy-' . $key; ?>" type="checkbox" name="profile[allergy][<?php echo $key; ?>]" value="1" <?php echo($allergy[$key] ? ' checked="checked"' : ''); ?>/>                                    
                                        <label for="<?php echo 'allergy-' . $key; ?>" class="allergy allergy-<?php echo $key; ?>" title="<?php echo $value; ?>"></label>
                                        <?php
                                    }
                                    ?>
                                </fieldset>
                                <br>
                                <input type="submit" class="btn btn-md border-radius-6 btn-theme mrg-right-10" value="Save changes"/>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (($tab == 1) ? ' active' : ''); ?>" id="change_password">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <form method="post" role="form">
                                <div class="form-group">
                                    <label for="change_password1" class="control-label">Enter new password</label>
                                    <input type="password" class="form-control" name="change[pass1]" id="change_password1" placeholder="Enter new password"/>
                                    <span class="small-alert">
                                        <?php
                                        echo $this->showErrors('pass1');
                                        ?>
                                    </span>
                                </div>
                                <div class="form-group">                                
                                    <label for="change_password2" class="control-label">Repeat the password</label>
                                    <input type="password" class="form-control" name="change[pass2]" id="change_password2" placeholder="Repeat the password"/>
                                    <span class="small-alert">
                                        <?php
                                        echo $this->showErrors('pass2');
                                        ?>
                                    </span>
                                </div>
                                <input type="submit" class="btn btn-md border-radius-6 btn-theme mrg-right-10" value="Save changes"/>
                            </form>

                        </div>
                    </div>
                    <div class="tab-pane <?php echo (($tab == 2) ? ' active' : ''); ?>" id="locations">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="locations/add" class="btn btn-block btn-theme"><i class="fa fa-plus-circle"></i> Add new location</a>
                                </div>
                            </div>
                            <?php foreach ($user_profile['locations'] as $location_id => $location) { ?>
                                <a href="locations/edit?id=<?php echo $location_id; ?>" class="location-block">
                                    <img src="<?php echo $location['location_logo']; ?>"/>
                                    <h2><?php echo $location['location_title']; ?></h2>
                                    <p><?php echo $location['location_city'] . ' ' . $location['location_state'] . ' ' . $location['location_country']; ?></p>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (($tab == 3) ? ' active' : ''); ?>" id="donations_issued">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <?php if ($user_profile['active_locations']) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="donations/add" class="btn btn-block btn-theme"><i class="fa fa-plus-circle"></i> Add new donation</a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if (count($user_profile['donations_issued']) == 0) {
                                echo 'No donations issued by this user.';
                            } else {
                                echo '<div class="table-responsive">';
                                echo '<table class="table table-stripped table-bordered table-hover table-condensed">';
                                echo '<tr>';
                                echo '<th>Donation</th>';
                                echo '<th>Location data</th>';
                                echo '<th>Quantity</th>';
                                echo '<th>Expiration</th>';
                                echo '</tr>';
                                foreach ($user_profile['donations_issued'] as $donation) {
                                    echo '<tr>';

                                    echo '<td>' . '<a target="_blank" class="btn btn-xs btn-default btn-list" href="donations/edit?id=' . $donation['id'] . '"><i class="fa fa-gift theme-color"></i> ' . $donation['title'] . '</a><br><a target="_blank" class="btn btn-xs btn-default btn-list" href="locations/edit?id=' . $donation['location_id'] . '"><i class="fa fa-map-marker theme-color"></i> ' . $donation['location_data']['location_title'] . '</a>' . '</td>';
                                    echo '<td>' . $donation['location_data']['location_country'] . ' ' . $donation['location_data']['location_state'] . ' ' . $donation['location_data']['location_city'] . '</td>';
                                    echo '<td>Issued : ' . $donation['quantity'] . '<br>Booked : ' . $donation['quantity_booked'] . '<hr>Remain : ' . $donation['quantity_remain'] . '</td>';
                                    echo '<td>';
                                    echo '<div class="countdown" data-time="' . strtotime($donation['date_expire']) . '"></div><br>';
                                    echo '<a href="donations/delete?id=' . $donation['id'] . '" class="btn btn-danger btn-xs btn-list btn-delete">Delete</a>';
                                    echo '</td>';

                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo '</div>';
                            }
                            ?>

                        </div>
                    </div>
                    <div class="tab-pane <?php echo (($tab == 4) ? ' active' : ''); ?>" id="account_upgrade">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <?php if (!$user_profile['data']['upgrade_application']) { ?>
                                <h3>Upgrade your account</h3>
                                <br>
                                <p>By upgrading your account you will become volunteer, and you will be able to book and pick up donations.</p>
                                <p>To do that you need to apply by clicking the button below. We will review your application and get back to you shortly.</p>
                                <hr>
                                <form method="post" role="form" id="application_form">                                    
                                    <div class="form-group">
                                        <label for="accept_terms">
                                            <input type="hidden" name="apply[accept_terms]" value="0"/>
                                            <input type="checkbox" id="accept_terms" name="apply[accept_terms]" value="1" <?php echo ((isset($accept_terms) && ($accept_terms == 1)) ? 'checked="checked"' : ''); ?>/>
                                            I understand the 
                                            <a href="food-donation-agreement" target="_blank"><b class="theme-color">Food Donation Agreement</b></a> and 
                                            <a href="food-safety-and-hygiene" target="_blank"><b class="theme-color">Food Safety and Hygiene Policy</b></a> on this website, 
                                            and understand I am waiving any right to place any liability for the donations received or donated on either the donor, the receiver or Well Fed Foundation or any other intermediary.
                                        </label>
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('accept_terms');
                                            ?>
                                        </span>
                                    </div>
                                    <input type="submit" class="btn btn-md border-radius-6 btn-theme mrg-right-10" value="Apply"/>
                                </form>
                            <?php } else { ?>
                                <h3>Your application is received</h3>
                                <p>You have applied to upgrade your account and become volunteer. Thank you for trying make the world better place.</p>
                                <p>We will contact you soon.</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane <?php echo (($tab == 5) ? ' active' : ''); ?>" id="donations_taken">
                        <div class="card pdd-horizon-30 pdd-vertical-15">
                            <?php
                            $donations_used = $user_profile['donations_used'];
                            if (count($donations_used) == 0) {
                                echo 'No donations taken or booked by this user.';
                            } else {
                                echo '<div class="table-responsive">';
                                echo '<table class="table table-stripped table-bordered table-hover table-condensed">';
                                echo '<tr>';
                                echo '<th>Donation</th>';
                                echo '<th>Booking time (UTC)</th>';
                                echo '<th>Status</th>';
                                echo '</tr>';
                                foreach ($donations_used as $donation) {
                                    echo '<tr>';
                                    echo '<td>' . '<a target="_blank" class="btn btn-xs btn-default btn-list" href="donations/edit?id=' . $donation['id'] . '"><i class="fa fa-gift theme-color"></i> ' . $donation['donation_title'] . ' x ' . $donation['quantity'] . '</a><br><a target="_blank" class="btn btn-xs btn-default btn-list" href="locations/edit?id=' . $donation['location_id'] . '"><i class="fa fa-map-marker theme-color"></i> ' . $donation['location_title'] . '</a>' . '</td>';
                                    echo '<td>' . $donation['date_booked'] . '</td>';
                                    echo '<td>';
                                    if ($donation['delivered']) {
                                        echo '<div class="align-center" style="color:green"><i class="fa fa-thumbs-o-up fa-2x"></i> <span style="font-size:1.5em">Taken</span></div>';
                                    } else {
                                        echo '<div class="countdown" data-time="' . strtotime($donation['date_expire']) . '"></div>';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- My Account End -->