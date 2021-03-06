<?php

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
        $this->loadModel('locations');

        if ($id = $this->model_api->getParams('id')) {
            $location = $this->model_locations->loadLocation($id);
            
            $this->model_api->sendResponse(
                    $this->model_locations->delete()
            );
        }
    }

}
