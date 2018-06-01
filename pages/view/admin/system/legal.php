<form method="post" id="form1">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Site Terms and conditions</h1>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <input type="submit" form="form1" value="Save" class="btn btn-default"/>
                <a href="admin/dashboard" class="btn btn-default">Return</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#terms_tab" data-toggle="tab">
                                    Terms and conditions
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="terms_tab">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="col-lg-12">
                                                    <textarea id="terms_text" name="terms_text" class="form-control" rows="16"><?php echo $this->db_settings->get('terms_text',''); ?></textarea>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(
            function () {
                $('#terms_text').jqte();
                var jqteStatus = true;
            }
    );
</script>