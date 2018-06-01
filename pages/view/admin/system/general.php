<form method="post" id="form1">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Site general settings</h1>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <input type="submit" form="form1" value="Save" class="btn btn-default"/>
                <a href="admin/dashboard" class="btn btn-default">Return</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#social" data-toggle="tab">
                                    Social media
                                </a>
                            </li>
                            <li>
                                <a href="#distribution" data-toggle="tab">
                                    Distribution lists
                                </a>
                            </li>
                            <li>
                                <a href="#variables" data-toggle="tab">
                                    Variables
                                </a>
                            </li>
                            <li>
                                <a href="#apis" data-toggle="tab">
                                    APIs
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="social">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Social media links
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="contact_facebook" class="control-label col-lg-2">Facebook</label>
                                                        <div class="col-lg-10">
                                                            <input class="form-control" type="text" name="contact_facebook" id="contact_facebook" value="<?php echo $this->db_settings->get('contact_facebook', ''); ?>"/>
                                                            <span class="small-alert">
                                                                <?php
                                                                if (isset($errors['facebook'])) {
                                                                    foreach ($errors['facebook'] AS $error) {
                                                                        echo $this->showAlert($error);
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="contact_twitter" class="control-label col-lg-2">Twitter</label>
                                                        <div class="col-lg-10">
                                                            <input class="form-control" type="text" name="contact_twitter" id="contact_twitter" value="<?php echo $this->db_settings->get('contact_twitter', ''); ?>"/>
                                                            <span class="small-alert">
                                                                <?php
                                                                if (isset($errors['twitter'])) {
                                                                    foreach ($errors['twitter'] AS $error) {
                                                                        echo $this->showAlert($error);
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="contact_instagram" class="control-label col-lg-2">Instagram</label>
                                                        <div class="col-lg-10">
                                                            <input class="form-control" type="text" name="contact_instagram" id="contact_linkedin" value="<?php echo $this->db_settings->get('contact_instagram', '') ?>"/>
                                                            <span class="small-alert">
                                                                <?php
                                                                if (isset($errors['instagram'])) {
                                                                    foreach ($errors['instagram'] AS $error) {
                                                                        echo $this->showAlert($error);
                                                                    }
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="distribution">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="text-align: center">
                                                Distribution emails
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p>Add a list of emails, separated by comma. Those emails will receive all information submitted by the contact forms.</p>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="distribution_list" class="control-label col-lg-2">Emails</label>
                                                            <div class="col-lg-10">
                                                                <textarea rows="5" id="distribution_list" name="distribution_list" class="form-control"><?php echo $this->db_settings->get('distribution_list', ''); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="variables">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="foods_max_level" class="control-label">Food types tree levels allowed</label>
                                            <input min="2" type="number" class="form-control" id="foods_max_level" name="foods_max_level" value="<?php echo $this->db_settings->get('foods_max_level', 3); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="booking_time" class="control-label">Booking expiration time (hours)</label>
                                            <input min="1" max="12" type="number" class="form-control" id="booking_time" name="booking_time" value="<?php echo $this->db_settings->get('booking_time', 3); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="booking_radius" class="control-label">Distance for visible offers (km)</label>
                                            <input min="5" max="1000" type="number" class="form-control" id="booking_radius" name="booking_radius" value="<?php echo $this->db_settings->get('booking_radius', 30); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="booking_results_limit" class="control-label">Limit for search results</label>
                                            <input min="1" max="100" type="number" class="form-control" id="booking_results_limit" name="booking_results_limit" value="<?php echo $this->db_settings->get('booking_results_limit', 10); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="booking_limit" class="control-label">Booking limit per user (set zero for none)</label>
                                            <input min="0" max="50" type="number" class="form-control" id="booking_limit" name="booking_limit" value="<?php echo $this->db_settings->get('booking_limit', 0); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="apis">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Google maps</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="google_maps_api" class="control-label col-lg-2">Google Maps API</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" id="google_maps_api" name="google_maps_api" value="<?php echo $this->db_settings->get('google_maps_api', ''); ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><i class="fa fa-facebook-square fa-2x pull-right"></i> Facebook login</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="soc-login-facebook-enabled" class="control-label">Enabled</label>
                                                    <select id="soc-login-facebook-enabled" name="soc-login-facebook-enabled" class="form-control">
                                                        <option value="0" <?php echo ($this->db_settings->get('soc-login-facebook-enabled', 0) == 0) ? 'selected="selected"' : ''; ?>>No</option>
                                                        <option value="1" <?php echo ($this->db_settings->get('soc-login-facebook-enabled', 0) == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-facebook-client" class="control-label">Client id</label>
                                                    <input type="text" class="form-control" id="soc-login-facebook-client" name="soc-login-facebook-client" value="<?php echo $this->db_settings->get('soc-login-facebook-client', ''); ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-facebook-secret" class="control-label">Secret key</label>
                                                    <input type="text" class="form-control" id="soc-login-facebook-secret" name="soc-login-facebook-secret" value="<?php echo $this->db_settings->get('soc-login-facebook-secret', ''); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><i class="fa fa-twitter-square fa-2x pull-right"></i> Twitter login</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="soc-login-twitter-enabled" class="control-label">Enabled</label>
                                                    <select id="soc-login-twitter-enabled" name="soc-login-twitter-enabled" class="form-control">
                                                        <option value="0" <?php echo ($this->db_settings->get('soc-login-twitter-enabled', 0) == 0) ? 'selected="selected"' : ''; ?>>No</option>
                                                        <option value="1" <?php echo ($this->db_settings->get('soc-login-twitter-enabled', 0) == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-twitter-client" class="control-label">Client id</label>
                                                    <input type="text" class="form-control" id="soc-login-twitter-client" name="soc-login-twitter-client" value="<?php echo $this->db_settings->get('soc-login-twitter-client', ''); ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-twitter-secret" class="control-label">Secret key</label>
                                                    <input type="text" class="form-control" id="soc-login-twitter-secret" name="soc-login-twitter-secret" value="<?php echo $this->db_settings->get('soc-login-twitter-secret', ''); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><i class="fa fa-google-plus-square fa-2x pull-right"></i> Google+ login</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="soc-login-gplus-enabled" class="control-label">Enabled</label>
                                                    <select id="soc-login-gplus-enabled" name="soc-login-gplus-enabled" class="form-control">
                                                        <option value="0" <?php echo ($this->db_settings->get('soc-login-gplus-enabled', 0) == 0) ? 'selected="selected"' : ''; ?>>No</option>
                                                        <option value="1" <?php echo ($this->db_settings->get('soc-login-gplus-enabled', 0) == 1) ? 'selected="selected"' : ''; ?>>Yes</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-gplus-client" class="control-label">Client id</label>
                                                    <input type="text" class="form-control" id="soc-login-gplus-client" name="soc-login-gplus-client" value="<?php echo $this->db_settings->get('soc-login-gplus-client', ''); ?>"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="soc-login-gplus-secret" class="control-label">Secret key</label>
                                                    <input type="text" class="form-control" id="soc-login-gplus-secret" name="soc-login-gplus-secret" value="<?php echo $this->db_settings->get('soc-login-gplus-secret', ''); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>