<?php
//FIXME:Not Done yet
class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_locations $model_locations
     */
    protected $model_locations = null;

    public function init() {
        // $this->loadModel('sliders');        
        
        //A random number: temporary
        $this->model_api->sendResponse(
                3
        );
    }

}
