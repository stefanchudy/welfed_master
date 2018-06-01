<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_common $model_common 
     */
    protected $model_common;
    private $_booking_expiring = 3;

    public function init() {

        $this->loadModel('common');
        $this->model_common->setAPIData($this->model_api->getSiteId(), $this->model_api->getSiteData());

        $result = $this->model_common->getDashboardData();

        $result['unverified_locations'] = $this->location_getCollection();
        $result['active_donations'] = $this->donations_getCollection();

        $this->model_api->sendResponse($result);
    }

    #

    private function location_getCollection() {
        $this->loadModel('locations');
        $location_result = $this->model_locations->getCollection();

        $site_data = $this->model_api->getSiteData();

        $result = Array();
        foreach ($location_result as $k => $v) {
            if (!$v['location_verified'] && in_array($k, $site_data['locations'])) {
                $result[$k] = Array(
                    'title' => $v['location_title'],
                    'description' => $v['location_description'],
                    'country' => $v['location_country'],
                    'state' => $v['location_state'],
                    'city' => $v['location_city'],
                    'address' => $v['location_address'],
                );
            }
        }

        return $result;
    }

    private function donations_getCollection() {
        $this->loadModel('donations');
        $donation_result = $this->model_donations->getCollection();

        $site_data = $this->model_api->getSiteData();

        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $result = Array();
        $result_unsorted = Array();
        $sort_map = Array();
        foreach ($donation_result as $k => $v) {
            if ((strtotime($v['date_expire']) > strtotime($expired)) && $v['quantity_remain'] && in_array($k, $site_data['donations'])) {
                $remain = strtotime($v['date_expire']) - strtotime($expired);
                $sort_map[$k] = $remain;
                $result_unsorted[$k] = Array(
                    'id' => $k,
                    'timer' => strtotime($v['date_expire']),
                    'title' => $v['title'],
                    'location' => $v['location_data']['location_title'],
                    'location_id' => $v['location_data']['id'],
                    'food_type' => $v['computed']['food_type_path'],
                    'status' => $v['computed']['status_html'],
                    'qty' => $v['quantity'],
                    'qty_booked' => $v['quantity_booked'],
                    'qty_remain' => $v['quantity_remain'],
                );
            }
        }

        asort($sort_map);

        foreach (array_keys($sort_map) as $sort_key) {
            $result[$sort_key] = $result_unsorted[$sort_key];
        }

        return $result;
    }

}
