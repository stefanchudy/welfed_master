<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit area</h1>
        </div>        
    </div>    
    <form role="form" enctype="multipart/form-data" id="form1" method="post">
        <input type="file" name="image" id="image" style="display: none;" onchange="document.getElementById('form1').submit();"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <input type="submit" value="Save" class="btn btn-default"/>
                        <a href="admin/working-areas" class="btn btn-default">Return</a>                        
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label" for="sort_order">Sort order</label>                            
                                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo $sort_order; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label" for="caption">Caption</label>
                                            <input type="text" name="caption" id="caption" class="form-control" value="<?php echo $caption; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label" for="country">Country</label>
                                            <input type="text" name="country" id="country" class="form-control" value="<?php echo $country; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('country');
                                                ?>
                                            </span>
                                        </div>
                                    </div>                               
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label" for="city">City</label>
                                            <input type="text" name="city" id="city" class="form-control" value="<?php echo $city; ?>"/>
                                            <span class="small-alert">
                                                <?php
                                                echo $this->showErrors('city');
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="small-alert">
                                            <?php
                                            echo $this->showErrors('locality');
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="image" style="cursor: pointer">                                    
                                    <img src="<?php echo $image; ?>" class="img img-responsive img-thumbnail"/>
                                </label>                                
                            </div>
                        </div>
                    </div>                
                </div>            
            </div>        
        </div>
    </form>
</div>