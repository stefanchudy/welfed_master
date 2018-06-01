<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Remote site list</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/dashboard" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
            <span class="pull-right">
                <a href="admin/remotelist/add" class="btn btn-info btn-type-add"><i class="fa fa-plus-circle"></i> Add new site</a>
            </span>
        </div>            
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable_donations">
                    <thead>
                        <tr>
                            <th>Site name</th>
                            <th>IP Address</th>
                            <th>Administrator e-mail</th>
                            <th>Security token</th>
                            <th class="align-center" style="width:200px;">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($remotelist as $site){
                                echo '<tr>';
                                echo '<td>'.$site['name'].'</td>';
                                echo '<td>'.$site['ip'].'</td>';
                                echo '<td>'.$site['admin_mail'].'</td>';
                                echo '<td>'.$site['token'].'</td>';
                                echo '<td class="align-center">';
                                echo '<a href="admin/remotelist/edit?id='.$site['id'].'" class="btn btn-success btn-xs">Edit</a> ';
                                echo '<a href="admin/remote-log?filter='.$site['filter'].'" class="btn btn-info btn-xs">Log</a> ';
                                echo '<a href="admin/remotelist/delete?id='.$site['id'].'" class="btn btn-danger btn-delete btn-xs">Delete</a> ';
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
<script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable_donations').DataTable({
            responsive: true
        });
    });
</script>