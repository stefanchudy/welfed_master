<!-- Page Title Start -->
<section class="page-tittle page-tittle-xl kenburn-bg dark-overlay">
    <img class="kenburn-img" src="img/big/about_5.jpg" alt="">
    <div class="container">
        <div class="page-tittle-head" style="background-color: rgba(0,0,0,0.5);padding: 32px;margin: -32px;">
            <h2>Forgotten password restoration</h2>
            <p>Fill the form below. We will restore your lost password and send it to your email.</p>
        </div>        
    </div>
</section>
<!-- Page Title End -->

<?php if (isset($success_message)) { ?>
    <section class="section-1">
        <div class="container">
            <div class="row">
                <div class="text-center mrg-btm-50">
                    <h2 class="heading-1 text-center">Done! Your new <span class="theme-color">password</span> awaits you in your e-mail.</h2>
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <a href="" class="btn btn-lg btn-block btn-default">Back to the home page</a>         
                </div>

            </div>
        </div>
    </section>
<?php } else { ?>
<section class="section-1">
        <div class="container">
            <div class="row">
                <div class="text-center mrg-btm-50">
                    <h2 class="heading-1 text-center">Please enter your email.</h2>
                </div>
                <div class="col-md-6 col-md-offset-3 contact-form">
                    <form role="form" class="contact-form-wrapper margin-10" method="post">
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" name="email" type="text" value="<?php echo $email; ?>">
                            <span class="small-alert">
                                <?php
                                echo $this->showErrors('email');
                                ?>
                            </span>
                        </div>                            
                        <input type="submit" class="btn btn-lg btn-theme btn-block" value="Retrieve my password"/>
                    </form>
                    <hr>
                    <a href="" class="btn btn-lg btn-block btn-default">Back to the home page</a>
                </div>            
            </div>
        </div>
    </section>
<?php } ?>
