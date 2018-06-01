<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {

        $this->model_api->sendResponse(
                $this->_getUserById()
        );
    }

    private function _getUserById() {
        if($user_id = $this->model_api->getParams('id')){
            $this->user->setSite($this->model_api->getSiteId());
            $result = $this->user->api_getUser($this->user->getUserById($user_id));
            if($result['data']['site_id'] == $this->model_api->getSiteId()){
                return $result;
            }            
        }
        return null;
    }

}
