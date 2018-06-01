<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {

        $this->model_api->sendResponse(
                $this->_deleteUser()
        );
    }

    private function _deleteUser() {
        $this->user->setSite($this->model_api->getSiteId());
        if ($admin_id = $this->model_api->getSiteAdminId()) {
            return $this->user->deleteUser($this->model_api->getParams('id'), $admin_id);
        }
    }

}
