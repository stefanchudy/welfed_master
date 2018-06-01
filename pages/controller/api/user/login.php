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

    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    protected $model_remotesites = null;

    public function init() {
        $this->loadModel('common');
        $this->loadModel('remotesites');
        $result = $this->_processLoginData();
        $this->model_api->sendResponse($result ? $result : array('error' => 'invalid login credentials'));
    }

    private function _processLoginData() {
        $params = $this->model_api->getParams();        
        if (isset($params['email'], $params['pass'])) {
            $email = $params['email'];
            $pass = $params['pass'];
            $query = $this->user
                    ->setSite($this->model_api->getSiteId())
                    ->getUserByEmail($email);            
            if ($query && ($query['password'] == md5($pass))) {
                return $this->user->api_getUser($query);
            }
        }
        return null;
    }

}
