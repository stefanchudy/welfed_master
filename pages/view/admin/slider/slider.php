<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Working Areas</h1>
        </div>        
    </div>    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">   
                <div class="panel-heading">
                    <a href="admin/working-areas/add" class="btn btn-default">Add new area</a>
                </div>
                <div class="panel-body">                    
                    <div class="row">
                        <?php
                        foreach ($slides as $key => $value){
                            echo '<div class="col-lg-3" style="margin-bottom:16px;">';
                            echo '<div class="gallery-item">';
                            echo '<div class="gallery-title">'.$value['country'].'/'.$value['city'].'</div>';
                            $img_url = $value['image']!=''?$value['image']:'https://placeholdit.imgix.net/~text?txtsize=24&txt=No%20image%20uploaded&w=276&h=210';
                            echo '<img style="width:100%;height:auto;margin:auto" src="'.$img_url.'" class="img img-responsive img-thumbnail"/>' ;
                            echo '<a class="slide-edit btn btn-success btn-sm" href="admin/working-areas/edit?id='.$key.'">'.'Edit'.'</a>';
                            echo '<a class="slide-del btn-delete btn btn-danger btn-sm" href="admin/working-areas/del?id='.$key.'">'.'Delete'.'</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>                
            </div>            
        </div>        
    </div>
</div>