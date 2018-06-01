<?php

class Controller extends System\MainController {    

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;
    

    public function init() {
        
        $result = $this->_updateUser();

        $this->model_api->sendResponse($result);
    }
    
    private function _updateUser(){
        $params = $this->model_api->getParams();
        $this->user->setSite($this->model_api->getSiteId());
        
        $this->user->update($params['id'],$params['main_data'],$params['extra_data']);
        
        return $this->user->api_getUser($this->user->getUserById($params['id']));
    }
    

}
