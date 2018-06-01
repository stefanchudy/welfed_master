<?php

class Controller extends System\MainController {    

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;
    

    public function init() {
        
        $result = $this->_logOff();

        $this->model_api->sendResponse($result ? $result : array('error' => 'Failed to delete the session record'));
    }
    
    private function _logOff(){
        $params = $this->model_api->getParams();
//        return $params;
        $query = $this->db->query('DELETE FROM `sessions` WHERE `id` = '.$params['session_id']);
        
        return array('result'=>($query->error?'fail':'ok'));
    }

}
