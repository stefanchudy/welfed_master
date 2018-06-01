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

        $key = $this->model_api->getParams('id');

        $this->loadModel('blog');
        $this->model_blog
                ->setSiteId($this->model_api->getSiteId())
                ->init_admin();
        
        if($this->model_blog->publicationExists($key)){
            $response = $this->model_blog->getRecord($key);
        } else {
            $response = array();
        }

        $this->model_api->sendResponse($response);
    }

}
