<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Donations</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/dashboard" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
            <span class="pull-right">
                <a href="admin/donations/add" class="btn btn-info btn-type-add"><i class="fa fa-plus-circle"></i> Add new donation</a>
            </span>
        </div>            
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable_donations">
                    <thead>
                        <tr>
                            <th>Date issued</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Site</th>
                            <th>Food type</th>
                            <th>Quantity</th>
                            <th>Booked</th>
                            <th>Remain</th>
                            <th>Expires (UTC)</th>
                            <th>Status</th>
                            <th class="align-center" style="width:200px;">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($donations as $donation) {
                            $siteName = $users[$donation['location_data']['user_id']]['data']['site_name'];
                            echo '<tr>';
                            echo '  <td>' . $donation['date_created'] . '</td>';
                            echo '  <td>' . $donation['title'] . '</td>';
                            echo '  <td>' . $donation['location_data']['location_title'];
                            echo '  <br>' . $donation['location_data']['location_country'] . ' / ';
                            echo $donation['location_data']['location_state'] . ' / ';
                            echo $donation['location_data']['location_city'];
                            echo '  </td>';
                            echo '  <td>'.$siteName.'</td>';
                            echo '  <td>' . $donation['computed']['food_type_path'] . '</td>';
                            echo '  <td class="align-right">' . $donation['quantity'] . '</td>';
                            echo '  <td class="align-right">' . $donation['quantity_booked'] . '</td>';
                            echo '  <td class="align-right">' . $donation['quantity_remain'] . '</td>';
                            echo '  <td>' . $donation['computed']['expire_two_row'] . '</td>';
                            echo '  <td class="align-center"><span class="countdown" data-time="' . strtotime($donation['date_expire']) . '"></span></td>';
                            echo '  <td class="align-center">';
                            echo '      <a href="admin/donations/edit?id=' . $donation['id'] . '" class="btn btn-success btn-xs">Edit</a>';
                            echo '      <a href="admin/donations/delete?id=' . $donation['id'] . '" class="btn btn-danger btn-delete btn-xs">Delete</a> ';
                            echo '  </td>';
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