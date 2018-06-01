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

        $params = $this->model_api->getParams();

        $siteData = $this->model_api->getSiteData();
        
        $where_restriction = '';
        if(count($siteData['donations'])){
            $where_restriction = ' AND `d`.`id` IN ('. implode(',', $siteData['donations']).')';
        }
        
        $search = $this->model_donations->searchForDonation(
                $params['lat'], $params['lng'], $params['allergens'], $params['preferences'], $params['radius'], $params['limit'], $where_restriction);

        $this->model_api->sendResponse(
                array(
                    'status' => 1,
                    'count' => $search->num_rows,
                    'items' => $search->rows
                )
        );
    }

}
