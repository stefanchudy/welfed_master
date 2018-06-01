<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_users 
     */
    protected $model_users = Null;

    /**
     *
     * @var model_locations $model_locations
     */
    protected $model_locations = null;
    
    /**
     *
     * @var model_location_types $model_location_types 
     */
    protected $model_location_types = null;

    public function init() {


        $this->model_api->sendResponse(
                $this->_getLocationsCollection()
        );
    }

    private function _getLocationsCollection() {
        $this->loadModel('locations');
        $this->loadModel('users');
        $this->loadModel('location_types');
        
        $result = array();
        $locations = $this->model_locations->getCollection();

        $types = $this->model_location_types->get();
        
        $users = $this->model_users->getUsers();
        $site_id = $this->model_api->getSiteId();

        foreach ($locations as $k => $v) {
            $location_user = isset($users[$v['user_id']]) ? $users[$v['user_id']] : null;
            if ($location_user &&($location_user['data']['site_id']==$site_id)) {
                $result[$k] = $v;
                $result[$k]['user'] = array(
                    'email' => $location_user['email'],
                    'link' => $location_user['admin_link'],
                    'ban' => $location_user['data']['ban'],
                    'advanced' => $location_user['data']['advanced']
                );
                $result[$k]['location_type_string'] = isset($types[$v['location_type']]['title'])?$types[$v['location_type']]['title']:'n/a';
            }
        }
        return $result;
    }

}
