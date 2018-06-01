<?php

class Controller extends System\MainController {

     /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;

    public function init() {

        $this->loadModel('blog');
        $this->model_blog
                ->setSiteId($this->model_api->getSiteId())
                ->init_admin();

        $this->model_api->sendResponse($this->_updateBlogPost());
    }
    
    private function _updateBlogPost(){        
        $key = $this->model_api->getParams('id');
        $data =  $this->model_api->getParams('data');
        
        $this->model_blog->updateRecord($key, $data);
        
        return $this->model_blog->getRecord($key);
        
    }

}
