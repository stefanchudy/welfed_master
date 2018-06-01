<!-- Hero Start -->
<section id="hero">
    <div class="fs-hero hero-slider">
        <div class="swiper-hero swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"  style="background-image:url(img/big/landing_1.jpg)">
                    <div class="hero-caption center-left text-white">
                        <h2 class="font-weight-light mrg-btm-20">Happiness is only real<br>when shared</h2>
                        <p>Join us today and be part of the growing network of restaurants and charities eliminating food waste.</p>
                        <div class="mrg-top-30">
                            <?php if ($this->user) { ?>                                
                                <?php if (count($this->user['locations'])) { ?>
                                    <a href="donations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } else {?>
                                    <a href="locations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } ?>
                                    
                                <?php if ($this->user['data']['advanced'] || $this->user['access'][0]==1) { ?>
                                    or <a href="search" class="btn btn-md btn-white"> Search</a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#login"> Login</a>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#register"> Register</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide"  style="background-image:url(img/big/landing_2.jpg)">
                    <div class="hero-caption center-left text-white">
                        <h2 class="font-weight-light mrg-btm-20">Sustainable network with<br>zero liability and minimal effort</h2>
                        <p>Well crafted legal waivers protect all parties, and the portal allows for food redistribution at no cost to you.</p>
                        <div class="mrg-top-30">
                            <?php if ($this->user) { ?>
                                <?php if (count($this->user['locations'])) { ?>
                                    <a href="donations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } else {?>
                                    <a href="locations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } ?>
                                    
                                <?php if ($this->user['data']['advanced'] || $this->user['access'][0]==1) { ?>
                                    or <a href="search" class="btn btn-md btn-white"> Search</a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#login"> Login</a>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#register"> Register</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide"  style="background-image:url(img/big/landing_3.jpg)">
                    <div class="hero-caption center-left text-white">
                        <h2 class="font-weight-light mrg-btm-20">Eliminate waste and<br>protect the environment</h2>
                        <p>Any unusable food will go towards creating clean, sustainable energy</p>
                        <div class="mrg-top-30">
                            <?php if ($this->user) { ?>
                                <?php if (count($this->user['locations'])) { ?>
                                    <a href="donations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } else {?>
                                    <a href="locations/add" class="btn btn-md btn-white"> Donate</a>
                                <?php } ?>
                                    
                                <?php if ($this->user['data']['advanced'] || $this->user['access'][0]==1) { ?>
                                    or <a href="search" class="btn btn-md btn-white"> Search</a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#login"> Login</a>
                                <a class="btn btn-md btn-white" data-toggle="modal" data-target="#register"> Register</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-navigation navigation-2">
                <div class="swiper-hero-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                <div class="swiper-hero-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
            </div>
            <div class="swiper-hero-pagination swiper-bullet-1"></div>
        </div>

    </div><!-- /hero-img -->
</section>
<!-- Hero End -->
<!-- About horizontal Start -->
<section id="about" class="section-1" style="margin-bottom: -200px;">
    <div class="container">
        <div class="text-center">
            <h2 class="heading-1 text-center">How it <span class="theme-color">Works</span></h2>
            <hr>
            <br>
        </div>
        <div class="row">
            <div class="content-block-1 col-md-3 col-sm-6 col-xs-12">
                <div>
                    <img class="img-responsive" src="img/infographic/infographic1.png" alt="">
                </div>
                <div class="text-content">
                    <h4 class="heading-1"><span class="theme-color">Diners</span> ask their leftover food to be boxed up for charity</h4>
                </div>
            </div>
            <div class="content-block-1 col-md-3 col-sm-6 col-xs-12">
                <div>
                    <img class="img-responsive" src="img/infographic/infographic2.png" alt="">
                </div>
                <div class="text-content">
                    <h4 class="heading-1"><span class="theme-color">Restaurants</span> can quickly log this food onto our Portal</h4>
                </div>
            </div>
            <div class="content-block-1 col-md-3 col-sm-6 col-xs-12">
                <div>
                    <img class="img-responsive" src="img/infographic/infographic3.png" alt="">
                </div>
                <div class="text-content">
                    <h4 class="heading-1"><span class="theme-color">Charities</span> can reserve leftover food in their area, and even request delivery</h4>
                </div>
            </div>
            <div class="content-block-1 col-md-3 col-sm-6 col-xs-12">
                <div>
                    <img class="img-responsive" src="img/infographic/infographic4.png" alt="">
                </div>
                <div class="text-content">
                    <h4 class="heading-1 left"><span class="theme-color">Food</span> is given to those in need, and free <span class="theme-color">Biogas generators</span> will cover waste food into renewable energy</h4>
                </div>
            </div>
        </div>                
    </div>
</section>
<!-- About horizontal End -->
<hr>
<!-- Features Start -->
<section class="section-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2 class="heading-1">How we are different</h2>
                <p>We understand there are plenty of great charities working towards a similar goal, however we are approaching the problem with a fresh perspective, tackling the highest source of wast in a sustainable way</p>
                <div class="counter-style-1 mrg-vertical-30 row">
                    <div class="col-md-12">
                        <h2 class="counter theme-color">1,300,000,000</h2>
                        <p>Tonnes of food wasted every year</p>
                    </div>             
                </div>
            </div>
            <div class="col-md-7 col-md-offset-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="features-block-1">
                            <i class="ei ei-wellfed" data-icon="&#xe098;"></i>
                            <h4 class="features-tittle">Consumption waste</h4>
                            <p>The majority of food waste does not occur from production or distribution, but from consumption, a source most charities struggle to tap into. Well Fed Foundation can not only access regular restaurant waste, but actual leftovers from diners</p>
                        </div><!-- /features-block-1 -->                        
                    </div>
                    <div class="col-md-6">
                        <div class="features-block-1">
                            <i class="ei ei-wellfed" data-icon="&#xe03d;"></i>
                            <h4 class="features-tittle">No Legal Liability</h4>
                            <p>Carefully crafted agreements would protect all parties to ensure the true spirit of this foundation remains intact, ensuring your business or charity is not at risk of lawsuits.</p>
                        </div><!-- /features-block-1 -->                        
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="features-block-1">
                            <i class="ei ei-wellfed" data-icon="&#xe044;"></i>
                            <h4 class="features-tittle">No Cost to Restaurant or Charity</h4>
                            <p>Well Fed foundation is completely free to use, and limits restaurants' work to as little as putting food into takeaway boxes provided by us</p>
                        </div><!-- /features-block-1 -->                        
                    </div>
                    <div class="col-md-6">
                        <div class="features-block-1">
                            <i class="ei ei-wellfed" data-icon="&#xe175;"></i>
                            <h4 class="features-tittle">Sustainable & Waste-free</h4>
                            <p>Uniquely, we find a way to make use of any food not suitable to feed others, and turn that into sustainable energy using biogas generators provided by us</p>
                        </div><!-- /features-block-1 -->                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Features End -->
<!-- Testimonial Start -->
<section class="section-3">
    <div class="content-block-2">
        <div class="image-container col-md-offset-6 col-md-6">
            <div class="background-holder has-content">
                <div class="content">
                    <img class="img-responsive mrg-horizon-auto" src="img/logo_transparent.png" alt="">
                </div>
            </div><!-- /background-holder -->
        </div><!-- /image-container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-content">
                        <h2 class="mrg-btm-40 heading-1"><span class="theme-color">Where</span> are we working?</h2>
                        <div class="testimonial-1">
                            <div class="swiper-single swiper-container">
                                <div class="swiper-wrapper mrg-btm-70">
                                    <?php foreach ($slider as $slide) { ?>
                                        <?php if ($slide['image'] && $slide['caption']) { ?>
                                            <div class="swiper-slide">
                                                <span class="client theme-color"><?php echo $slide['caption']; ?></span>
                                                <p class="quote">
                                                    <img class="img-responsive mrg-horizon-auto" src="<?php echo $slide['image']; ?>" alt="">
                                                </p>
                                            </div><!-- /swiper-slide -->
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="swiper-slide">
                                        <span class="client theme-color">More locations coming soon</span>
                                        <p class="quote">Contact us if you want to donate in your location.</p>
                                    </div><!-- /swiper-slide -->                                    
                                </div>
                                <div class="swiper-navigation">
                                    <div class="swiper-button-next"><i class="ei ei-right-chevron-boxed"></i></div>
                                    <div class="swiper-button-prev"><i class="ei ei-left-chevron-boxed"></i></div>
                                </div>
                            </div><!-- /swiper-container -->
                        </div><!-- /testimonial-1 -->
                    </div><!-- /content -->
                </div>
            </div>
        </div>            
    </div><!-- /content-block-2 -->
</section>
<!-- Testimonial End -->
<section class="section-1">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h2 class="heading-1 text-center">Get involved, join us today</h2>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php echo $this->db_settings->get('contact_facebook', ''); ?>" class="btn btn-social btn-xl btn-block btn-facebook">
                            <i class="fa fa-facebook"></i>
                            Facebook
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo $this->db_settings->get('contact_twitter', ''); ?>" class="btn btn-social btn-xl btn-block btn-twitter">
                            <i class="fa fa-twitter"></i>
                            Twitter
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo $this->db_settings->get('contact_instagram', ''); ?>" class="btn btn-social btn-xl btn-block btn-instagram">
                            <i class="fa fa-instagram"></i>
                            Instagram
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/contact" class="btn btn-social btn-default btn-xl btn-block">
                            <i class="fa fa-envelope-o"></i>
                            Write us a message
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section>