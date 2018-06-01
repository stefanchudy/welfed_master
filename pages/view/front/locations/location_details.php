<div class="header-spacer"></div>
<div class="error-wrapper">
    <?php
    echo $this->showErrors('general');
    if (isset($success_message)) {
        echo $this->showAlert($success_message, 'S');
    }
    ?>
</div>
<section class="section-5 bg-dark">
    <div class="container">        
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="pdd-horizon-40">
                    <form method="post"  enctype="multipart/form-data" role="form" id="upload_image">
                        <label class="profile-img" style="background-image: url(<?php echo $user['data']['profile_image'] . '?' . uniqid(); ?>)"></label>
                    </form>                    
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-white text-center-sm">
                    <h2 class="no-mrg-btm"><?php echo $user['screen_name']; ?></h2>
                    <p><?php echo $user['email']; ?></p>
                    <div class="mrg-top-40">
                        <h2><?php echo isset($edit_mode) ? 'Edit' : 'Add new'; ?> location</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-2 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12 align-center">
                <p>In order to donate you need to register at least one location, where the donation can be picked.</p>
                <hr>
            </div>
            <div class="col-md-4">
                <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools">
                    <h3>Actions</h3>
                    <div class="mrg-top-30">
                        <ul class="font-size-18">
                            <li class="mrg-btm-20">
                                <a href="profile" class="btn btn-default btn-block"><i class="fa fa-reply"></i> Return to profile</a>
                            </li>
                            <li class="mrg-btm-20">
                                <button type="submit" form="form1" class="btn btn-info btn-type-add btn-block"><i class="fa fa-floppy-o"></i> Save</button>
                            </li>
                            <?php if (isset($edit_mode)) { ?>
                                <li class="mrg-btm-20">                                                                            
                                    <?php if ($location_verified) { ?>
                                        <a href="<?php echo 'donations/add?location_id=' . $id; ?>" class="btn btn-success btn-block"><i class="fa fa-gift"></i> Add donation</a>
                                    <?php } else { ?>
                                        Status <span class="theme-color">Pending verification</span>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <form id="form1" role="form" method="post" class="form-horizontal" enctype='multipart/form-data'>
                        <fieldset>
                            <legend>General data</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_title" class="col-md-2 control-label">Title</label>
                                        <div class="col-md-10">
                                            <input type="text" id="location_title" name="location_title" class="form-control" value="<?php echo isset($location_title) ? $location_title : ''; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_title');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_type" class="control-label col-md-2">Location type : </label>
                                        <div class="col-md-10">
                                            <?php echo $types_selector; ?>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_type');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label for="location_description" class="control-label">Short description</label>
                                        <textarea rows="6" class="form-control" id="location_description" name="location_description"><?php echo (isset($location_description) ? $location_description : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Location</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_country">Country</label>
                                        <input type="text" readonly="readonly" id="location_country" name="location_country" class="form-control" value="<?php echo isset($location_country) ? $location_country : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_state">State</label>
                                        <input type="text" readonly="readonly" id="location_state" name="location_state" class="form-control" value="<?php echo isset($location_state) ? $location_state : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_city">City</label>
                                        <input type="text" readonly="readonly" id="location_city" name="location_city" class="form-control" value="<?php echo isset($location_city) ? $location_city : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_zip">Zip code</label>
                                        <input type="text" readonly="readonly" id="location_zip" name="location_zip" class="form-control" value="<?php echo isset($location_zip) ? $location_zip : ''; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_address">Street address</label>
                                        <input type="text" readonly="readonly" id="location_address" name="location_address" class="form-control" value="<?php echo isset($location_address) ? $location_address : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_geo_lat">Latitude</label>
                                        <input type="text" readonly="readonly" id="location_geo_lat" name="location_geo_lat" class="form-control" value="<?php echo isset($location_geo_lat) ? $location_geo_lat : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin : 0px 8px;">
                                        <label class="control-label" for="location_geo_lng">Longitude</label>
                                        <input type="text" readonly="readonly" id="location_geo_lng" name="location_geo_lng" class="form-control" value="<?php echo isset($location_geo_lng) ? $location_geo_lng : ''; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button id="btn_show_map" type="button" class="btn btn-block btn-info btn-lg">
                                        <i class="fa fa-map-marker"></i> Click to choose location on the map
                                    </button>
                                    <span class="small-alert">
                                        <?php
                                        echo $this->showErrors('address_components');
                                        ?>
                                    </span>
                                </div>
                            </div>                    
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Contact information</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_website" class="control-label col-md-2">Web site: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="location_website" id="location_website" class="form-control" value="<?php echo isset($location_website) ? $location_website : ''; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_website');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_email" class="control-label col-md-2">E-Mail: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="location_email" id="location_email" class="form-control" value="<?php echo isset($location_email) ? $location_email : ''; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_email');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_phone" class="control-label col-md-2">Phone: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="location_phone" id="location_phone" class="form-control" value="<?php echo isset($location_phone) ? $location_phone : ''; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_phone');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location_mobile" class="control-label col-md-2">Mobile phone: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="location_mobile" id="location_mobile" class="form-control" value="<?php echo isset($location_mobile) ? $location_mobile : ''; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_mobile');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php if (isset($edit_mode)) { ?>
                            <fieldset>
                                <legend>Images</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>Location logo</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="align-center">
                                                    <label for="location_logo" style="cursor: pointer">
                                                        <img id="img_location_logo" class="img img-responsive" src="<?php echo ($location_logo ? $location_logo : $logo_placeholder); ?>" style="width: 200px;height: 200px;"/>
                                                    </label>
                                                    <input type="file" name="location_logo" id="location_logo" style="display: none" data-toggle="upload_image" data-target="img_location_logo"/>
                                                </div>
                                            </div>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_logo');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>Image 1</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="align-center">
                                                    <label for="location_image1" style="cursor: pointer">
                                                        <img id="img_location_image1" class="img img-responsive" src="<?php echo ($location_image1 ? $location_image1 : $image_placeholder); ?>" style="width: 300px;height: 200px;"/>
                                                    </label>
                                                    <input type="file" name="location_image1" id="location_image1" style="display: none" data-toggle="upload_image" data-target="img_location_image1"/>
                                                </div>
                                            </div>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_image1');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>Image 2</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="align-center">
                                                    <label for="location_image2" style="cursor: pointer">
                                                        <img id="img_location_image2" class="img img-responsive" src="<?php echo ($location_image2 ? $location_image2 : $image_placeholder); ?>" style="width: 300px;height: 200px;"/>
                                                    </label>
                                                    <input type="file" name="location_image2" id="location_image2" style="display: none" data-toggle="upload_image" data-target="img_location_image2"/>
                                                </div>
                                            </div>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_image2');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4>Image 3</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="align-center">
                                                    <label for="location_image3" style="cursor: pointer">
                                                        <img id="img_location_image3" class="img img-responsive" src="<?php echo ($location_image3 ? $location_image3 : $image_placeholder); ?>" style="width: 300px;height: 200px;"/>
                                                    </label>
                                                    <input type="file" name="location_image3" id="location_image3" style="display: none" data-toggle="upload_image" data-target="img_location_image3"/>
                                                </div>
                                            </div>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('location_image3');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>



                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function () {
        map = new LocationsMap;
        map.run(<?php echo isset($map_options) ? $map_options : ''; ?>);

        $('input[data-toggle="upload_image"]').change(function () {
            if (this.files && this.files[0]) {
                document.getElementById(this.dataset.target).src = URL.createObjectURL(this.files[0]);
            }

        });
    });
</script>