<!-- Map Start -->
<section class="map map-md">
    <div id="google-map" class="google-map"></div>
</section>
<!-- Map End -->
<!-- Contact Start -->
<section class="section-1">
    <div class="container">
        <?php if (!isset($message_sent)) { ?>
            <div class="row">
                <div class="text-center mrg-btm-50">
                    <h2 class="heading-1 text-center">Contact Us</h2>
                    <p class="width-40 mrg-horizon-auto">Leave us a message. We will respond quickly</p>
                </div>

                <div class="col-md-6 col-md-offset-3 contact-form">
                    <form class="contact-form-wrapper margin-10"  name="contactForm" id='contact_form' method="post">
                        <input type="text" id="_full_name" name="_full_name"/>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Name">
                                <span class="small-alert">
                                    <?php
                                    echo $this->showErrors('name');
                                    ?>
                                </span>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                                <span class="small-alert">
                                    <?php
                                    echo $this->showErrors('email');
                                    ?>
                                </span>
                            </div>                        
                            <div class="form-group col-md-12">
                                <textarea class="form-control" name="message" rows="3" placeholder="Message"></textarea>
                                <span class="small-alert">
                                    <?php
                                    echo $this->showErrors('message');
                                    ?>
                                </span>
                            </div>                        
                            <div class="form-group col-md-12" id="submit">
                                <input class="btn btn-md btn-dark" type="submit" id="send_message" value="Send Message">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <?php if ($message_sent) { ?>
                <div class="row">
                    <div class="text-center mrg-btm-50">
                        <h2 class="heading-1 text-center">Thank you for your enquiry.</h2>
                        <p class="width-40 mrg-horizon-auto">We will contact you as soon as possible.</p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="text-center mrg-btm-50">
                        <h2 class="heading-1 text-center">Error!</h2>
                        <p class="width-40 mrg-horizon-auto">Your message was no sent due to some error. Please try again later.</p>
                    </div>
                </div>
            <?php } ?> 
        <?php } ?> 

    </div>
</section>
<!-- Contact End -->

