<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_arearestrictions $model_arearestrictions
     */
    protected $model_arearestrictions = null;

    public function init(){        
        $this->loadModel('arearestrictions')->setSiteId($this->model_api->getSiteId());
        
        $this->model_arearestrictions->initAdmin();
                
        $this->model_api->sendResponse($this->model_arearestrictions->delete($this->model_api->getParams('id')));
        
    }

}
