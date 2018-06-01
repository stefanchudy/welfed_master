<div class="header-spacer"></div>
<section class="section-2 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="heading-1 text-center">Search for <span class="theme-color">Donations</span></h1>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools">                   
                    <div class="mrg-top-30">
                        <ul class="font-size-18">
                            <li class="mrg-btm-20">
                                <a href="profile" class="btn btn-default btn-block"><i class="fa fa-reply"></i> Return to profile</a>
                            </li>
                            <li class="mrg-btm-20">
                                <button id="center_map" style="display: none;" type="button" class="btn btn-default btn-block"><i class="fa fa-street-view"></i> Center map on me</button>
                            </li>
                            <li class="mrg-btm-20">
                                <h4>Dietary preferences</h4>
                                <select id="preferences" class="form-control">
                                    <option value="0" <?php echo ($preferences==0)?'selected="selected"':''; ?>>No dietary preferences</option>
                                    <option value="1" <?php echo ($preferences==1)?'selected="selected"':''; ?>>Vegetarian</option>
                                    <option value="2" <?php echo ($preferences==2)?'selected="selected"':''; ?>>Vegan</option>
                                </select>
                            </li>
                            <li class="mrg-btm-20">
                                <h4>Allergen filter</h4>
                                <div class="row allergy allergy-small">
                                    <?php
                                    foreach ($this->config->allergies as $key => $value) {
                                        ?>                                    
                                        <input class="allergy" data-id="<?php echo $key; ?>" id="<?php echo 'allergy-' . $key; ?>" type="checkbox" <?php echo($allergy[$key] ? ' checked="checked"' : ''); ?>/>                                    
                                        <label for="<?php echo 'allergy-' . $key; ?>" class="allergy allergy-<?php echo $key; ?>" title="<?php echo $value; ?>"></label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </li>
                            <li class="mrg-btm-20">
                                <button id="search_donation" type="button" class="btn btn-theme btn-block"><i class="fa fa-search"></i> Search again</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card pdd-horizon-30 pdd-vertical-15 border-radius-6 tools">
                    <h3>See other locations</h3>
                    <div class="city_list">
                        <?php
                        if (count($city_list)) {
                            foreach ($city_list as $country => $cities) {
                                echo '<div class="country">';
                                echo '<h4>' . $country . '</h4>';
                                foreach ($cities as $city => $data) {
                                    echo '<span class="city" title="'.$data['count'].' donations" data-lng="'.$data['lng'].'" data-lat="'.$data['lat'].'">';
                                    echo $city;
                                    echo '</span>';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <div class="row">
                        <div class="col-sm-6">
                            Search radius : <strong id="search_radius"></strong> km
                        </div>
                        <div class="col-sm-6">
                            Results found : <strong id="search_results"></strong>
                        </div>
                    </div>
                </div>
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <div id="map_wrapper"></div>
                </div>
                <div class="card pdd-horizon-30 pdd-vertical-15">
                    <h4>Tips</h4>
                    <hr>
                    <p>Click on the "Search again" button to refresh the search.</p>
                    <p>Re-center the map and click on the "Search again" button to search within the new center.</p>
                    <p>Click on the allergen icons to toggle on/off the specific allergen excluding from the search results.</p>
                    <p>Drag and drop the user marker <img src="img/user_marker.png"> to re-center the search.</p>
                    <p>Click on the red markers to see the donation details, then click on the green "Book now" button to book for yourself.</p>
                </div>
            </div>
        </div>
    </div>
</section>
