<div class="header-spacer"></div>
<div class="error-wrapper">
    <?php
    if (isset($success_message)) {
        echo $this->showAlert($success_message, 'S');
    }
    ?>
</div>
<?php
if ($this->user) {
    ?>
    <section class="section-5 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="pdd-horizon-40">
                        <label class="profile-img" style="background-image: url(<?php echo $user['data']['profile_image'] . '?' . uniqid(); ?>)"></label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-white text-center-sm">
                        <h2 class="no-mrg-btm"><?php echo $user['screen_name']; ?></h2>
                        <p><?php echo $user['email']; ?></p>
                        <div class="mrg-top-40">
                            <h2>Donation details</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section class="section-2 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools">
                    <?php
                    if ($this->user) {
                        ?>
                        <h3>Actions</h3>
                    <?php } ?>
                    <div class="mrg-top-30">
                        <ul class="font-size-18">
                            <?php
                            if ($this->user) {
                                ?>
                                <?php if (isset($has_booked)) { ?>
                                    <li>
                                        <strong>You already booked this donation!</strong><br>
                                        You must get it in <span class="theme-color countdown" data-time="<?php echo $has_booked['time_remain']; ?>"></span> hours.<br>
                                        <br>
                                    </li>
                                    <li>
                                        <a href="donations/delete_booking?id=<?php echo $has_booked['id']; ?>" class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> Cancel my booking</a>
                                    </li>
                                <?php } else { ?>
                                    <?php if ($quantity_remain && (!$expired) && $can_book_now) { ?>
                                        <li class="mrg-btm-20">
                                            <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#new_booking"><i class="fa fa-gift"></i> BOOK NOW!</a>
                                        </li>
                                    <?php } ?>

                                <?php } ?>

                                <li class="mrg-btm-20">
                                    <a href="profile" class="btn btn-default btn-block"><i class="fa fa-reply"></i> Return to profile</a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <button class="btn btn-default btn-block" data-toggle="modal" data-target="#login">Login</button>
                                </li>
                                <li>
                                    <button class="btn btn-default btn-block" data-toggle="modal" data-target="#register">Register</button>
                                </li>
                            <?php } ?>                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="theme-color"><?php echo $title; ?></h2>
                        </div>
                        <div class="col-md-3">
                            <?php if (!isset($has_booked)) { ?>
                                <h2 class="align-center countdown" data-time="<?php echo $timer; ?>"></h2>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Food type :
                        </div>
                        <div class="col-md-9">
                            <strong><?php echo $food_types_selector; ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Remain :
                        </div>
                        <div class="col-md-9">
                            <strong><?php echo $quantity_remain; ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Description :
                        </div>
                        <div class="col-md-9">
                            <strong><?php echo $description; ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Dietary preferences : <span class="theme-color"><?php echo Array('None','Vegetarian','Vegan')[$preferences]; ?></span></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Allergy information</h3>
                        </div>
                    </div>
                    <div class="row allergy">
                        <?php
                        foreach ($this->config->allergies as $key => $value) {
                            ?>                                    
                            <label class="allergy<?php echo($allergy[$key] ? ' active' : ''); ?> allergy-<?php echo $key; ?>" title="<?php echo $value; ?>"></label>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Location data</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="location_display">
                                <div class="row">
                                    <?php if ($location_data['location_logo']) { ?>
                                        <div class="col-md-4 align-center" style="">
                                            <img class="img img-responsive" src="<?php echo $location_data['location_logo']; ?>" style="width : 100px;">
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-<?php echo (($location_data['location_logo'] == '') ? 12 : 8); ?>">
                                        <h3 style="overflow: hidden;display: block;max-height: 2em;"><?php echo $location_data['location_title']; ?></h3>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <strong>Type</strong><?php echo $location_type_name; ?><br>
                                        <strong>Address</strong><?php echo $location_data['location_address']; ?><br>
                                        <?php if ($location_data['location_phone']) { ?>
                                            <strong>Phone</strong><?php echo $location_data['location_phone']; ?><br>
                                        <?php } ?>
                                        <?php if ($location_data['location_mobile']) { ?>
                                            <strong>Mobile phone</strong><?php echo $location_data['location_mobile']; ?><br>
                                        <?php } ?>
                                        <?php if ($location_data['location_website']) { ?>
                                            <strong>Web site</strong><a type="btn btn-link" href="<?php echo $location_data['location_website']; ?>" target="_blank"><?php echo $location_data['location_website']; ?></a><br>
                                        <?php } ?>
                                        <?php if ($location_data['location_email']) { ?>
                                            <strong>E-mail</strong><?php echo $location_data['location_email']; ?><br>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="map-wrapper" data-lng="<?php echo $location_data['location_geo_lng']; ?>" data-lat="<?php echo $location_data['location_geo_lat']; ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section>

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
    #map-wrapper{
        margin-top: 32px;
        height: 300px;
        border: 1px solid #ccc;
        padding: 8px;
    }

</style>
<script>
    $(document).ready(function () {
        $('#expiry_hours').change(function () {
            $('#hours').html(this.value + ' h');
        });
        var map_wrapper = document.getElementById('map-wrapper');
        var map = new google.maps.Map(
                map_wrapper,
                {
                    center: {
                        lat: parseFloat(map_wrapper.dataset.lat),
                        lng: parseFloat(map_wrapper.dataset.lng)
                    },
                    disableDefaultUI: true,
                    zoom: 15
                });
        var marker = new google.maps.Marker({
            position: {
                lat: parseFloat(map_wrapper.dataset.lat),
                lng: parseFloat(map_wrapper.dataset.lng)
            },
            map: map
        });
    });

</script>