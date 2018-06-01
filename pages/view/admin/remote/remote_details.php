<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo isset($id) ? 'Edit' : 'Add'; ?> remote site</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/remotelist" class="btn btn-default"><i class="fa fa-reply"></i> Return</a> 
            <button type="submit" form="form1" class="btn btn-info"><i class="fa fa-floppy-o"></i> Save</button>
        </div>            
        <div class="panel-body">
            <form id="form1" role="form" method="post" enctype='multipart/form-data'>
                <div class="row">              
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="ip_address" class="control-label">IP address</label>
                            <input <?php echo isset($id) ? 'readonly="readonly"' : ''; ?> type="text" id="ip_address" name="remotelist[ip]" class="form-control" value="<?php echo $ip; ?>"/>
                            <span class="small-alert">
                                <?php
                                echo $this->showErrors('ip');
                                ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Name / Description</label>
                            <input type="text" id="name" name="remotelist[name]" class="form-control" value="<?php echo $name; ?>"/>
                            <span class="small-alert">
                                <?php
                                echo $this->showErrors('name');
                                ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="admin_mail" class="control-label">Administrator email</label>
                            <input type="text" id="admin_mail" name="remotelist[admin_mail]" class="form-control" value="<?php echo $admin_mail; ?>"/>
                            <span class="small-alert">
                                <?php
                                echo $this->showErrors('admin_mail');
                                ?>
                            </span>
                        </div>
                        <?php if (isset($id)) { ?>
                            <div class="form-group">
                                <label for="token" class="control-label">Security token</label>
                                <input  type="text" id="token"  readonly="readonly" class="form-control" value="<?php echo $token; ?>"/>                            
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>