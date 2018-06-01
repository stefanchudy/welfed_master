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

        $params = $this->model_api->getParams();
        $id = $params['location_id'];
        $this->model_locations->loadLocation($id);

        unset($params['location_id']);        

        $this->model_locations->updateLocation($params);     

        $this->model_api->sendResponse(
                $this->model_locations->loadLocation($id)
        );
    }

}
