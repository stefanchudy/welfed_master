<?php

class model_locations extends \System\Model {

    /**
     *
     * @var \Utility\OrmDataset $locations 
     */
    private $locations = null;

    /**
     * 
     * @var \Utility\OrmDataset $users_data
     */
    private $users_data = NULL;

    public function init() {
        $this->locations = new \Utility\OrmDataset('pickup_locations');
        $this->locations->_set_Order_by('location_title');
        $this->locations->_init();

        $this->users_data = new \Utility\OrmDataset('users');
        $this->users_data->_set_Order_by('email');
        $this->users_data->_init();
    }

    public function getCollection() {
        return $this->locations->_getCollection();
    }

    public function getUnverified() {
        $result = Array();
        foreach ($this->getCollection() as $k => $v) {
            if (!$v['location_verified']) {
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

    public function locationExists($title) {
        $locations = $this->getCollection();
        foreach ($locations as $value) {
            if ($value['title'] == $title) {
                return $value['id'];
            }
        }
        return NULL;
    }

    public function addLocation($params) {
        $this->locations->_clear();

        foreach ($params as $key => $value) {
            $this->locations->_setData($key, $value);
        }
        return $this->locations->_save()
                        ->_getCurrentKey();
    }

    public function updateLocation($params) {
        foreach ($params as $key => $value) {
            $this->locations->_setData($key, $value);
        }
        $this->locations->_save();
    }

    public function setData($key, $value) {
        $this->locations->_setData($key, $value);
        $this->locations->_save();
    }

    public function loadLocation($id) {
        $this->locations->_clear();

        $this->locations->_load($id);
        return $this->locations->_getData();
    }

    public function verify() {
        $current_status = $this->locations->_getData('location_verified');
        $this->locations->_setData('location_verified', (int) !$current_status);
        $this->locations->_save();
    }

    public function delete() {
        $key = $this->locations->_getCurrentKey();
        return array_merge(
                ['deleted' => !$this->locations->_delete()
                    ->keyExists($key)], $this->_deleteDonationsPerLocation($key));
    }

    public function getUserSellector($id, $selected = NULL) {
        $result = '';
        $users = $this->users_data->_getCollection();
        if ($selected === NULL) {
            $selected = $this->user->logged['id'];
        }
        $result .= '<select name="' . $id . '" id="' . $id . '" class="form-control">';
        foreach ($users as $user) {
            $selection = ($user['id'] == $selected ? ' selected="selected"' : '');
            $result .= '<option value="' . $user['id'] . '"' . $selection . '>' . $user['email'] . (($user['id'] == $this->user->logged['id']) ? ' (you)' : '') . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    private function _deleteDonationsPerLocation($location_id) {
        return array(
            'booking' => $this->db->query('DELETE FROM `booked_donations` WHERE `donation_id` IN ( SELECT `id` FROM `donations` WHERE `location_id` = ' . $location_id . ' )')
                    ->__toArray(),
            'donations' => $this->db->query('DELETE FROM `donations` WHERE `location_id` = ' . $location_id)
                    ->__toArray(),
        );
    }

}
