<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     * @var model_users $model_users
     */
    protected $model_users;

    public function init() {
        $this->loadModel('users');

        $this->model_api->sendResponse(
                $this->_getUsersCollection()
        );
    }

    public function _getUsersCollection() {
        $result = array();
        $site_id = $this->model_api->getSiteId();
        $users = $this->model_users->getUsers();
        
        foreach ($users as $user_id => $user){
            if($user['data']['site_id']==$site_id){
                $result[$user_id] = $user;
            }
        }
        
        return $result;
    }

}
