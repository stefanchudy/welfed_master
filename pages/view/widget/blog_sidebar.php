<div class="blog-sidebar sidebar-left">
    <div class="widget widget-search">
        <h3 class="widget-tittle">Search</h3>
        <label class="input-wrapper">
            <form method="get" action="<?php echo $this->input->self_url; ?>/blog/search">
                <input class="form-control material-input" type="text" name="search_string" placeholder="Search">
                <button type="submit" class="btn inline-submit mrg-top-5"><i class="ei ei-search"></i></button>
            </form>
        </label>
    </div>
    <div class="widget widget-link dotted">
        <h3 class="widget-tittle">Archives</h3>
        <ul class="link">
            <?php foreach ($datelist as $key => $value) { ?>
                <li class="block">
                    <a href="blog?month=<?php echo $key; ?>" class="block">
                        <?php echo $value['formatted']; ?>
                        <span class="pull-right">
                            <span class="badge"><?php echo $value['count']; ?></span>
                        </span>
                    </a>
                </li>
            <?php } ?>                                    
        </ul>
    </div>
    <div class="widget widget-news">
        <h3 class="widget-tittle">Latest posts</h3>
        <?php foreach ($five as $entry) { ?>
            <div class="news-item">
                <?php if ($entry['image']) { ?>
                    <div class="news-media">
                        <a href="blog/read/<?php echo $entry['url']; ?>">
                            <img class="img-responsive" src="<?php echo $entry['image']; ?>">
                        </a>
                    </div>
                <?php } ?>
                <div class="news-info">
                    <a href="blog/read/<?php echo $entry['url']; ?>" class="news-tittle"><?php echo $entry['title']; ?></a>
                    <span class="news-meta">By <span class="author"><?php echo (trim($users[$entry['created_by']]['screen_name']) ? $users[$entry['created_by']]['screen_name'] : 'Administrator'); ?></span> <?php echo date_format(date_create($entry['date']), 'd M'); ?></span>
                </div>
            </div>
        <?php } ?>                                
    </div>                            
</div>