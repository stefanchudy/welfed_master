<?php

class model_donations extends System\Model {

    /**
     *
     * @var \Utility\OrmDataset $_donations 
     */
    private $_donations = NULL;

    /**
     *
     * @var \Utility\OrmDataset $_locations 
     */
    private $_locations = NULL;

    /**
     *
     * @var \Utility\OrmDataset $_foodTypes 
     */
    private $_foodTypes = NULL;

    /**
     *
     * @var \Utility\OrmDataset $_booked 
     */
    private $_booked = NULL;

    /**
     *
     * @var array $_collection 
     */
    private $_collection = array();
    private $_booking_expiring = 3;

    public function init() {
        $this->_booking_expiring = $this->db_settings->get('booking_time', 3);

        $this->_donations = new Utility\OrmDataset('donations');
        $this->_donations->_init();

        $this->_locations = new Utility\OrmDataset('pickup_locations');
        $this->_locations->_init();

        $this->_foodTypes = new Utility\OrmDataset('food_types');
        $this->_foodTypes->_init();

        $this->_booked = new Utility\OrmDataset('booked_donations');
        $this->_booked->_init();

        $this->_buildCollection();
    }

    public function addDonation($data) {
        $this->_donations->_clear();

        foreach ($data as $key => $value) {
            $this->_donations->_setData($key, $value);
        }
        $this->_donations->_save();
        $new_id = $this->_donations->_getCurrentKey();
        $this->_buildCollection();
        return $new_id;
    }

    public function updateDonation($id, $data) {
        $this->_donations->_clear();
        $this->_donations->_load($id);

        foreach ($data as $key => $value) {
            if ($this->_donations->_getOrigData($key) != $value) {
                $this->_donations->_setData($key, $value);
            }
        }
        $this->_donations->_save();
        $this->_buildCollection(TRUE);
        return $this->getDonation($id);
    }

    public function delete($id){
        $this->_donations->_load($id)
                ->_delete();
        $this->db->query('DELETE FROM `booked_donations` WHERE `donation_id`=' . $id);
    }

    public function resetDonation($id, $time) {
        $date_start = date('Y-m-d H:i:s', time());
        $date_expire = date('Y-m-d H:i:s', strtotime($date_start . ' + ' . $time . ' hours'));
        $this->_donations->_load($id);
        $this->_donations->_setData('date_expire', $date_expire);
        $this->_donations->_save();
        $this->_buildCollection();
        return $this->getDonation($id);
    }

    public function locationKeyExists($key) {
        $result = FALSE;
        if ($this->_locations->keyExists($key)) {
            $this->_locations->_load($key);
            $result = $this->_locations->_getData('location_verified');
        }
        return $result;
    }

    public function getCollection() {
        return $this->_collection;
    }

    public function getActiveDonationsByLocation($location_id) {
        $_collection = $this->getCollection();
        $result = Array();
        foreach ($_collection as $item_id => $collection_item) {
            if (($collection_item['location_id'] == $location_id) && ($collection_item['computed']['status_bool']) && ($collection_item['quantity_remain'] > 0)) {
                $result[$item_id] = $collection_item;
            }
        }
        return $result;
    }

    public function getDonation($key) {
        $this->_donations->_clear();
        $this->_donations->_load($key);
        $this->_collection[$key] = $this->_getCollectionEntry($this->_donations->_getData());
        return $this->_collection[$key];
    }

    public function refresh() {
        $this->_buildCollection(TRUE);
        return $this;
    }

    public function getBooked($filter = Array()) {
        $result = Array(
            'total' => 0,
            'entries' => Array()
        );
        $donations = $this->_donations->_getCollection(TRUE);

        foreach ($this->_booked->_getCollection(TRUE) as $booked) {
            if (isset($filter['donation_id']) && ($filter['donation_id'] != $booked['donation_id'])) {
                continue;
            }
            if (isset($filter['user_id']) && ($filter['user_id'] != $booked['user_id'])) {
                continue;
            }
            $result['total'] += $booked['quantity'];
            $result['entries'][$booked['id']] = $booked;

            $booked_expire = date('Y-m-d H:i:s', strtotime($booked['date_booked'] . ' + ' . $this->_booking_expiring . ' hours'));

            if (isset($donations[$booked['donation_id']])) {
                $donation_expire = $donations[$booked['donation_id']]['date_expire'];
                if (strtotime($booked_expire) > strtotime($donation_expire)) {
                    $booked_expire = $donation_expire;
                }
            }

            $result['entries'][$booked['id']]['date_expire'] = $booked_expire;
        }

        return $result;
    }

