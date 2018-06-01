<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo ($id == 'new') ? 'Add new Blog post' : 'Edit Blog post'; ?></h1>
        </div>
    </div>
    <div class="panel panel-default">
        <form method="post" id="form1" role="form" enctype="multipart/form-data">
            <div class="panel-heading">            
                <a href="admin/blog" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
                <button type="submit" form="form1" class="btn btn-info"><i class="fa fa-floppy-o"></i> Save</button>                
            </div>            
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-<?php echo ($id == 'new') ? 12 : 8; ?>">
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="title">
                                    Publication title
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo isset($postData['title']) ? $postData['title'] : ''; ?>"/>                                    
                                    <span class="small-alert">
                                        <?php
                                        echo $this->showErrors('title');
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($postData['url'])) { ?>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">
                                        Static URL
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" readonly="readonly" value="<?php echo $this->input->self_url . '/blog/read/' . $postData['url']; ?>"/>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($id != 'new') { ?>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">
                                        Publication text
                                    </label>
                                    <span class="small-alert">
                                        <?php
                                        echo $this->showErrors('content');
                                        ?>
                                    </span>
                                    <textarea  class="form-control" id="content" name="content"><?php echo isset($postData['content']) ? $postData['content'] : ''; ?></textarea>                                    
                                </div>
                            </div>                        
                        <?php } ?>
                    </div>
                    <?php if ($id != 'new') { ?>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2" for="date">Date</label>
                                        <div class="col-md-10">
                                            <input type="date" class="form-control" name="date" id="date" value="<?php echo date_format(date_create($postData['date']),'Y-m-d'); ?>"/>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="active" class="col-md-2 control-label">Status</label>
                                        <div class="col-md-10">
                                            <select name="active" id="active" class="form-control">
                                                <option value="0" <?php echo ($postData['active']==0)?'selected="selected"':''; ?>>Disabled</option>
                                                <option value="1" <?php echo ($postData['active']==1)?'selected="selected"':''; ?>>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="image" style="cursor:pointer;">
                                        <img src="<?php echo $postData['image'] ? $postData['image'] : 'https://placeholdit.imgix.net/~text?txtsize=56&txt=Click%20to%20upload%20image&w=800&h=600'; ?>" class="img img-responsive img-centered img-thumbnail"/>
                                    </label>
                                </div>
                            </div>                            
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>
<form id="form2"  enctype="multipart/form-data" method="post">
    <input type="file" name="image" id="image" style="display: none;" onchange="document.getElementById('form2').submit();"/>
</form>
<script>
    $(document).ready(
            function () {
                $('#content').jqte();
                var jqteStatus = true;
            }
    );
</script>