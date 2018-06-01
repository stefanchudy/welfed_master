<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {        

        $this->model_api->sendResponse($this->_addUser());
    }

    private function _addUser() {
        $this->user->setSite($this->model_api->getSiteId());
        $params = array(
            'email' => $this->model_api->getParams('email'),
            'password' => $this->model_api->getParams('password'),
            'first_name' => $this->model_api->getParams('first_name'),
            'last_name' => $this->model_api->getParams('last_name'),
            'mobile_phone' => $this->model_api->getParams('mobile_phone'),            
            'site_id' => $this->model_api->getSiteId()
        );
        
        $result = null;
        if ($new_id = $this->user->register($params['email'], $params['password'], $params['first_name'] . ' ' . $params['last_name'])) {
            $dataParams = Array(
                        'first_name' => $this->db->escape($params['first_name']),
                        'last_name' => $this->db->escape($params['last_name']),
                        'mobile_phone' => $this->db->escape($params['mobile_phone']),                        
                        'site_id' => $params['site_id'],
                    );
            
            if($alergies = $this->model_api->getParams('alergies')){
                $dataParams['alergies'] = $alergies;
            }
            
            if ($this->user->set_data($new_id, $dataParams)) {
                $result = $this->user->api_getUser($this->user->getUserById($new_id), $this->model_api->getSiteId());
            }
        }
        return $result;
    }

}
