<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;    
    
    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;    

    public function init() {
        $this->loadModel('blog')
                ->init_admin();
        $this->pageData['posts'] = $this->model_blog->getCollection();
        
        $this->html->setTitle($this->short_name . ' Administration | Blog');        
        $this->renderPage('admin/blog/index');        
    }

}
