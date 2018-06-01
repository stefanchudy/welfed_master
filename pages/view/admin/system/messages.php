<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Contact form messages</h1>
        </div>        
    </div>    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    
                                    <th style="width: 150px;">Date</th>                                                                       
                                    <th>From</th>
                                    <th>Category</th>
                                    <th style="width: 120px;">Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($messages['msg'] as $key => $value) {
                                    echo '<tr>';
                                    
                                    echo '<td>';
                                    echo '<a class="block" href="admin/messages/read?id=' . $key . '">';
                                    echo $value['date'];
                                    echo '</a>';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<a class="block" href="admin/messages/read?id=' . $key . '">';
                                    if ($value['read'] == 0) {
                                        echo '<span class="label label-danger">New</span> ';
                                    }
                                    echo $value['name'];
                                    echo '</a>';
                                    echo '</td>';

                                    echo '<td>';
                                    echo '<a class="block" href="admin/messages/read?id=' . $key . '">';
                                    echo \Utility\Messaging::getMessageType($value['type']);
                                    echo '</a>';
                                    echo '</td>';

                                    echo '<td style="text-align:center">';
                                    echo '<a href="admin/messages/delete?id=' . $key . '" class="btn btn-danger btn-delete">Delete</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>                              
                            </tbody>
                        </table>
                    </div>                    
                </div>                
            </div>            
        </div>        
    </div>
</div>
<script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
<?php
if (isset($search)) {
    echo '"search": {"search": "' . $search . '"},"ordering": false';
} else {
    echo '"ordering": false';
}
?>

        });
    });
</script>