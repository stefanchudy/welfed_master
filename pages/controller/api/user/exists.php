<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {

        $result = $this->_userExists();

        $this->model_api->sendResponse($result);
    }

    private function _userExists() {


        $result = (int) $this->user->setSite($this->model_api->getSiteId())
                        ->exists($this->model_api->getParams('email'));        

        return array('result' => $result);
    }

}
