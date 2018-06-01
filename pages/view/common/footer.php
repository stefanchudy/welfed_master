</div><!-- wrapper -->

<!-- Footer Start -->
<section class="footer-default">
    <div class="container">
        <div class="row mrg-btm-30">
            <div class="col-md-3">
                <div class="widget widget-about">
                    <img class="img-responsive" src="assets/images/logo/logo-1.png" alt="">
                    <p class="mrg-top-30">Join our growing network of restaurants, donors, charities, volunteers, or simply donate what you can, small or large, and help us create a sustainable change today.</p>
                </div><!-- /widget-about -->
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="widget widget-link">
                    <h3 class="widget-tittle">Explore our website</h3>
                    <div class="row mrg-btm-30">
                        <div class="col-md-6">
                            <ul class="link">
                                <li><a href="">Home</a></li>
                                <li><a href="about">About</a></li>                                
                                <li><a href="contact">Contact</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">                            
                            <ul class="link">
                                <li id='blog'><a href="blog">Our blog</a></li>
                                <?php if (($this->user && $this->user['data']['advanced'] || $this->user['active_locations']) || ($this->user['is_admin'])) { ?>
                                    <li><a href="/donations/add">Donate</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="widget widget-link">
                    <h3 class="widget-tittle">Legal documents</h3>
                    <div class="row mrg-btm-30">
                        <div class="col-md-12">                            
                            <ul class="link">
                                <?php foreach ($this->config->legal as $k => $v) { ?>
                                    <li><a href="<?php echo $k; ?>"><?php echo $v; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <span class="copyright">
                <img style="width:100px;height: auto;" class="logo-dark" src="img/logo_transp_white.png" alt="Well fed foundation">
            </span>
            <span class="pull-right">Registered Charity No: <strong>1167863</strong></span>
        </div>
    </div>
</section>
<!-- Footer End -->
<!-- Modal Start Login-->        
<div class="modal fade modal-center <?php echo (isset($this->errors['login_form']) ? 'load-active' : ''); ?>" id="login" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body no-pdd">
                <div class="login-panel">
                    <div class="content-block-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-7 col-md-offset-5">
                                    <div class="text-content pdd-horizon-60">
                                        <h3 class="mrg-btm-30 mrg-top-15">Sign In</h3>
                                        <form method="post">
                                            <div class="form-wrapper">
                                                <label><b>User Name</b></label>
                                                <input type="text" class="form-control" placeholder="Username" name="login_form[username]">
                                            </div>
                                            <div class="form-wrapper">
                                                <label><b>Password</b></label>
                                                <input type="password" class="form-control" placeholder="Password" name="login_form[password]">
                                                <span class="small-alert">
                                                    <?php
                                                    echo $this->showErrors('login_form');
                                                    ?>
                                                </span>
                                            </div>
                                            <div>
                                                <a href="forgotten_password"><i class="text-gray">Forgot Password ?</i></a>
                                            </div>
                                            <input class="btn btn-md btn-theme mrg-vertical-20" type="submit" value="Sign in">
                                        </form>
                                        <div class="align-center">
                                            <ul class="social-btn mrg-top-30">
                                                <?php if ($this->db_settings->get('soc-login-facebook-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-facebook border-radius-round" href="social-login?provider=Facebook">
                                                            <i class="ei ei-facebook"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($this->db_settings->get('soc-login-twitter-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-twitter border-radius-round" href="social-login?provider=Twitter">
                                                            <i class="ei ei-twitter"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($this->db_settings->get('soc-login-gplus-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-google-plus border-radius-round" href="social-login?provider=Google">
                                                            <i class="ei ei-google-plus"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div><!-- /content -->

                                </div>
                            </div>
                        </div>  
                        <div class="image-container col-md-5 hidden-xs hidden-sm">
                            <div class="background-holder theme-overlay has-content" style="background-image:url(assets/images/bg-18.jpg)">
                                <div class="content pdd-horizon-50">
                                    <img class="img-responsive mrg-btm-20" src="img/logo_transp_white.png" alt="">
                                    <h3 class="mrg-btm-20 text-white">No account? Register Now!</h3>                                            
                                    <button class="btn btn-sm btn-block btn-white-inverse mrg-vertical-20 login_to_register">Register</button>                                    
                                </div><!-- content -->
                            </div><!-- /background-holder -->
                        </div><!-- /image-container -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End Login -->

<!-- Modal Start register -->
<!-- use data-backdrop="static" & data-keyboard="false" to lock modal -->
<div class="modal fade modal-center <?php echo (isset($this->errors['register']) ? 'load-active' : ''); ?>" id="register" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body no-pdd">
                <div class="login-panel">
                    <div class="content-block-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-7 col-md-offset-5">
                                    <div class="text-content pdd-horizon-60 pdd-vertical-60">
                                        <h3 class="mrg-btm-30 mrg-top-15">Register</h3>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-md-12 pdd-horizon-5">                                                    
                                                    <div class="form-wrapper">
                                                        <label><b>Email</b></label>
                                                        <input type="email" class="form-control" name="register[email]" placeholder="Email" value="<?php echo isset($this->input->post['register']['email']) ? $this->input->post['register']['email'] : ''; ?>">
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('email');
                                                            ?>
                                                        </span>
                                                    </div>	
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label><b>First Name</b></label>
                                                        <input type="text" class="form-control" name="register[first_name]" placeholder="First Name" value="<?php echo isset($this->input->post['register']['first_name']) ? $this->input->post['register']['first_name'] : ''; ?>">
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('first_name');
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label><b>Last Name</b></label>
                                                        <input type="text" class="form-control" name="register[last_name]" placeholder="Last Name" value="<?php echo isset($this->input->post['register']['last_name']) ? $this->input->post['register']['last_name'] : ''; ?>">
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('last_name');
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label><b>Phone</b></label>
                                                        <input type="text" class="form-control"  name="register[mobile_phone]" placeholder="Phone number" value="<?php echo isset($this->input->post['register']['mobile_phone']) ? $this->input->post['register']['mobile_phone'] : ''; ?>">
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('mobile_phone');
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label><b>Password</b></label>
                                                        <input type="password" class="form-control" name="register[password]" placeholder="password">
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('password');
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label><b>Retype Password</b></label>
                                                        <input type="password" class="form-control" name="register[password2]" placeholder="Retype Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pdd-horizon-5">
                                                    <div class="form-wrapper">
                                                        <label>
                                                            <input type="hidden" name="register[legal]" value="0"/>
                                                            <input type="checkbox" name="register[legal]" value="1"/>
                                                            I understand the 
                                                            <a href="food-recipient-agreement" target="_blank"><b class="theme-color">Food Recipient Agreement</b></a>, 
                                                            <a href="food-donation-agreement" target="_blank"><b class="theme-color">Food Donation Agreement</b></a>, 
                                                            <a href="terms-of-website" target="_blank"><b class="theme-color">Terms of Website Use</b></a> and the 
                                                            <a href="privacy-policy" target="_blank"><b class="theme-color">Site Privacy Policy</b></a>, 
                                                            and understand I am waiving any right to place any liability for the donations received or donated on either the donor, the receiver or Well Fed Foundation
                                                        </label>
                                                        <span class="small-alert">
                                                            <?php
                                                            echo $this->showErrors('legal');
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mrg-top-10">
                                                <div class="col-md-12 pdd-horizon-5">
                                                    <div class="form-wrapper">	                                                        
                                                        <input class="btn btn-md btn-dark pull-right" type="submit" value="Sign Up">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="align-center">
                                            <ul class="social-btn mrg-top-30">
                                                <?php if ($this->db_settings->get('soc-login-facebook-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-facebook border-radius-round" href="social-login?provider=Facebook">
                                                            <i class="ei ei-facebook"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($this->db_settings->get('soc-login-twitter-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-twitter border-radius-round" href="social-login?provider=Twitter">
                                                            <i class="ei ei-twitter"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($this->db_settings->get('soc-login-gplus-enabled', 0) == 1) { ?>
                                                    <li>
                                                        <a class="btn icon-btn-md btn-theme-inverse hover-google-plus border-radius-round" href="social-login?provider=Google">
                                                            <i class="ei ei-google-plus"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div><!-- /content -->
                                </div>
                            </div>
                        </div>  
                        <div class="image-container col-md-5 hidden-xs hidden-sm">
                            <div class="background-holder theme-overlay has-content" style="background-image:url(assets/images/bg-18.jpg)">
                                <div class="content pdd-horizon-50">
                                    <img class="img-responsive mrg-btm-20" src="img/logo_transp_white.png" alt="">                                            
                                    <h3 class="mrg-btm-20 text-white">Already have an account?</h3>                                            
                                    <button class="btn btn-sm btn-block btn-white-inverse mrg-vertical-20 register_to_login">Sign in</button>                                    
                                </div><!-- content -->
                            </div><!-- /background-holder -->
                        </div><!-- /image-container -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<!-- Jquery Plugins -->

<script type="text/javascript" src="theme/plugins/smoothscroll/smoothscroll.js"></script>
<script type="text/javascript" src="theme/plugins/easing/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="theme/plugins/wow/wow.min.js"></script>
<script type="text/javascript" src="theme/plugins/counter-up/waypoints.min.js"></script>
<script type="text/javascript" src="theme/plugins/counter-up/jquery.counterup.min.js"></script>
<script type="text/javascript" src="theme/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="theme/plugins/isotope/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="theme/plugins/magnific-popup/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="theme/plugins/youtube-player/js/jquery.mb.YTPlayer.js"></script>
<script type="text/javascript" src="theme/plugins/swiper/js/swiper.min.js"></script>
<script type="text/javascript" src="theme/plugins/parallax-scroll-master/jquery.parallax-scroll.js"></script>
<script type="text/javascript" src="theme/plugins/validation/jquery.validate.min.js"></script>


<!--[if lt IE 9]>
<script src="theme/plugins/ie/html5shiv.js"></script>
<script src="theme/plugins/ie/respond.min.js"></script>
<![endif]-->

<!-- Java Scripts -->
<!-- <script type="text/javascript" src="assets/js/google-map.js"></script>
     <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->

<script type="text/javascript" src="theme/js/main.js"></script>
<?php
if ($this->input->url == 'locations/add' || $this->input->url == 'locations/edit') {
    if (file_exists($this->path->views . 'front' . DIRECTORY_SEPARATOR . 'modal' . DIRECTORY_SEPARATOR . 'location_details.php'))
        include_once ($this->path->views . 'front' . DIRECTORY_SEPARATOR . 'modal' . DIRECTORY_SEPARATOR . 'location_details.php');
}
if ($this->input->url == 'donations/edit' || $this->input->url == 'donations/view') {
    if (file_exists($this->path->views . 'front' . DIRECTORY_SEPARATOR . 'modal' . DIRECTORY_SEPARATOR . 'book_donation.php'))
        include_once ($this->path->views . 'front' . DIRECTORY_SEPARATOR . 'modal' . DIRECTORY_SEPARATOR . 'book_donation.php');
}
?>
<script>
    $(document).ready(function () {
        $('.btn-delete').click(
                function (event) {
                    event.preventDefault();

                    if (confirm('Please confirm to delete the record')) {
                        window.location.href = event.target.href;
                    }
                }
        );        
    });
</script>