    public function bookDonation($user_id, $donation_id, $quantity, $phone = null, $delivery = 0, $address = '') {
        $donations = $this->getCollection();
        if (!isset($donations[$donation_id])) {
            return false;
        }
        $donation_expire = $donations[$donation_id]['date_expire'];

        $date = date('Y-m-d H:i:s', time());
        $this->_booked->_clear();
        $this->_booked->_setData('user_id', $user_id);
        $this->_booked->_setData('donation_id', $donation_id);
        $this->_booked->_setData('quantity', $quantity);
        $this->_booked->_setData('date_booked', $date);
        $this->_booked->_setData('mobile_phone', $phone);
        $this->_booked->_setData('requested_delivery', $delivery);
        $this->_booked->_setData('delivery_address', $address);
        $this->_booked->_save();

        $this->_buildCollection(true);
        return $this->getDonation($donation_id);
    }

    public function resetBooking($_id) {
        $id = (int) ($_id);
        if ($this->_booked->keyExists($id)) {
            $this->_booked->_load($_id);

            $donation_id = $this->_booked->_getData('donation_id');
            $date = date('Y-m-d H:i:s', time());

            $this->_booked->_setData('date_booked', $date);
            $this->_booked->_save();

            return $donation_id;
        } else {
            return NULL;
        }
    }

    public function deleteBooking($_id) {
        $id = (int) ($_id);
        if ($this->_booked->keyExists($id)) {
            $this->_booked->_load($_id);

            $donation_id = $this->_booked->_getData('donation_id');

            $this->_booked->_delete();

            return $donation_id;
        } else {
            return NULL;
        }
    }

    public function deliverBooking($_id) {
        $id = (int) ($_id);
        if ($this->_booked->keyExists($id)) {
            $this->_booked->_load($_id);

            $donation_id = $this->_booked->_getData('donation_id');
            $this->_booked->_setData('delivered', 1);
            $this->_booked->_save();

            return $donation_id;
        } else {
            return NULL;
        }
    }

    public function userHasBooked($user_id, $donation_id) {
        $this->_cleanBookings();
        $query = $this->db->query('SELECT COUNT(`id`) FROM `booked_donations` WHERE `donation_id` = ' . $donation_id . ' AND `user_id` = ' . $user_id);
    }

    public function searchForDonation($lat, $lng, $allergens = Array(), $preferences = 0, $booking_radius=null, $booking_results_limit = null,$where_restriction = '') {
        $this->_cleanBookings();
        
        if($booking_radius===NULL){
            $booking_radius = $this->db_settings->get('booking_radius', 30);
        }
        
        if($booking_results_limit===NULL){
            $booking_results_limit = $this->db_settings->get('booking_results_limit', 10);
        }
        
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $allergens_statement = $this->_getAllergensStatement($allergens);
        $statement = 'SELECT `d`.`id`,
                             `d`.`title`,
                             `l`.`location_title`,
                             `d`.`allergens`,              
                              COALESCE(SUM(`d`.`quantity`),0) - COALESCE(SUM(`b`.`quantity`),0) AS `remain`,
                              `l`.`location_geo_lat` AS `lat`,
                              `l`.`location_geo_lng` AS `lng`,
                              FLOOR(SQRT(POW(' . $lat . ' - `l`.`location_geo_lat`,2) + POW(' . $lng . ' - `l`.`location_geo_lng`,2))*111094) AS `distance`
                        FROM `donations` AS `d`
                        LEFT JOIN `booked_donations` AS `b`
                          ON `b`.`donation_id` = `d`.`id`
                        LEFT JOIN `pickup_locations` AS `l`
                          ON `l`.`id` = `d`.`location_id`
                       WHERE `d`.`date_expire` > "' . $expired . '"
                         AND `d`.`preferences` >= ' . $preferences . '
                         AND `l`.`location_verified` = 1
                         '.$where_restriction.'
                         ' . $allergens_statement . '
                       GROUP BY `d`.`id`
                      HAVING `remain`>0 AND `distance` <= ' . ($booking_radius * 1000) . '
                       LIMIT ' . $booking_results_limit;
        $query = $this->db->query($statement);
        return $query;
    }

