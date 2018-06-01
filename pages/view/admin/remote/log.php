<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $heading; ?></h1>
        </div>        
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="<?php echo $return_link; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
        </div>            
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable_log">
                   
                    <?php if ($mode == 1) { ?>

                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Number of requests</th>
                                <th>Validity</th>
                                <th>Last connection</th>
                                <th class="align-center" style="width:200px;">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $entry) {
                                echo '<tr>';
                                echo '<td>' . $entry['remote_addr'] . ($entry['name'] ? '<br><strong><em>' . $entry['name'] . '</em></strong>' : '') . '</td>';
                                echo '<td>' . $entry['count'] . '</td>';
                                echo '<td class="text-center"><span class="label label-' . $entry['valid']['class'] . '">' . $entry['valid']['text'] . '</span></td>';
                                echo '<td>' . $entry['time'] . '</td>';
                                echo '<td class="text-center">';
                                echo '<a href="admin/remote-log?filter=' . $entry['filter'] . '" class="btn btn-xs btn-block btn-default">Show details</a>';
                                echo '<a href="admin/remote-log/delete?filter=' . $entry['filter'] . '" class="btn btn-xs btn-block btn-danger btn-delete">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    <?php } elseif ($mode == 2) { ?>
                        <thead>
                            <tr>
                                <th>Controller</th>
                                <th>Calls count</th>
                                <th>Last call</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $entry) {
                                echo '<tr>';
                                echo '<td>';
                                echo '<a href="admin/remote-log?filter=' . $entry['filter'] . '" class="btn btn-xs btn-block btn-default">' . $entry['origin'] . '</a>';
                                echo '<br>';
                                echo '<a href="admin/remote-log/delete?filter=' . $entry['filter'] . '&return='.$this->input->get['filter'].'" class="btn btn-xs btn-block btn-danger btn-delete">Delete</a>';
                                '</td>';
                                echo '<td>' . $entry['count'] . '</td>';
                                echo '<td>' . $entry['time'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    <?php } elseif ($mode == 3) { ?>
                        <thead>
                            <tr>
                                <th>API method</th>
                                <th>Calls count</th>
                                <th>Last call</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $entry) {
                                echo '<tr>';
                                echo '<td>';
                                echo '<a href="admin/remote-log?filter=' . $entry['filter'] . '" class="btn btn-xs btn-block btn-default">' . $entry['method'] . '</a>';
                                echo '<br>';
                                echo '<a href="admin/remote-log/delete?filter=' . $entry['filter'] . '&return='.$this->input->get['filter'].'" class="btn btn-xs btn-block btn-danger btn-delete">Delete</a>';
                                '</td>';
                                echo '<td>' . $entry['count'] . '</td>';
                                echo '<td>' . $entry['time'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    <?php } else { ?>
                        <thead>
                            <tr>
                                <th style="width: 10%;">Time</th>
                                <th style="width: 45%">Request</th>
                                <th style="width: 45%">Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($table as $entry) {
                                echo '<tr>';
                                echo '<td>';
                                echo $entry['timestamp'];
                                echo '<br><br>';
                                echo '<a href="admin/remote-log/delete?id='.$entry['id'].'&return='.$this->input->get['filter'].'" class="btn btn-xs btn-block btn-delete btn-danger">Delete</a>';
                                echo '</td>';
                                echo '<td><pre>' . (json_encode(json_decode($entry['request_json']), JSON_PRETTY_PRINT)) . '</pre></td>';
                                echo '<td><pre>' . (json_encode(json_decode($entry['response_json']), JSON_PRETTY_PRINT)) . '</pre></td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>
<script src="js/datatables/jquery.dataTables.min.js"></script>
<script src="js/datatables/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable_log').DataTable({
            responsive: true
        });
    });
</script>
<style>
    table pre{
        max-width: 500px;
        width: 100%;
        overflow: scroll;
        height: 250px;
        display: block;
    }
</style>