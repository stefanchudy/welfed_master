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
                ->setSiteId($this->model_api->getSiteId(), $this->model_api->getSiteAdminId())
                ->init_admin();
        
        $key = $this->model_api->getParams('id');
        
        if($this->model_blog->publicationExists($key)){
            $this->model_blog->deleteRecord($key);
        }
        
        $this->model_api->sendResponse(array());
    }

}
