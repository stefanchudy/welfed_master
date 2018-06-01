<?php

namespace System\Extend;

/**
 * Description of UserExtended
 *
 * @author martin
 */
class UserExtended extends \System\User {

    /**
     * \Utility\Validator object
     *
     * @var \Utility\Validator
     */
    private $_validator = NULL;

    /**
     *
     * @var \Utility\OrmDataset $_donationsObject 
     */
    private $_donationsObject = NULL;

    /**
     *
     * @var array $_donations
     */
    private $_donations = Array();

    /**
     *
     * @var \Utility\OrmDataset $_bookedObject 
     */
    private $_bookedObject = NULL;

    /**
     *
     * @var array $_booked 
     */
    private $_booked = Array();

    /**
     *
     * @var \Utility\OrmDataset $remoteSites
     */
    private $remoteSites = null;
    private $_booking_expiring = 3;
    private $_locations = NULL;
    private $_booking_limit = 0;
    private $_siteId = 0;

    public function __construct() {
        parent::__construct();

        $this->_validator = new \Utility\Validator();

        $this->_booking_expiring = $this->db_settings->get('booking_time', 3);
        $this->_booking_limit = $this->db_settings->get('booking_limit', 0);

        $this->_donationsObject = new \Utility\OrmDataset('donations');
        $this->_donationsObject->_init();
        $this->_donations = $this->_donationsObject->_getCollection();


        $this->_bookedObject = new \Utility\OrmDataset('booked_donations');
        $this->_bookedObject->_set_Order_by(['delivered', 'date_booked']);
        $this->_bookedObject->_init();
        $this->_booked = $this->_bookedObject->_getCollection();

        $this->_locations = $this->db->getTable('pickup_locations');

        $this->remoteSites = new \Utility\OrmDataset('remote_sites');
        $this->remoteSites->_init();
        return $this;
    }

    public function setSite($siteId) {
        $this->_siteId = $siteId;
        return $this;
    }

    public function isAdmin() {
        return $this->logged && ($this->logged['access'][0] == 1) && ($this->logged['data']['site_id'] == 0);
    }

    public function getAdminList() {
        return $this->getList(TRUE);
    }

    public function getUserList() {
        return $this->getList(FALSE);
    }

    public function getFullList() {
        return $this->getList();
    }

