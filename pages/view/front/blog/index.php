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
                    <div class="col-md-9">
                        <div class="blog blog-list">
                            <?php foreach ($collection as $item) { ?>
                                <div class="blog-item">
                                    <div class="row">
                                        <?php if ($item['image']) { ?>
                                            <div class="col-md-4">
                                                <div class="blog-media">
                                                    <a href="blog/read/<?php echo $item['url'] ?>">
                                                        <img class="img-responsive" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-<?php echo ($item['image'] ? 8 : 12); ?>">
                                            <div class="blog-content">
                                                <h3 class="blog-tittle">
                                                    <a href="blog/read/<?php echo $item['url'] ?>">
                                                        <?php echo $item['title'] ?>
                                                    </a>
                                                </h3>
                                                <div class="blog-meta">
                                                    <span class="author">By <span class="theme-color"><?php echo (trim($users[$item['created_by']]['screen_name']) ? $users[$item['created_by']]['screen_name'] : 'Administrator'); ?></span>,</span>
                                                    <span class="date"><?php echo date_format(date_create($item['date']), 'd M Y'); ?></span>
                                                </div>
                                                <p class="blog-article">
                                                    <?php echo $this->cutString(strip_tags($item['content']), 400); ?>
                                                </p>                                                
                                                <div class="continue-reading">
                                                    <a class="btn btn-dark-inverse" href="blog/read/<?php echo $item['url'] ?>"><i class="ei ei-right-arrow"></i></a>
                                                </div>			
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>