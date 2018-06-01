<?php

class model_common extends System\Model {

    private $_apiSiteId = null;
    private $_apiSiteData = null;

    public function init() {
        
    }

    public function getDashboardData() {
        $result = Array();


        if (!$this->_isAPICall()) {
            $messages = $this->getMessages();

            $result['message_count'] = $messages['total'];
            $result['message_unread'] = $messages['unread'];
            $result['message_preview'] = Array();
            $result['message_by_type'] = $messages['by_type'];


            $result['slides_count'] = $this->db->getRecordCount('slider');
            $result['locations_count'] = $this->db->getRecordCount('pickup_locations');
            $result['donations_count'] = $this->db->getRecordCount('donations');

            $result['users_count'] = $this->db->getRecordCount('users', '`access` LIKE "0%"');
            $result['admin_count'] = $this->db->getRecordCount('users', '`access` LIKE "1%"');

//        $this->debug($result);
            $counter = 0;
            foreach ($messages['msg'] as $msg) {
                $counter++;
                if ($counter > 3) {
                    break;
                }
                $result['message_preview'][] = $msg;
            }
        }

        $result['location_type_count'] = $this->db->getRecordCount('pickup_locations_types');
        $result['food_types_count'] = $this->db->getRecordCount('food_types');
        
        $result['locations_count'] = $this->db->getRecordCount('pickup_locations',($this->_isAPICall())?' `id` IN ('. implode(',', $this->_apiSiteData['locations']).')':'');
        $result['users_count'] = $this->db->getRecordCount('users',($this->_isAPICall())?' `id` IN ('. implode(',', $this->_apiSiteData['users']).')':'');
        $result['donations_count'] = $this->db->getRecordCount('donations',($this->_isAPICall())?' `id` IN ('. implode(',', $this->_apiSiteData['donations']).')':'');
        
        return $result;
    }

    public function getMessages() {
        $result = Array(
            'msg' => Array(),
            'read' => 0,
            'unread' => 0,
            'total' => 0,
            'by_type' => Array()
        );

        $query = $this->db->query('SELECT * FROM `contact` ORDER BY `id` DESC');
        $query1 = $this->db->query('SELECT * FROM `contact_to_user` WHERE `user_id`=' . $this->user->logged['id']);

        $result['read'] = $query1->num_rows;
        $result['unread'] = $query->num_rows - $query1->num_rows;
        $result['total'] = $query->num_rows;

        $read = Array();

        foreach ($query1->rows as $row) {
            $read[] = $row['message_id'];
        }
        $offers = Array();

        foreach ($query->rows as $row) {
            if (!isset($result['by_type'][$row['type']])) {
                $result['by_type'][$row['type']] = Array('total' => 0, 'unread' => 0);
            }
            $result['by_type'][$row['type']]['total'] ++;
            $result['msg'][$row['id']] = $row;
            if (in_array($row['id'], $read)) {
                $result['msg'][$row['id']]['read'] = 1;
            } else {
                $result['msg'][$row['id']]['read'] = 0;
                $result['by_type'][$row['type']]['unread'] ++;
            }
            if (isset($offers[$row['id']])) {
                $result['msg'][$row['id']]['offer'] = $offers[$row['id']];
            } else {
                $result['msg'][$row['id']]['offer'] = NULL;
            }
        }
//        $this->debug($result);
        return $result;
    }

    public function setAPIData($siteId, $siteData) {
        $this->_apiSiteId = $siteId;
        $this->_apiSiteData = $siteData;
        return $this;
    }

    private function _isAPICall() {
        return ($this->_apiSiteId !== null);
    }    

}
