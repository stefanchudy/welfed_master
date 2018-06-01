<!-- Page Title Start -->
<section class="page-tittle page-tittle-xl kenburn-bg dark-overlay">
    <img class="kenburn-img" src="img/big/blog.jpg" alt="">
    <div class="container">
        <div class="page-tittle-head" style="background-color: rgba(0,0,0,0.5);padding: 32px;margin: -32px;">
            <h2>Our Blog</h2>
        </div>        
    </div>
</section>
<!-- Page Title End -->
<section class="section-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <?php echo $sidebar; ?>
                    </div>
                    <div class="col-md-8 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="text-center">
                                    <h2 class="heading-1 text-center">
                                        <?php echo $postData['title']; ?> 
                                    </h2>
                                </div>
                                <hr>
                            </div>
                            <?php if($postData['image']){ ?>
                            <div class="col-md-10 col-md-offset-1">
                                <img src="<?php echo $postData['image']; ?>" class="img img-responsive img-thumbnail img-centered"/>                                
                            </div>
                            <?php } ?>
                            <div class="col-md-10 col-md-offset-1">
                                <br>
                                <br>
                                <?php echo html_entity_decode($postData['content']); ?>
                            </div>
                            <div class="col-md-10 col-md-offset-1">
                                <hr>
                                <span class="date"><?php echo date_format(date_create($postData['date']), 'd M Y'); ?></span><br>
                                <span class="author">By <span class="theme-color"><?php echo (trim($users[$postData['created_by']]['screen_name']) ? $users[$postData['created_by']]['screen_name'] : 'Administrator'); ?></span></span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>