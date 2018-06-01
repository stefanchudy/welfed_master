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

    /**
     *
     * @var model_location_types
     */
    protected $model_location_types = Null;

    public function init() {
        date_default_timezone_set('UTC');

        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];
            $this->pageData['id'] = $id;

            $this->loadModel('donations');
            $this->loadModel('foods');
            $this->loadModel('locations');
            $this->loadModel('users');
            $this->loadModel('location_types');

            $this->pageData['active_tab'] = 0;
            if (isset($this->input->get['tab']) && ((int) $this->input->get['tab'] <= 1)) {
                $this->pageData['active_tab'] = (int) $this->input->get['tab'];
            }

            if ($donation = $this->model_donations->getDonation($id)) {

                if ($this->user->logged && ($donation['location_data']['user_id'] == $this->user->logged['id'])) {
                    $this->html->addHeaderTag('<script type="text/javascript" src="js/LocationPicker.js"></script>');
                    $render_name = 'donations_details';
                    $this->html->setTitle($this->short_name . ' | Edit Donations');
                    $this->_setValidation();
                    $this->pageData['users'] = $this->model_users->getUsers();
                    $this->pageData['food_types_selector'] = $this->model_foods->getSelector($donation['food_type_id']);
                    $this->pageData['modal_mode'] = 'owner';

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
                            $this->pageData['preferences'] = (int) $this->input->post['preferences'];
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
                } else {
                    $render_name = 'donations_view';
                    $this->html->setTitle($this->short_name . ' | View Donation');
                    $this->html->addHeaderTag('<script src="https://maps.googleapis.com/maps/api/js?key=' . $this->db_settings->get('google_maps_api', '') . '"></script>');

                    $this->pageData['can_book_now'] = $this->user->canBookNow();

                    $this->pageData['food_types_selector'] = $this->model_foods->getFullType($donation['food_type_id']);
                    $this->pageData['location_data'] = $donation['location_data'];
                    $this->pageData['location_type_name'] = $this->model_location_types->get_name($donation['location_data']['location_type']);
                    $this->pageData['modal_mode'] = 'customer';
                    $this->pageData['request_delivery'] = 0;

                    if (isset($this->input->post['booking_user_phone'], $this->input->post['booking_qty'])) {
                        $this->_setValidationBooking();
                        if (!($donation['quantity_remain'] > 0)) {
                            $this->errors['booking_qty'][] = 'Sorry, the whole quantity is booked.';
                        }

                        $booked_quantity = (int) $this->input->post['booking_qty'];
                        $booked_quantity = ($booked_quantity ? $booked_quantity : 1);
                        if ($booked_quantity > $donation['quantity_remain']) {
                            $booked_quantity = $donation['quantity_remain'];
                        }
                        $this->pageData['booking_delivery_address'] = $this->db->escape($this->input->post['booking_delivery_address']);
                        $this->errors = array_merge($this->errors, $this->validator->validateAll($this->input->post));
                        $request_delivery = isset($this->input->post['request_delivery']) ? (int) $this->input->post['request_delivery'] : 0;
                        $this->pageData['request_delivery'] = $request_delivery;

                        if (count($this->errors) === 0) {

                            if ($this->user->logged['data']['mobile_phone'] != $this->input->post['booking_user_phone']) {
                                $this->user->update($this->user->logged['id'], [], ['mobile_phone' => $this->input->post['booking_user_phone']]);
                            }                            

                            $this->model_donations->bookDonation(
                                    $this->user->logged['id'], $id, $booked_quantity, $this->input->post['booking_user_phone'], (int) $this->input->post['request_delivery'], $this->pageData['booking_delivery_address']
                            );

                            $donation = $this->model_donations->getDonation($id);

                            $this->_sendBookingNotification($donation, $booked_quantity, $request_delivery);

                            $message = $this->_createDeliveryMessage($donation, $booked_quantity);
                            if ($request_delivery) {
                                Utility\Messaging::createMessage(Array(
                                    'type' => Utility\Messaging::MESSAGE_TYPE_REQUEST_DELIVERY,
                                    'name' => $this->user->logged['screen_name'],
                                    'email' => $this->user->logged['email'],
                                    'phone' => $this->input->post['booking_user_phone'],
                                    'message' => $message,
                                ));
                            }
                        }
                    }

                    $has_booked = $this->model_donations->getBooked(Array('user_id' => $this->user->logged['id'], 'donation_id' => $id));
                    if ($has_booked['total'] > 0) {
                        $entries = $has_booked['entries'];
                        $booked_key = key($entries);
                        $this->pageData['has_booked'] = Array(
                            'time_remain' => strtotime($entries[$booked_key]['date_expire']),
                            'id' => $booked_key
                        );
                    }
                }

                $this->pageData['title'] = $donation['title'];

                $this->pageData['quantity'] = $donation['quantity'];
                $this->pageData['location_id'] = $donation['location_id'];
                $this->pageData['description'] = $donation['description'];
                $this->pageData['allergy'] = str_split($donation['allergens']);
                $this->pageData['expired'] = ((strtotime($donation['date_expire']) - strtotime('now')) < 0);
                $this->pageData['timer'] = strtotime($donation['date_expire']);
                $this->pageData['booking'] = $donation['booking'];
                $this->pageData['quantity_booked'] = $donation['quantity_booked'];
                $this->pageData['quantity_remain'] = $donation['quantity_remain'];
                $this->pageData['preferences'] = (int) $donation['preferences'];
            } else {
                $this->redirect('profile');
            }
        } else {
            $this->redirect('profile');
        }

        $this->pageData['user_selector'] = $this->model_locations->getUserSellector('booking_user_id', NULL);


        $this->renderPage('front/donations/' . $render_name);
    }

    private function _setValidation() {
        $this->validator->clear();
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

    private function _setValidationBooking() {
        $this->validator->clear();
        $this->validator->addValidation('booking_user_phone', \Utility\Validator::PATTERN_REQUIRED, null, 'You must provide a phone number!');
        $this->validator->addValidation('booking_user_phone', \Utility\Validator::PATTERN_NUMBER_ONLY, null, 'The phone number must contain digits only!');
        $this->validator->addValidation('booking_accept_terms', \Utility\Validator::PATTERN_MIN_VALUE, 1, 'You must accept the legal terms to use this service!');

        $this->validator->addValidation('booking_delivery_address', \Utility\Validator::PATTERN_FORBIDDEN);
    }

    private function _createDeliveryMessage($donation, $booked_quantity) {
        $message_data = Array(
            'name' => $this->user->logged['screen_name'],
            'email' => $this->user->logged['email'],
            'phone' => $this->input->post['booking_user_phone'],
            'address' => $this->pageData['booking_delivery_address'],
            // location_data
            'location_country' => $donation['location_data']['location_country'],
            'location_city' => $donation['location_data']['location_city'],
            'location_state' => $donation['location_data']['location_state'],
            'location_address' => $donation['location_data']['location_address'],
            'location_title' => $donation['location_data']['location_title'],
            //  donation details
            'donation_title' => $donation['title'],
            'donation_food_type' => $donation['computed']['food_type_path'],
            'donation_quantity' => $booked_quantity,
        );

        return $this->renderWidget('templates/mail_delivery', $message_data);
    }

    private function _sendBookingNotification($donation, $qty, $delivery) {
        $donor = $this->user->getUserById($donation['location_data']['user_id']);

//        $this->debug($donor);
        $notification_data = array(
            'qty' => $qty,
            'delivery' => $delivery ? 'has' : 'has not',
            'date_booked' => date('Y-m-d H:i:s', time()),
            'date_expire' => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', time()) . ' + ' . $this->db_settings->get('booking_time', 3) . ' hours')),
            'recipient' => array(
                'user_name' => $this->user->logged['screen_name'],
                'email' => $this->user->logged['email'],
                'phone' => $this->user->logged['data']['mobile_phone']
            ),
            'donation' => array(
                'title' => $donation['title'],
                'donor_name' => $donation['location_data']['location_title'],
                'donor_address' => $donation['location_data']['location_country'] . '-' . $donation['location_data']['location_city'] . '<br>' . $donation['location_data']['location_address'],
                'donor_phone' => $donation['location_data']['location_phone'],
                'donor_user' => $this->user->getUserNameById($donation['location_data']['user_id'])
            ),
        );
        $notification_admin = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/booking_admin', $notification_data)));
        $notification_user = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/booking_recipient', $notification_data)));
        $notification_donor = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/booking_donor', $notification_data)));
        
        if ($distribution = $this->db_settings->get('distribution_list', FALSE)) {
            $send_admin = clone $this->mailer;
            $distribution_list = explode(',', $distribution);
            $send_admin->Subject = 'Well Fed Foundation : Booking notification';
            $send_admin->msgHTML($notification_admin);
            $send_admin->ClearAllRecipients();
            foreach ($distribution_list as $value) {
                if($value){
                    $send_admin->addAddress($value);
                }
            }
            $send_admin->send();            
        }

        $send_user = clone $this->mailer;
        $send_user->Subject = 'Well Fed Foundation : Booking notification';
        $send_user->msgHTML($notification_user);
        $send_user->clearAllRecipients();
        $send_user->addAddress($this->user->logged['email']);
        $send_user->send();
        
        $send_donor = clone $this->mailer;
        $send_donor->Subject = 'Well Fed Foundation : Booking notification';
        $send_donor->msgHTML($notification_donor);
        $send_donor->clearAllRecipients();
        $send_donor->addAddress($donor['email']);
        $send_donor->send();
    }

}