    public function getList($admin = NULL) {
        $result = Array();
        $users_data = Array();
        if (isset($this->config->db['users_data'])) {
            $data_text = 'SELECT `data`.*, 
                                 `rs`.`name` AS `site_name`,
                                 (`users`.`email` = `rs`.`admin_mail`) AS `site_admin`
                            FROM `' . $this->config->db['users_data'] . '` AS `data`
                            LEFT JOIN `remote_sites` AS `rs`    
                              ON `data`.`site_id` = `rs`.`id`
                            LEFT JOIN `users` as `users`
                              ON `users`.`id` = `data`.`user_id`';

            $data_query = $this->db->query($data_text);
            foreach ($data_query->rows as $row) {
                $users_data[$row['user_id']] = Array(
                    'profile_image' => $row['profile_image'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'alergies' => $row['alergies'],
                    'location_lat' => $row['location_lat'],
                    'location_lng' => $row['location_lng'],
                    'mobile_phone' => $row['mobile_phone'],
                    'ban' => $row['ban'],
                    'advanced' => $row['advanced'],
                    'site_id' => $row['site_id'],
                    'site_name' => $row['site_name'] ? $row['site_name'] : '<strong style="color:blue">Local host</strong>',
                    'site_admin' => $row['site_admin']
                );
            }
        }

        $query_text = 'SELECT * FROM `users` ' . (($admin === TRUE) ? 'WHERE `access` LIKE "1%"' : (($admin === FALSE) ? 'WHERE `access` LIKE "0%"' : '')) . ' ORDER BY `email`';

        $query = $this->db->query($query_text);
        foreach ($query->rows as $row) {
            $result[$row['id']] = $row;
            if (isset($users_data[$row['id']])) {
                $result[$row['id']]['data'] = $users_data[$row['id']];
            }
        }
        return $result;
    }

    public function exists($email) {
        $query = $this->db->query('SELECT COUNT(`u`.`id`) AS `count` 
                                     FROM `users` AS `u`
                                     LEFT JOIN `users_data` AS `d`
                                       ON `d`.`user_id` = `u`.`id`
                                     WHERE `u`.`email`="' . $this->db->escape($email) . '" AND `d`.`site_id` = ' . $this->_siteId . '
                                     GROUP BY `u`.`id`');

        return ($query->rows[0]['count'] != 0);
    }

    public function add($params = Array()) {
        $this->_validator->clear();
        $this->_setValidationRegister();
        $errors = $this->_validator->validateAll($params);

        if (count($errors) === 0) {

            $new_id = $this->register($params['email'], $params['password'], $params['first_name'] . ' ' . $params['last_name']);

            if ($new_id) {
                $this->set_data($new_id, Array(
                    'first_name' => $this->db->escape($params['first_name']),
                    'last_name' => $this->db->escape($params['last_name']),
                    'mobile_phone' => $this->db->escape($params['mobile_phone']),
                ));
            }
        }

        return $errors;
    }

    public function update($id, $_main_data = Array(), $extra_data = Array()) {

        if (count($_main_data) != 0) {
            if (isset($_main_data['password'])) {
                $main_data['password'] = md5($_main_data['password']);
            }
            if (isset($_main_data['screen_name'])) {
                $main_data['screen_name'] = $this->db->escape($_main_data['screen_name']);
            }
            if (isset($_main_data['access'])) {
                $main_data['access'] = $_main_data['access'];
            }
//            $this->debug($main_data);
            $this->edit($id, $main_data);
        }
        if (count($extra_data) != 0) {
            $this->set_data($id, $extra_data);
        }
    }

    public function getUserById($id) {
        $result = parent::getUserById($id);

        $result['active_locations'] = 0;
        $result['is_admin'] = $result['access'][0];
        $result['locations'] = Array();

        foreach ($this->_locations as $row) {
            if ($row['user_id'] == $id) {
                $result['locations'][$row['id']] = $row;
                if ($row['location_verified']) {
                    $result['active_locations'] ++;
                }
            }
        }

        $result['donations_issued'] = Array();

        $query_donations = $this->db->getTable('donations', '`location_id` IN (SELECT `id` FROM `pickup_locations` WHERE `user_id`=' . $id . ')', 'id', ' ORDER BY `date_expire` DESC');

        foreach ($query_donations as $row) {
            $donation = $row;
            $booked = $this->_getBooked(Array(
                'donation_id' => $donation['id']
            ));

            $donation['location_data'] = $this->_locations[$row['location_id']];
            $result['donations_issued'][$row['id']] = $donation;
            $result['donations_issued'][$row['id']]['quantity_booked'] = $booked['total'];
            $result['donations_issued'][$row['id']]['quantity_remain'] = $donation['quantity'] - $booked['total'];
        }
        $result['donations_used'] = $this->_getDonationsUsed($id);

        return $result;
    }

    public function getUserByEmail($email) {
        $query = $this->db->query('SELECT `u`.`id`
                                         FROM `users` AS `u`
                                         LEFT JOIN `users_data` AS `d`
                                           ON `d`.`user_id` = `u`.`id`
                                        WHERE `email` = "' . $this->db->escape($email) . '" 
                                          AND `d`.`site_id`=' . $this->_siteId);
        if ($query->error == 0 && $query->num_rows != 0) {
            return $this->getUserById($query->rows[0]['id']);
        }

        return null;
    }

    public function getUserNameById($id = null) {
        $user = ($id === null) ? $this->logged : $this->getUserById($id);
        return $user ? ((!empty(trim($user['screen_name']))) ? $user['screen_name'] : ((!empty(trim($user['data']['first_name'] . ' ' . $user['data']['first_name']))) ? $user['data']['first_name'] . ' ' . $user['data']['first_name'] : $user['email'])) : null;
    }

    public function upgradeUser($id) {
        $this->update($id, Array(), ['advanced' => 1]);
    }

    public function rejectUser($id) {
        $this->update($id, Array(), array(
            'advanced' => 0,
            'upgrade_application' => 2
        ));
    }

    public function applyUpgrade($id) {
        $this->update($id, Array(), ['upgrade_application' => 1]);
    }

    private function _getBooked($filter = Array()) {
        $this->_cleanBookings();
        $result = Array(
            'total' => 0,
            'entries' => Array()
        );

        foreach ($this->_booked as $booked) {
            if (isset($filter['donation_id']) && ($filter['donation_id'] != $booked['donation_id'])) {
                continue;
            }
            if (isset($filter['user_id']) && ($filter['user_id'] != $booked['user_id'])) {
                continue;
            }
            $result['total'] += $booked['quantity'];
            $result['entries'][$booked['id']] = $booked;

            $booked_expire = date('Y-m-d H:i:s', strtotime($booked['date_booked'] . ' + ' . $this->_booking_expiring . ' hours'));

            if (isset($this->_donations[$booked['donation_id']])) {
                $donation_expire = $this->_donations[$booked['donation_id']]['date_expire'];
                if (strtotime($booked_expire) > strtotime($donation_expire)) {
                    $booked_expire = $donation_expire;
                }
            }

            $result['entries'][$booked['id']]['date_expire'] = $booked_expire;
        }
        return $result;
    }

    private function _cleanBookings() {
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $query = 'DELETE FROM `booked_donations` WHERE `date_booked` < "' . $expired . '" AND `delivered` = 0';
        $this->db->query($query);
    }

    public function canBookNow($user_id = null) {
        if ($user_id === NULL) {
            if ($this->logged) {
                $id = $this->logged['id'];
            } else {
                return FALSE;
            }
        } else {
            $id = $user_id;
        }
        if ($this->_booking_limit == 0) {
            return True;
        }
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));

        $query = 'SELECT COUNT(`id`) AS `count` FROM `booked_donations` WHERE `user_id` = ' . $id . ' AND `delivered` = 0 AND `date_booked` > "' . $expired . '"';
        $count_active = $this->db->query($query)->rows[0]['count'];
        return ($count_active < $this->_booking_limit);
    }

    private function _getDonationsUsed($user_id) {
        $result = Array();
        $booked = $this->_getBooked(Array(
            'user_id' => $user_id
        ));

        foreach ($booked['entries'] as $key => $value) {
            $location_id = $this->_donations[$value['donation_id']]['location_id'];
            $result[$key] = Array(
                'id' => $value['donation_id'],
                'donation_title' => $this->_donations[$value['donation_id']]['title'],
                'location_id' => $location_id,
                'location_title' => $this->_locations[$location_id]['location_title'],
                'location_country' => $this->_locations[$location_id]['location_country'],
                'location_state' => $this->_locations[$location_id]['location_state'],
                'location_city' => $this->_locations[$location_id]['location_city'],
                'location_logo' => $this->_locations[$location_id]['location_logo'],
                'quantity' => $value['quantity'],
                'date_booked' => $value['date_booked'],
                'date_expire' => $value['date_expire'],
                'delivered' => $value['delivered'],
            );
        }

        return $result;
    }

    private function _setValidationRegister() {

        $this->_validator->addValidation('email', \Utility\Validator::PATTERN_REQUIRED, NULL, 'The E-mail field is required!');
        $this->_validator->addValidation('email', \Utility\Validator::PATTERN_EMAIL);
        $this->_validator->addValidation('email', \Utility\Validator::PATTERN_MAX_VALUE, 5);
        $this->_validator->addValidation('email', \Utility\Validator::PATTERN_CUSTOM_FUNCTION, function($param) {
            return !$this->exists($param);
        }, 'This e-mail allready exists in the database!');

        $this->_validator->addValidation('password', \Utility\Validator::PATTERN_MIN_LENGTH, 6, 'The password cannot be shorter than 6 characters.');
        $this->_validator->addValidation('password', \Utility\Validator::PATTERN_MAX_LENGTH, 20, 'The password cannot be longer than 20 characters.');
        $this->_validator->addValidation('password', \Utility\Validator::PATTERN_REQUIRED, NULL, 'You must provide password');
        $this->_validator->addValidation('password', \Utility\Validator::PATTERN_CUSTOM_FUNCTION, function() {
            if (isset($this->input->post['register']['password'], $this->input->post['register']['password2'])) {
                return ($this->input->post['register']['password'] == $this->input->post['register']['password2']);
            } else {
                return TRUE;
            }
        }, 'The two passwords does not match');

        $this->_validator->addValidation('first_name', \Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->_validator->addValidation('first_name', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->_validator->addValidation('first_name', \Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->_validator->addValidation('first_name', \Utility\Validator::PATTERN_REQUIRED);

        $this->_validator->addValidation('last_name', \Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->_validator->addValidation('last_name', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->_validator->addValidation('last_name', \Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->_validator->addValidation('last_name', \Utility\Validator::PATTERN_REQUIRED);

        $this->_validator->addValidation('mobile_phone', \Utility\Validator::PATTERN_MAX_LENGTH, 20);
        $this->_validator->addValidation('mobile_phone', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->_validator->addValidation('mobile_phone', \Utility\Validator::PATTERN_REQUIRED);

        $this->_validator->addValidation('legal', \Utility\Validator::PATTERN_MIN_VALUE, 1, 'You must read and agree with our <a href="terms" target="_blank">terms</a>');
    }

    public function socialLogin($user) {
        $this->createSession($user['id'], $user['email'], $user['password']);
        $this->checkSession();
    }

    public function deleteUser($id, $current_user = null) {
        if ($current_user === null) {
            $current_user = $this->logged['id'];
        }
        if ($user = $this->getUserById($id)) {
            if ($user['data']['site_id'] == $this->_siteId) {
                parent::deleteUser($id);

                $this->db->query('DELETE FROM `booked_donations` WHERE `user_id`=' . $id);
                $this->db->query('DELETE FROM `contact_to_user` WHERE `user_id`=' . $id);

                $this->db->query('UPDATE `pickup_locations` SET `user_id` = ' . $current_user . ', `location_verified` = 0 WHERE `user_id`=' . $id);
            }
        }
    }

// API methods
    public function api_getUser($user) {
        $site_data = null;
        if ($this->remoteSites->keyExists($user['data']['site_id'])) {
            $site_data = $this->remoteSites->_clear()
                    ->_load($user['data']['site_id'])
                    ->_getData();
        }

        $user['is_admin'] = ($user['email'] == $site_data['admin_mail']);

        $user['site_data'] = $site_data;
        return $user;
    }

    public function api_checkSession($session_data) {
        if (isset($session_data['user_id'], $session_data['session_id'], $session_data['user_token'])) {
            $user_id = $session_data['user_id'];
            $session_id = $session_data['session_id'];
            $token = $session_data['user_token'];

            if ($user = $this->getUserById($user_id)) {
                if ($user['data']['site_id'] == $this->_siteId) {
                    $query_session = $this->db->query('SELECT * FROM `sessions` WHERE `token`="' . $token . '" AND `expire`>NOW()');
                    if ($query_session->num_rows == 1) {
                        $session = $query_session->rows[0];
                        if ($token === $this->calkSessionKey($session['id'], $user['id'], $user['email'], $user['password'])) {
                            return $this->api_getUser($user);
                        }
                    }
                }
            }
        }
        return NULL;
    }

}