    public function getCityList($where = array()) {
        $result = Array();
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $where[] = '`d`.`date_expire` > "' . $expired . '"';
       
        $query_text = 'SELECT `l`.`location_country`      AS `country`, 
                              `l`.`location_city`         AS `city`, 
                              count(`l`.`id`)             AS `count`, 
                              AVG(`l`.`location_geo_lat`) AS `lat`, 
                              AVG(`l`.`location_geo_lng`) AS `lng` 
                         FROM `donations` AS `d` 
                    LEFT JOIN `pickup_locations` AS `l` 
                           ON `l`.`id`=`d`.`location_id` 
                        WHERE  '. implode(' AND ', $where).'
                     GROUP BY `l`.`location_country`, `l`.`location_city`
                     ORDER BY `l`.`location_country`, `l`.`location_city`';
        $query = $this->db->query($query_text);
        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $result[$row['country']][$row['city']] = Array(
                    'count' => $row['count'],
                    'lat' => $row['lat'],
                    'lng' => $row['lng']
                );
            }
        }
        return $result;
    }

    public function getDashboardTable() {
        $this->_cleanBookings();
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $result = Array();
        $result_unsorted = Array();
        $sort_map = Array();
        foreach ($this->getCollection() as $k => $v) {
            if ((strtotime($v['date_expire']) > strtotime($expired)) && $v['quantity_remain']) {
                $remain = strtotime($v['date_expire'])- strtotime($expired);
                $sort_map[$k] = $remain;
                $result_unsorted[$k]=Array(                    
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
        
        foreach (array_keys($sort_map) as $sort_key){
            $result[$sort_key] = $result_unsorted[$sort_key];
        }
                
        return $result;
    }

    //private
    private function _cleanBookings() {
        $expired = date('Y-m-d H:i:s', strtotime('now - ' . $this->_booking_expiring . ' hours'));
        $query = 'DELETE FROM `booked_donations` WHERE `date_booked` < "' . $expired . '" AND `delivered` = 0';
        $this->db->query($query);
    }

    private function _buildCollection($refresh = false) {
        $this->_cleanBookings();
        $this->_collection = Array();
        foreach ($this->_donations->_getCollection($refresh) as $row) {
            if ($row['location_id']) {
                $this->_collection[$row['id']] = $this->_getCollectionEntry($row);
            }
        }
    }

    private function _getCollectionEntry($row) {

        $booking = $this->getBooked(['donation_id' => $row['id']]);
        $result = $row;
        $this->_locations->_load($row['location_id']);
        $location_data = $this->_locations->_getData();
        $result['location_data'] = is_array($location_data) ? $location_data : Array();
        $result['computed']['food_type_path'] = $this->_getFoodTypePath($row['food_type_id']);
        $result['computed']['expire_two_row'] = $this->_formatDateTwoRow($row['date_expire']);
        $result['computed']['status_html'] = $this->_getStatusHtml($row['date_expire']);
        $result['computed']['status_bool'] = $this->_getStatusBool($row['date_expire']);

        $result['quantity_booked'] = $booking['total'];
        $result['quantity_remain'] = $row['quantity'] - $booking['total'];
        $result['booking'] = $booking['entries'];
        return $result;
    }

    private function _getFoodTypePath($id) {
        $food_types = $this->_foodTypes->_getCollection();
        $result = '';
        if (isset($food_types[$id])) {
            $result = $food_types[$id]['title'];
            $current_id = $id;
            while ($food_types[$current_id]['parent_id'] != 0) {
                $current_id = $food_types[$current_id]['parent_id'];
                $result = $food_types[$current_id]['title'] . ' / ' . $result;
            }
        }

        return $result;
    }

    private function _formatDateTwoRow($date) {
        return date('Y-m-d', strtotime($date)) . '<br>' . date('H:i:s', strtotime($date));
    }

    private function _getStatusHtml($date) {
        $timeRemain = $this->_getRemainTime($date);
        return ((strtotime('now') > strtotime($date)) ? '<span class="label label-danger">Expired</span>' : $timeRemain);
    }

    private function _getStatusBool($date) {
        return ((strtotime('now') < strtotime($date)));
    }

    private function _getRemainTime($time) {
        $hours = floor((strtotime($time) - time()) / (60 * 60));
        $minutes = floor((strtotime($time) - time() - $hours * (60 * 60)) / (60));
        return (($hours > 0) ? $hours . ' hours and ' : '') . $minutes . ' min';
    }

    private function _getAllergensStatement($flags = Array()) {
        $result = '';
        $template = '______________';

        $statements = Array();
        foreach ($flags as $flag) {
            $statements[] = ' AND `d`.`allergens` NOT LIKE "' . substr_replace($template, '1', $flag, 1) . '"';
        }
        if (count($statements)) {
            $result = implode(' ', $statements);
        }

        return $result;
    }

}
