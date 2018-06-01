<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Blog posts</h1>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">            
            <a href="admin/dashboard" class="btn btn-default"><i class="fa fa-reply"></i> Return</a>
            <span class="pull-right">
                <a href="admin/blog/add" class="btn btn-info btn-type-add"><i class="fa fa-plus-circle"></i> Add new post</a>
            </span>
        </div>            
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="datatable_blog">
                    <thead>
                        <tr>
                            <td style="width: 120px">Date</td>
                            <td style="width: 140px">Image</td>
                            <td>Title</td>
                            <td style="width: 80px;">Active</td>
                            <td style="width: 120px;">Control</td>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        if (!empty($posts)) {                            
                            foreach ($posts as $post_id=>$post) {
                                echo '<tr>';
                                echo '<td>'. date_format(date_create($post['date']), 'Y-m-d').'</td>';
                                echo '<td style="text-align:center">';
                                echo '  <img class="img img-responsive" src="'.($post['image']?$post['image']:'https://placeholdit.imgix.net/~text?txtsize=14&txt=No%20image%20uploaded&w=120&h=90').'"/>';
                                echo '</td>';
                                echo '<td>'.$post['title'].'</td>';
                                echo '<td>'.($post['active']?'Yes':'No').'</td>';
                                echo '<td>';
                                echo '  <a class="btn btn-success btn-xs btn-block" href="admin/blog/edit?id='.$post_id.'">Edit</a>';
                                echo '  <a class="btn btn-danger btn-delete btn-xs btn-block" href="admin/blog/del?id='.$post_id.'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
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
        $('#datatable_blog').DataTable({
            responsive: true,       
            order : [[0,'desc']]
        });
    });
</script>