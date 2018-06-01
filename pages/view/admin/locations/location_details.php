<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo isset($edit_mode) ? 'Edit' : 'Add new'; ?> location</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <form id="form1" role="form" method="post" class="form-horizontal" enctype='multipart/form-data'>
            <div class="panel-heading">
                <button type="submit" class="btn btn-info btn-type-add"><i class="fa fa-floppy-o"></i> Save</button>
                <a href="admin/locations" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
                <?php if (isset($edit_mode)) { ?>
                    <span class="pull-right">
                        <?php
                        if ($location_verified) {
                            echo '<a href="admin/donations/add?location_id='.$id.'" class="btn btn-success">Add donation</a>';
                        }
                        ?>
                        <a href="admin/locations/verify?id=<?php echo $id; ?>" class="btn btn-default" title="Click to change the status">
                            Status : 
                            <strong>
                                <?php
                                if ($location_verified) {
                                    echo 'Verified <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
                                } else {
                                    echo 'Not Verified <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>';
                                }
                                ?>
                            </strong>
                        </a>
                    </span>
                <?php } ?>
            </div>
            <div class="panel-body">
                <?php if (isset($edit_mode)) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#common_data" data-toggle="tab">
                                        Location data
                                    </a>
                                </li>
                                <li>
                                    <a href="#images" data-toggle="tab">
                                        Images
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($edit_mode)) { ?>
                    <div class="tab-content">
                        <div class="tab-pane active" id="common_data">
                        <?php } ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_id" class="control-label col-md-4">Managed by user: </label>
                                                <div class="col-md-8">
                                                    <?php echo $user_selector; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location_type" class="control-label col-md-4">Location type : </label>
                                                <div class="col-md-8">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location_website" class="control-label col-md-4">Web site: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="location_website" id="location_website" class="form-control" value="<?php echo isset($location_website) ? $location_website : ''; ?>"/>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('location_website');
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location_email" class="control-label col-md-4">E-Mail: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="location_email" id="location_email" class="form-control" value="<?php echo isset($location_email) ? $location_email : ''; ?>"/>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('location_email');
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location_phone" class="control-label col-md-4">Phone: </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="location_phone" id="location_phone" class="form-control" value="<?php echo isset($location_phone) ? $location_phone : ''; ?>"/>
                                                    <span class="small-alert">
                                                        <?php
                                                        echo $this->showErrors('location_phone');
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location_mobile" class="control-label col-md-4">Mobile phone: </label>
                                                <div class="col-md-8">
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
                                <hr>
                            </div>
                        </div>
                        <?php if (isset($edit_mode)) { ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($edit_mode)) { ?>
                        <div class="tab-pane" id="images">
                            <div class="panel panel-default">
                                <div class="panel-body">
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
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<div class="modal fade in" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">    
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_label">Search a location</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="search_block">
                    <label for="search_address" class="control-label">Enter address to search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_address"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btn_decode" type="button">Locate</button>
                        </span>
                    </div>
                </div>
                <div id="map_wrapper" style="display:none;">
                    <div class="form-group" id="result_selector_group">
                        <label for="result_selector" class="control-label">Pick the best match from <span class="label label-default" id="result_count">XXX</span> result(s)</label>
                        <select class="form-control" id="result_selector">                            
                        </select>
                    </div>
                    <div class="row address-decoded">
                        <div class="col-md-3">
                            Country
                            <span id="decoded_country">test</span>
                        </div>
                        <div class="col-md-3">
                            State
                            <span id="decoded_state"></span>
                        </div>
                        <div class="col-md-3">
                            City
                            <span id="decoded_city"></span>
                        </div>
                        <div class="col-md-3">
                            Zip code
                            <span id="decoded_zip"></span>
                        </div>
                    </div>
                    <div class="row address-decoded">
                        <div class="col-md-6">
                            Street address
                            <span id="decoded_address"></span>
                        </div>
                        <div class="col-md-3">
                            Latitude
                            <span id="decoded_geo_lat"></span>
                        </div>
                        <div class="col-md-3">
                            Longitude
                            <span id="decoded_geo_lng"></span>
                        </div>
                    </div>
                    <br>
                    <div id="map_holder"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="lock_address" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var map = new LocationsMap;
        map.run(<?php echo isset($map_options) ? $map_options : ''; ?>);

        $('input[data-toggle="upload_image"]').change(function () {
            if (this.files && this.files[0]) {
                document.getElementById(this.dataset.target).src = URL.createObjectURL(this.files[0]);
            }

        });
    });
</script>
<style>
    #map_wrapper #map_holder{
        max-height: 300px;
    }
    .address-decoded>div>span{
        display: block;
        color: navy;
        border: 1px solid #777;
        background-color: #aaa;
        color: white;
        padding: 4px;
        min-height: 30px;
    }
    .address-decoded>div>span[data-required="false"]{
        border-color: red;
    }
</style>