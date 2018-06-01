<?php

class model_api extends \System\Model {

    /**
     *
     * @var \Utility\OrmDataset $_log 
     */
    private $_log = null;

    const RESPONSE_OK = 0;
    const RESPONSE_INVALID_CONTROLLER = 1;
    const RESPONSE_INVALID_TOKEN = 2;

    private $_resultMessages = array(
        self::RESPONSE_OK => 'Ok',
        self::RESPONSE_INVALID_CONTROLLER => 'Invalid API method.',
        self::RESPONSE_INVALID_TOKEN => 'Invalid token.',
    );
    private $_responseStatusCode = self::RESPONSE_OK;
    //private $_headerStatus = '"HTTP/1.1 200 OK"';
    private $_headerStatus = array(
        self::RESPONSE_OK => "HTTP/1.1 200 OK",
        self::RESPONSE_INVALID_CONTROLLER => "HTTP/1.1 404 Not Found",
        self::RESPONSE_INVALID_TOKEN => "HTTP/1.1 403 Forbidden"
    );
    private $_logNr = null;
    private $_params = null;
    private $_siteId = null;
    private $_token = null;
    private $_origin = null;
    private $_request = null;

    public function init() {
        $this->_log = new \Utility\OrmDataset('api_log');
        $this->_log->_init();

        $request_data = json_decode(trim(file_get_contents("php://input")), TRUE);

        $this->_params = isset($request_data['params']) ? $request_data['params'] : array();
        $this->_token = isset($request_data['token']) ? $request_data['token'] : null;
        $this->_origin = isset($request_data['origin']) ? $request_data['origin'] : null;

        $this->_request = $request_data;
    }

    public function initLog() {
        $this->_detectSiteId();
        $this->_determineStatusCode();

        $allowed = $this->_requestIsAllowed();
        $this->_log->_clear();

        if ($this->_logNr != null) {
            $this->_log->_load($this->_logNr);
        }

        $this->_log->_setData('remote_addr', $this->_getRemoteAddr())
                ->_setData('token', $this->_getAccessToken())
                ->_setData('method', $this->_getApiMethod())
                ->_setData('origin', $this->getOrigin())
                ->_setData('request_json', $this->db->escape($this->_getRequestJson()))
                ->_save();
        $this->_logNr = $this->_log->_getCurrentKey();


        return $allowed ? $this : $this->sendResponse();
    }

