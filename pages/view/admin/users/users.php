<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo ($user_type ? 'Site Administrators' : 'User management'); ?>
            </h1>
        </div>        
    </div>    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">   
                <div class="panel-heading">
                    <a href="admin/<?php echo ($user_type ? 'administrators' : 'users'); ?>/add" class="btn btn-default">
                        <?php echo ($user_type ? 'Add Administrator' : 'Add user'); ?>
                    </a>
                </div>

                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th style="width: 150px">Volunteer</th>
                                    <th style="width: 150px">Site</th>
                                    <th style="width: 150px">Status</th>
                                    <th style="width: 150px">Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $key => $value) {
                                    $access = ($value['data']['advanced'] == 1) ? 'Yes <i  style="color:red" class="fa fa-thumbs-o-up"></i>' : 'No';
                                    $ban = ($value['data']['ban'] == 1) ? 'Banned' : 'Active';
                                    echo '<tr>';
                                    echo '<td><a class="block" href="admin/' . (($value['access'][0] == 1) ? 'administrators' : 'users') . '/edit?id=' . $value['id'] . '">' . $value['screen_name'] . '</a></td>';
                                    echo '<td><a class="block" href="admin/' . (($value['access'][0] == 1) ? 'administrators' : 'users') . '/edit?id=' . $value['id'] . '">' . $value['email'] . '</a></td>';
                                    echo '<td style="text-align:center">' . $access . '</td>';
                                    echo '<td style="text-align:center">';
                                    if ($value['data']['site_id'] == 0) {
                                        echo $value['data']['site_name'];                                        
                                    } else {
                                        echo '<a href="admin/remotelist/edit?id=' . $value['data']['site_id'] . '" class="btn btn-link">' . $value['data']['site_name'] . '</a>';
                                        if($value['data']['site_admin']){
                                            echo '<br><span style="color:red"><i class="fa fa-star"></i></span> Site admin';
                                        }
                                    }
                                    echo '</td>';
                                    echo '<td style="text-align:center">' . $ban . '</td>';
                                    echo '<td style="text-align:center">';

                                    if (($user_type != 1) || (($value['id'] != $user['id']) && (count($users)) > 1)) {
                                        echo '<a href="admin/users/delete?id=' . $value['id'] . '" class="btn btn-danger btn-delete">Delete user</a>';
                                    }

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
            responsive: true
        });
    });
</script>