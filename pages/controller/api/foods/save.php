<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_foods $model_foods 
     */
    protected $model_foods = null;

    public function init() {

        $this->loadModel('foods')->setSiteId($this->model_api->getSiteId());

        $this->model_api->sendResponse(
                $this->model_foods->save($this->model_api->getParams('parent_id'), $this->model_api->getParams('title'), $this->model_api->getParams('description'))
        );
    }

}
