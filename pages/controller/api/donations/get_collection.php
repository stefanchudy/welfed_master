<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = null;

    public function init() {
        $this->loadModel('donations');

        $this->model_api->sendResponse(
                $this->_getCollection()
        );
    }

    private function _getCollection() {
        $result = array();
        $collection = $this->model_donations->getCollection();
        $siteData = $this->model_api->getSiteData();

        foreach ($collection as $k => $v) {
            if (in_array($k, $siteData['donations'])) {
                $result[$k] = $v;
            }            
        }

        return $result;
    }

}
