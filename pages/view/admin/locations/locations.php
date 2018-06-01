<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pickup locations</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/dashboard" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
            <span class="pull-right">
                <a href="admin/locations/add" class="btn btn-info btn-type-add"><i class="fa fa-plus-circle"></i> Add new location</a>
            </span>
        </div>            
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable_locations">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th style="width:140px;">Managed by</th>
                            <th style="width:140px;">Country</th>
                            <th style="width:140px;">State</th>
                            <th style="width:140px;">City</th>
                            <th style="width:140px;">Location type</th>
                            <th class="align-center" style="width:100px;">Verified</th>
                            <th class="align-center" style="width:100px;">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($locations as $location) {
                            if($users[$location['user_id']]['data']['site_id']!=0){
//                                continue;
                            }
                            $siteName = $users[$location['user_id']]['data']['site_name'];
                            $user_type = $users[$location['user_id']]['access'][0];
                            $ban = ($users[$location['user_id']]['data']['ban'] == 1) ? '<i class="fa fa-ban" style="color:red" title="This user is banned"></i> ' : '';
                            $basic = (($users[$location['user_id']]['data']['advanced'] == 0)&&($user_type==0)) ? '<i class="fa fa-exclamation-triangle" style="color:orange" title="This user is basic and cannot manage locations"></i> ' : '';

                            echo '<tr>';
                            echo '<td><a href="admin/locations/edit?id=' . $location['id'] . '" class="block">' . $location['location_title'] . '</a></td>';
                            echo '<td><a href="admin/' . (($user_type == 0) ? 'users' : 'administrators') . '/edit/?id=' . $location['user_id'] . '" class="block">' . $ban . $basic . $users[$location['user_id']]['email'] . '</a><br>Site : '.$siteName.'</td>';
                            echo '<td>' . $location['location_country'] . '</td>';
                            echo '<td>' . $location['location_state'] . '</td>';
                            echo '<td>' . $location['location_city'] . '</td>';
                            echo '<td>' . (isset($types[$location['location_type']]) ? $types[$location['location_type']]['title'] : 'Unknown') . '</td>';
                            echo '<td class="align-center">' . (($location['location_verified']) ? 'Yes' : 'No') . '</td>';
                            echo '<td><a href="admin/locations/delete?id=' . $location['id'] . '" class="btn btn-danger btn-delete">Delete</a>' . '</td>';
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
        $('#datatable_locations').DataTable({
            responsive: true
        });
    });
</script>