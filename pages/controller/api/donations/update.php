<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = null;

    public function init() {
        $this->loadModel('donations');

        $params = $this->model_api->getParams();

        $this->model_api->sendResponse(
                $this->model_donations->updateDonation($params['id'], $params['data'])
        );
    }

}
