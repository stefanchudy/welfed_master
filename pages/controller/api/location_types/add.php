<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_location_types $model_location_types
     */
    protected $model_location_types = Null;
    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;


    public function init(){
        $this->loadModel('location_types')
                ->setSiteId($this->model_api->getSiteId());
       
        $insert = $this->model_location_types->add($this->model_api->getParams('title'), $this->model_api->getParams('description'));
        
        $this->model_api->sendResponse($insert);
        
    }

}
