<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_location_types
     */
    protected $model_location_types = Null;

    /**
     *
     * @var model_locations
     */
    protected $model_locations = Null;

    /**
     *
     * @var model_arearestrictions
     */
    protected $model_arearestrictions = Null;

    public function init() {
        $this->loadModel('location_types');
        $this->loadModel('locations');
        $this->loadModel('arearestrictions');
        $this->model_arearestrictions->init()
                ->initFront();

        $this->html->addHeaderTag('<script src="https://maps.googleapis.com/maps/api/js?key=' . $this->db_settings->get('google_maps_api', '') . '"></script>');
        $this->html->addHeaderTag('<script type="text/javascript" src="js/Locations.js"></script>');

        $this->setValidation();

        if (count($this->input->post)) {
            $this->errors = $this->validator->validateAll($this->input->post);
            $this->validateAddressComponents();

            $this->pageData['map_options'] = TRUE;
            $this->pageData['location_title'] = $this->input->post['location_title'];
            $this->pageData['location_type'] = (int) $this->input->post['location_type'];
            $this->pageData['user_id'] = (int) $this->input->post['user_id'];
            $this->pageData['location_description'] = $this->input->post['location_description'];
            $this->pageData['location_country'] = $this->input->post['location_country'];
            $this->pageData['location_state'] = $this->input->post['location_state'];
            $this->pageData['location_city'] = $this->input->post['location_city'];
            $this->pageData['location_zip'] = $this->input->post['location_zip'];
            $this->pageData['location_address'] = htmlspecialchars($this->input->post['location_address']);
            $this->pageData['location_geo_lat'] = $this->input->post['location_geo_lat'];
            $this->pageData['location_geo_lng'] = $this->input->post['location_geo_lng'];
            $this->pageData['location_website'] = $this->input->post['location_website'];
            $this->pageData['location_email'] = $this->input->post['location_email'];
            $this->pageData['location_phone'] = $this->input->post['location_phone'];
            $this->pageData['location_mobile'] = $this->input->post['location_mobile'];

            if (count($this->errors) === 0) {
                $add_id = $this->model_locations->addLocation(Array(
                    'location_title' => $this->db->escape($this->input->post['location_title']),
                    'location_type' => (int) $this->input->post['location_type'],
                    'user_id' => (int) $this->input->post['user_id'],
                    'location_description' => $this->db->escape($this->input->post['location_description']),
                    'location_country' => $this->db->escape($this->input->post['location_country']),
                    'location_state' => $this->db->escape($this->input->post['location_state']),
                    'location_city' => $this->db->escape($this->input->post['location_city']),
                    'location_zip' => $this->db->escape($this->input->post['location_zip']),
                    'location_address' => $this->db->escape($this->input->post['location_address']),
                    'location_geo_lat' => $this->db->escape($this->input->post['location_geo_lat']),
                    'location_geo_lng' => $this->db->escape($this->input->post['location_geo_lng']),
                    'location_website' => $this->db->escape($this->input->post['location_website']),
                    'location_email' => $this->db->escape($this->input->post['location_email']),
                    'location_phone' => $this->db->escape($this->input->post['location_phone']),
                    'location_mobile' => $this->db->escape($this->input->post['location_mobile']),
                ));
                if ($add_id)
                    $this->redirect('admin/locations/edit?id=' . $add_id);
            }
//            $this->debug($this->errors);
        }

        $this->pageData['types_selector'] = $this->model_location_types->getSelector('location_type', isset($this->pageData['location_type']) ? $this->pageData['location_type'] : 0);
        $this->pageData['user_selector'] = $this->model_locations->getUserSellector('user_id', isset($this->pageData['user_id']) ? $this->pageData['user_id'] : NULL);

        $this->html->setTitle($this->short_name . ' Administration | Add a location');

        $this->renderPage('admin/locations/location_details');
    }

    private function setValidation() {
        $this->validator->addValidation('location_title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('location_title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('location_title', \Utility\Validator::PATTERN_MIN_LENGTH, 3);

        $this->validator->addValidation('location_description', \Utility\Validator::PATTERN_FORBIDDEN);

        $this->validator->addValidation('location_website', \Utility\Validator::PATTERN_URL);

        $this->validator->addValidation('location_email', \Utility\Validator::PATTERN_EMAIL);

        $this->validator->addValidation('location_phone', \Utility\Validator::PATTERN_NUMBER_ONLY);

        $this->validator->addValidation('location_mobile', \Utility\Validator::PATTERN_NUMBER_ONLY);

        $this->validator->addValidation('location_type', \Utility\Validator::PATTERN_FORBIDDEN, '0', 'You must select a location type!');
    }

    private function validateAddressComponents() {
        if (
                (trim($this->input->post['location_country']) == '') ||
                (trim($this->input->post['location_city']) == '') ||
                (trim($this->input->post['location_address']) == '') ||
                (trim($this->input->post['location_geo_lat']) == '') ||
                (trim($this->input->post['location_geo_lng']) == '')
        ) {
            $this->errors['address_components'][] = 'There is no valid address selected. Use this button to select it from the map.';
        }
        if (!$this->_validateAreaRestrictions()) {
            $this->errors['address_components'][] = 'This area is not currently covered by our service.';
        }
    }

    private function _validateAreaRestrictions() {
        $restrictions = $this->model_arearestrictions->getJsonList();
        $country = trim($this->input->post['location_country']);
        $city = trim($this->input->post['location_city']);
        return isset($restrictions[$country][$city]);
    }

}