    public function getLogList() {
        $result = array();
        $query = $this->db->query('SELECT `log`.`remote_addr`,
                                          `log`.`token`,
                                          `rs`.`name`,
                                          COUNT(`log`.`remote_addr`) AS `count`,
                                          MAX(`log`.`timestamp`) AS `time`       
                                     FROM `api_log` AS `log`
                                     LEFT JOIN `remote_sites` as `rs`
                                       ON (`log`.`remote_addr` = `rs`.`ip`
                                            AND 
                                           `log`.`token` = `rs`.`token`)

                                    GROUP BY `remote_addr`,`token`,`name`');

        foreach ($query->rows as $row) {
            $result[] = array(
                'remote_addr' => $row['remote_addr'],
                'name' => $row['name'] ? $row['name'] : '',
                'count' => $row['count'],
                'time' => $row['time'],
                'valid' => $this->_requestValidString($row['remote_addr'], $row['name'], $row['token']),
                'filter' => base64_encode(
                        json_encode(
                                array(
                                    'ip' => $row['remote_addr'],
                                    'token' => $row['token'],
                                    'name' => $row['name'] ? $row['name'] : 'Invalid token',
                                )
                        )
                )
            );
        }
        return array(
            'table' => $result,
            'heading' => 'Remote connections history',
            'delete_link' => '',
            'return_link' => 'admin/dashboard'
        );
    }

    public function getLogOrigins($filter) {
        $result = array();
        $ip = $filter['ip'];
        $token = $filter['token'];
        $query = $this->db->query('SELECT `origin`, 
                         COUNT(`origin`) AS `count`,
                         MAX(`timestamp`) AS `time`
                    FROM `api_log`
                   WHERE `remote_addr` = "' . $ip . '" 
                     AND `token` = "' . $token . '"
                   GROUP BY `origin`');

        foreach ($query->rows as $row) {
            $result[] = array(
                'origin' => $row['origin'],
                'count' => $row['count'],
                'time' => $row['time'],
                'filter' => base64_encode(
                        json_encode(
                                array(
                                    'ip' => $ip,
                                    'token' => $token,
                                    'origin' => $row['origin'],
                                    'name' => $filter['name'],
                                )
                        )
                )
            );
        }

        return array(
            'table' => $result,
            'heading' => 'Connection list for IP <strong>' . $ip . '</strong> (' . $filter['name'] . ')',
            'delete_link' => '',
            'return_link' => 'admin/remote-log'
        );
    }

    public function getLogSummary($filter) {
        $result = array();
        $ip = $filter['ip'];
        $token = $filter['token'];
        $origin = $filter['origin'];
        $query = $this->db->query('SELECT `method`, 
                         COUNT(`method`) AS `count`,
                         MAX(`timestamp`) AS `time`
                    FROM `api_log`
                   WHERE `remote_addr` = "' . $ip . '" 
                     AND `token` = "' . $token . '"
                     AND `origin` = "' . $origin . '"
                   GROUP BY `method`');

        foreach ($query->rows as $row) {
            $result[] = array(
                'method' => $row['method'],
                'count' => $row['count'],
                'time' => $row['time'],
                'filter' => base64_encode(
                        json_encode(
                                array(
                                    'ip' => $ip,
                                    'token' => $token,
                                    'origin' => $origin,
                                    'call' => $row['method'],
                                    'name' => $filter['name'],
                                )
                        )
                )
            );
        }

        $return_filter = base64_encode(
                json_encode(
                        array(
                            'ip' => $ip,
                            'token' => $token,
                            'name' => $filter['name'],
                        )
        ));

        return array(
            'table' => $result,
            'heading' => 'Connection list for IP <strong>' . $filter['ip'] . '</strong> (' . $filter['name'] . ') <br><small><strong>' . $origin . '</strong> controller</small>',
            'delete_link' => '',
            'return_link' => 'admin/remote-log?filter=' . $return_filter
        );
    }

    public function getLogEntry($filter) {
        $table = $this->db->query('SELECT * 
                                   FROM `api_log` 
                                  WHERE `remote_addr` = "' . $filter['ip'] . '" 
                                    AND `token` = "' . $filter['token'] . '"
                                    AND `origin` = "' . $filter['origin'] . '"
                                    AND `method` = "' . $filter['call'] . '"
                                  ORDER BY `timestamp` DESC LIMIT 50')->rows;

        $return_filter = base64_encode(
                json_encode(
                        array(
                            'ip' => $filter['ip'],
                            'token' => $filter['token'],
                            'origin' => $filter['origin'],
                            'name' => $filter['name'],
                            'deep' => 3
                        )
                )
        );

        return array(
            'table' => $table,
            'heading' => 'Connection list for IP <strong>' . $filter['ip'] . '</strong> (' . $filter['name'] . ') <br><small><strong>' . $filter['origin'] . '</strong> controller<br><strong>' . $filter['call'] . '</strong> call</small>',
            'return_link' => 'admin/remote-log?filter=' . $return_filter,
            'delete_link' => '',
        );
    }

    public function sendResponse($data = null) {
        header($this->_headerStatus[$this->_responseStatusCode]);
        header('Content-Type: application/json');

        $response = json_encode(array(
            'status' => array(
                'code' => $this->_responseStatusCode,
                'message' => $this->_resultMessages[$this->_responseStatusCode],
            ),
            'data' => $this->_requestIsAllowed() ? $data : array()
        ));

        if ($this->_logNr) {
            $this->_log->_load($this->_logNr)
                    ->_setData('response_json', $this->db->escape($response));
            $this->_log->_save();
        }

        echo $response;
    }

    public function getParams($key = null) {
        if ($key === null) {
            return $this->_params;
        } else {
            if (isset($this->_params[$key])) {
                return $this->_params[$key];
            } else {
                return null;
            }
        }
    }

    public function getRequest() {
        return $this->_request;
    }

    public function getOrigin() {
        return$this->_origin;
    }

    public function getSiteId() {
        return (int) $this->_siteId;
    }

    public function getSiteData($site_id = null) {
        $result = array(
            'users' => array(),
            'locations' => array(),
            'donations' => array()
        );
        if ($site_id === null) {
            $site_id = $this->getSiteId();
        }

        $query_users = $this->db->query('SELECT `user_id` AS `id` FROM `users_data` WHERE `site_id` = ' . $site_id);
        foreach ($query_users->rows as $row) {
            $result['users'][] = $row['id'];
        }

        $query_locations = $this->db->query('SELECT `id` FROM `pickup_locations` WHERE `user_id` IN (' . implode(',', $result['users']) . ')');
        foreach ($query_locations->rows as $row) {
            $result['locations'][] = $row['id'];
        }

        $query_donations = $this->db->query('SELECT `id` FROM `donations` WHERE `location_id` IN (' . implode(',', $result['locations']) . ')');
        foreach ($query_donations->rows as $row) {
            $result['donations'][] = $row['id'];
        }

        return $result;
    }

    public function getSiteAdminId() {
        $query = $this->db->query('SELECT `admin_mail` FROM `remote_sites` WHERE `id` = ' . $this->getSiteId());
        if (!$query->error && ($query->rows)) {
            $admin_mail = $query->rows[0]['admin_mail'];
            $user = $this->user->getUserByEmail($admin_mail);
            return $user['id'];
        }
    }

    private function _detectSiteId() {
        if ($token = $this->_getAccessToken()) {
            $query = $this->db->query('SELECT * FROM `remote_sites` WHERE `ip`="' . $this->_getRemoteAddr() . '" AND `token`="' . $token . '"');
            if ($query->num_rows != 0) {
                $this->_siteId = $query->rows[0]['id'];
            }
        }
        return $this;
    }

    private function _requestIsAllowed() {
        return ($this->_siteId !== NULL);
    }

    private function _determineStatusCode() {
        $status = self::RESPONSE_OK;
        if (!isset($this->config->routes['api/' . $this->_getApiMethod()])) {
            $status = self::RESPONSE_INVALID_CONTROLLER;
        }
        if (!$this->_requestIsAllowed()) {
            $status = self::RESPONSE_INVALID_TOKEN;
        }
        $this->_responseStatusCode = $status;
        return $this;
    }

    private function _requestValidString($ip, $name, $token) {
        $result = array(
            'text' => 'Invalid token',
            'class' => 'danger'
        );
        if ($token && $name) {

            $result = array(
                'text' => 'Allowed',
                'class' => 'success'
            );
        }

        return $result;
    }

    private function _getRemoteAddr() {
        return $this->input->remote_addr;
    }

    private function _getAccessToken() {
        return $this->_token;
    }

    private function _getApiMethod() {
        $split = explode('/', $this->input->url);
        return isset($split[1]) ? $split[1] : 'Not specified';
    }

    private function _getRequestJson() {
        return json_encode($this->_reduceArray($this->getRequest()));
    }

    private function _reduceArray($array) {
        if (mb_strlen(json_encode($array)) > 65535) {
            $fieldSizes = array();
            foreach ($array as $key => $value) {
                //$fieldSizes[$key] = is_array($value) ? mb_strlen(json_encode($value)) : mb_strlen($value);
                $fieldSizes[$key] = is_string($value) ? mb_strlen($value) : mb_strlen(json_encode($value));
            }
            arsort($fieldSizes);
            reset($fieldSizes);
            $array[key($fieldSizes)] = 'Data too long';

            return $this->_reduceArray($array);
        } else {
            return $array;
        }
    }

}
