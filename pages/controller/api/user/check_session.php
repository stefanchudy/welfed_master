<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {
        $this->loadModel('common');
    
        $result = $this->_processSessionData();

        
        
        $this->model_api->sendResponse($result ? $result : array('error' => 'invalid session data'));
    }   
    
    private function _processSessionData(){
        return $this->user->setSite($this->model_api->getSiteId())
                ->api_checkSession($this->model_api->getParams());
    }

}
