<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $heading; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">   
                <div class="panel-heading">                    
                    <a href="admin/messages" class="btn btn-default">Back</a>
                </div>
                <div class="panel panel-body">
                    <form id="form1" role="form" method="post" class="form-horizontal" enctype='multipart/form-data'>
                        <fieldset>
                            <legend>Main details</legend>
                            <div class="row">
                                <div class="col-lg-1">
                                    <strong>From</strong>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo '<a target="_blank" href="mailto://' . $message['email'] . '">' . $message['name'] . '</a>'; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1">
                                    <strong>
                                        E-mail
                                    </strong>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $message['email']; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1">
                                    <strong>
                                        Phone
                                    </strong>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo $message['phone']; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1">
                                    <strong>Date sent</strong>
                                </div>
                                <div class="col-lg-11">
                                    <?php echo date_format(date_create($message['date']), 'd F y'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1">
                                    <strong>Sent by</strong>
                                </div>
                                <div class="col-lg-11">
                                     <?php echo $origin; ?>
                                </div>
                            </div>
                        </fieldset>                                                                        
                        <br>
                        <fieldset>
                            <legend>Message content</legend>
                            <div class="row">                                
                                <div class="col-lg-12">
                                    <div class="well">
                                        <?php echo $message['message']; ?>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>                
            </div>            
        </div>        
    </div>
</div>
