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

        $this->model_api->sendResponse(
                 $this->model_blog->addBlogPost($this->model_api->getParams('title'), $this->model_api->getSiteAdminId())
        );
    }

}
