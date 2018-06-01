<div class="header-spacer"></div>

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
                            <h2>Location details</h2>
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
                                <li class="mrg-btm-20">
                                    <a href="profile" class="btn btn-default btn-block"><i class="fa fa-reply"></i> Return to profile</a>
                                </li>
                            <?php } else {?>
                                <li>
                                    <button class="btn btn-default btn-block" data-toggle="modal" data-target="#login">Login</button>
                                </li>
                                <li>
                                    <button class="btn btn-default btn-block" data-toggle="modal" data-target="#register">Register</button>
                                </li>
                            <?php } ?>
                            <?php if ($location_website) { ?>
                                <li>
                                    <a href="<?php echo $location_website; ?>" target="_blank" class="btn btn-link"><?php echo $location_website; ?></a>
                                </li>
                            <?php } ?>
                            <?php if ($location_email) { ?>
                                <li>
                                    <i class="fa fa-at"></i> <?php echo $location_email; ?>
                                </li>
                            <?php } ?>
                            <?php if ($location_phone) { ?>
                                <li>
                                    <i class="fa fa-phone"></i> <?php echo $location_phone; ?>
                                </li>
                            <?php } ?>
                            <?php if ($location_mobile) { ?>
                                <li>
                                    <i class="fa fa-mobile-phone"></i> <?php echo $location_mobile; ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php if ($location_image1 || $location_image2 || $location_image3) { ?>

                    <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools location-images">
                        <div class="swiper-single swiper-container static">
                            <div class="swiper-wrapper">
                                <?php if ($location_image1) { ?>
                                    <div class="swiper-slide">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img class="img-responsive img-centered" src="<?php echo $location_image1; ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($location_image2) { ?>
                                    <div class="swiper-slide">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img class="img-responsive img-centered" src="<?php echo $location_image2; ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($location_image3) { ?>
                                    <div class="swiper-slide">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img class="img-responsive img-centered" src="<?php echo $location_image3; ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="swiper-pagination swiper-bullet-1"></div>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <div class="col-md-8">
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <div class="row">
                        <div class="col-md-9">                            
                            <h2 class="theme-color"><?php echo $location_title; ?></h2>
                            <em><?php echo $types_selector; ?></em>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if ($location_logo) {
                                ?>
                                <img id="img_location_logo" class="img img-responsive" src="<?php echo $location_logo; ?>" style="width: 100px;height: 100px;"/>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            Country : <strong><?php echo $location_country; ?></strong>
                        </div>
                        <div class="col-md-4">
                            State : <strong><?php echo $location_state; ?></strong>
                        </div>
                        <div class="col-md-4">
                            City : <strong><?php echo $location_city; ?></strong>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $location_address; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="map-wrapper" data-lng="<?php echo $location_geo_lng; ?>" data-lat="<?php echo $location_geo_lat; ?>"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo $location_description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($active_donations)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card pdd-horizon-30 pdd-vertical-15">
                        <h3 class="theme-color">Currently active donations here</h3>
                        <hr>
                        <div class="row">
                            <?php foreach ($active_donations as $key => $value) { ?>
                                <div class="col-md-4">
                                    <a href="donations/view?id=<?php echo $key; ?>" class="theme-block align-center">
                                        <h3 class="theme-color-inverse-block"><?php echo $value['title']; ?></h3>
                                        <em><?php echo $value['quantity_remain']; ?> remain</em>
                                        <hr>
                                        <div class="countdown align-center" data-time="<?php echo strtotime($value['date_expire']); ?>"></div>
                                    </a>                                    
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>


<style>
    #map-wrapper{
        height: 300px;
        border: 1px solid #ccc;
        padding: 8px;
    }
</style>
<script>
    $(document).ready(function () {
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