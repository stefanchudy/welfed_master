<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_foods
     */
    protected $model_foods = Null;

    /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = Null;

    /**
     *
     * @var model_locations
     */
    protected $model_locations = Null;

    /**
     *
     * @var model_users 
     */
    protected $model_users = Null;

    public function init() {
        date_default_timezone_set('UTC');
        $this->html->addHeaderTag('<script type="text/javascript" src="js/LocationPicker.js"></script>');
        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];
            $this->pageData['id'] = $id;

            $this->loadModel('donations');
            $this->loadModel('foods');
            $this->loadModel('locations');
            $this->loadModel('users');

            $this->pageData['active_tab'] = 0;
            if (isset($this->input->get['tab']) && ((int) $this->input->get['tab'] <= 1)) {
                $this->pageData['active_tab'] = (int) $this->input->get['tab'];
            }

            if ($donation = $this->model_donations->getDonation($id)) {
//                $this->debug($donation);
                $this->_setValidation();

                $this->pageData['users'] = $this->model_users->getUsers();

                if (count($this->input->post)) {
                    if (isset($this->input->post['donation_reset']) || isset($this->input->post['booking_user_id'], $this->input->post['booking_qty'])) {
                        if (isset($this->input->post['donation_reset'])) {
                            $new_expire = $this->model_donations->resetDonation($id, (int) $this->input->post['donation_reset']);

                            $donation = $this->model_donations->getDonation($id);
                        }

                        if (isset($this->input->post['booking_user_id'], $this->input->post['booking_qty'])) {
                            $this->pageData['active_tab'] = 1;
                            if ($donation['quantity_remain'] > 0) {
                                $booked_quantity = (int) $this->input->post['booking_qty'];
                                $booked_quantity = ($booked_quantity ? $booked_quantity : 1);
                                if ($booked_quantity > $donation['quantity_remain']) {
                                    $booked_quantity = $donation['quantity_remain'];
                                }

                                $add_booking = $this->model_donations->bookDonation((int) $this->input->post['booking_user_id'], $id, $booked_quantity);

                                $donation = $this->model_donations->getDonation($id);
                            } else {
                                \System\Alerts::addError('Sorry, the whole quantity is booked');
                            }
                        }
                    } else {
                        $this->errors = $this->validator->validateAll($this->input->post);
                        $this->pageData['title'] = $this->input->post['title'];
                        $this->pageData['food_types_selector'] = $this->model_foods->getSelector($this->input->post['food_type_id']);
                        $this->pageData['quantity'] = (int) $this->input->post['quantity'];
                        $this->pageData['location_id'] = (int) $this->input->post['location_id'];
                        $this->pageData['description'] = $this->input->post['description'];
                        $this->pageData['allergy'] = $this->input->post['allergy'];
                        $this->pageData['preferences'] = $this->input->post['preferences'];
                        if (count($this->errors) === 0) {

                            $save = Array(
                                'location_id' => (int) $this->input->post['location_id'],
                                'food_type_id' => (int) $this->input->post['food_type_id'],
                                'title' => $this->db->escape($this->input->post['title']),
                                'description' => $this->db->escape($this->input->post['description']),
                                'allergens' => '@"' . implode('', $this->input->post['allergy']) . '"',
                                'quantity' => (int) $this->input->post['quantity'],
                                'preferences' => (int) $this->input->post['preferences'],
                            );
                            $this->model_donations->updateDonation($id, $save);
                            $donation = $this->model_donations->getDonation($id);
                        }
                    }
                }

                $this->pageData['title'] = $donation['title'];
                $this->pageData['food_types_selector'] = $this->model_foods->getSelector($donation['food_type_id']);
                $this->pageData['quantity'] = $donation['quantity'];
                $this->pageData['location_id'] = $donation['location_id'];
                $this->pageData['description'] = $donation['description'];
                $this->pageData['preferences'] = $donation['preferences'];
                $this->pageData['allergy'] = str_split($donation['allergens']);
                $this->pageData['timer_old'] = strtotime($donation['date_expire']) - strtotime('now');
                $this->pageData['timer'] = strtotime($donation['date_expire']);

//                $this->debug(Array(
//                    'new' => $this->pageData['timer'],
//                    'old' => $this->pageData['timer_old'],
//                ));
                
                $this->pageData['booking'] = $donation['booking'];
                $this->pageData['quantity_booked'] = $donation['quantity_booked'];
                $this->pageData['quantity_remain'] = $donation['quantity_remain'];
            } else {
                $this->redirect('admin/donations');
            }
        } else {
            $this->redirect('admin/donations');
        }

//        $this->debug($this->pageData['booking']);
        $this->pageData['user_selector'] = $this->model_locations->getUserSellector('booking_user_id', NULL);












        $this->html->setTitle($this->short_name . ' Administration | Add Donations');
        $this->renderPage('admin/donations/donations_details');
    }

    private function _setValidation() {
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MIN_LENGTH, 5);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);

        $this->validator->addValidation('description', \Utility\Validator::PATTERN_FORBIDDEN);

        $this->validator->addValidation('quantity', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('quantity', \Utility\Validator::PATTERN_NUMBER_ONLY);
        $this->validator->addValidation('quantity', \Utility\Validator::PATTERN_MIN_VALUE, 1);
    }

}
