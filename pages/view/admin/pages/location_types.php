<?php
//$this->debug($this->errors);
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pickup location types</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/dashboard" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
            <span class="pull-right">
                <a class="btn btn-info btn-type-add"><i class="fa fa-plus-circle"></i> Add new type</a>
            </span>
        </div>            
        <div class="panel-body">
            <?php
            echo $location_types;
            ?>                  
        </div>
    </div>
</div>

<div class="modal fade in" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_label">Modal title</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" id="form1">
                    <input type="hidden" id="action" name="action" value="<?php echo(isset($action) ? $action : ''); ?>"/>
                    <input type="hidden" id="id" name="id" value="<?php echo(isset($id) ? $id : ''); ?>"/>
                    <div class="row">
                        <div class="form-group">
                            <label for="title" class="control-label col-md-4">Title</label>
                            <div class="col-md-8">
                                <input type="text" name="title" id="title" value="<?php echo (isset($title) ? $title : ''); ?>" class="form-control"/>
                                <span class="small-alert">
                                    <?php
                                    echo $this->showErrors('title');
                                    ?>
                                </span>
                            </div>                            
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="description" class="control-label col-md-4">Description</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" class="form-control"><?php echo (isset($description) ? $description : ''); ?></textarea>
                                <span class="small-alert">
                                    <?php
                                    echo $this->showErrors('description');
                                    ?>
                                </span>
                            </div>                            
                        </div>
                    </div>                        
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="form1" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function () {
<?php
if (count($this->errors)) {
    echo '$("#modal_edit").modal("show")';
}
?>
    });
    $('.btn-type-add').click(function (e) {
        e.preventDefault();
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('modal_label').innerHTML = 'Add new pickup location type';
        document.getElementById('action').value = 'add';
        document.getElementById('id').value = '';
        $('#modal_edit').modal('show');
    });
    $('.btn-type-edit').click(function (e) {
        e.preventDefault();
        document.getElementById('title').value = this.dataset.title;
        document.getElementById('description').value = this.dataset.description;
        document.getElementById('modal_label').innerHTML = 'Edit pickup location type';
        document.getElementById('action').value = 'edit';
        document.getElementById('id').value = this.dataset.id;
        $('#modal_edit').modal('show');
    });
    $('.btn-type-delete').click(function (e) {
        e.preventDefault();
        if (confirm('Please confirm to delete the record')) {
            document.getElementById('action').value = 'del';
            document.getElementById('id').value = this.dataset.id;
            document.getElementById('form1').submit();
        }
    });
</script>