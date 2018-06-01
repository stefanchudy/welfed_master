<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;


    public function init(){       
        $this->model_api->sendResponse();
        
    }

}
