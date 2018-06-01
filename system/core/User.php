<?php

namespace System;

/****
 * Description of User
 * @return \System\User
 * @author martin
 */
class User extends \Utility\MainUtility {

    /**
     * Database object
     * @var \System\Db
     */
    protected $db = null;
    protected $input = null;
    public $logged = false;
    public $data = Array();
    protected $config = Null;

    public function __construct() {
        $this->config = \System\Config::getInstance();
        $this->db = \System\DB::getInstance();
        $this->input = \System\PageInput::getInstance();
        $this->db_settings = \System\DB_settings::getInstance();

        $this->checkSession();
    }

    public function register($_email, $pass, $_screen_name = NULL, $_access = NULL) {
        $email = $this->db->escape($_email);
        $screen_name = (($_screen_name !== NULL) ? $this->db->escape($_screen_name) : $email);
        $access = (($_access === NULL) ? str_repeat('0', 50) : $_access);
        if ($this->exists($email)) {
            \System\Alerts::addError('Cannot register. The entered e-mail already exists!');
            return false;
        }

        $result = $this->db->query('INSERT INTO `users` (`email`,`screen_name`,`password`,`access`) VALUES ("' . $email . '","' . $screen_name . '","' . md5($pass) . '", "' . $access . '")');

        if ($result->error == 0) {
            $id = $result->insert_id;
            if (isset($this->config->db['users_data'])) {
                $user_data = $this->db->query('INSERT INTO `' . $this->config->db['users_data'] . '` (`' . $this->config->db['users_data_key'] . '`) VALUES (' . $id . ')');
            }
            return $result->insert_id;
        } else {
            \System\Alerts::addError('Cannot register. Database error!');
            return FALSE;
        }
    }

    public function login($email, $pass) {
        $result = FALSE;
        $query = $this->db->query('SELECT * FROM `users` WHERE `email` = "' . $email . '"');
        if ($query->num_rows === 1) {
            $row = $query->rows[0];
            if ($row['password'] == md5($pass)) {
                $this->createSession($row['id'], $row['email'], $row['password']);
                $this->checkSession();
                $result = TRUE;
            }
        }

        return $result;
    }

    public function logOff($redirect = TRUE) {
        $this->db->query('DELETE FROM `sessions` WHERE `id`=' . $_SESSION['session_id']);
        unset($_SESSION['user_id']);
        unset($_SESSION['session_id']);
        unset($_SESSION['token']);
        $this->logged = false;
        if ($redirect) {
            header("Location: /");
        }
    }

    protected function edit($id, $param) {
        $query = $this->db->query('UPDATE `users` ' . $this->db->buildQuery($param, TRUE) . ' WHERE `id`=' . $id);
        if ($query->error == 0) {
            if ($this->logged) {
                if ($this->logged['id'] == $id) {
                    foreach ($param as $key => $value) {
                        $this->logged[$key] = $value;
                    }
                }
            }
        } else {
            \System\Alerts::addError('Database error : Unable to update the user data. MySQL error code ' . $query->error);
        }
    }

    public function set_data($id, $param) {
        $result = false;
        if (isset($this->config->db['users_data'])) {
            $query = $this->db->query('UPDATE `' . $this->config->db['users_data'] . '` ' . $this->db->buildQuery($param, TRUE) . ' WHERE `' . $this->config->db['users_data_key'] . '`=' . $id);
            if ($query->error == 0) {
                $result = true;
                if ($this->logged) {
                    if ($this->logged['id'] == $id) {
                        foreach ($param as $key => $value) {
                            $this->data[$key] = $value;
                        }
                    }
                }
            } else {
                \System\Alerts::addError('Database error : Unable to update the user data. MySQL error code ' . $query->error);
            }
        }
        return $result;
    }

    protected function createSession($user_id, $email, $pass) {
        $query = $this->db->query('INSERT INTO `sessions` (`expire`,`user_id`) VALUES (DATE_ADD(NOW(),INTERVAL +7 DAY),' . $user_id . ')');
        if ($query->error == 0) {
            $session_id = $query->insert_id;
            $session_key = $this->calkSessionKey($session_id, $user_id, $email, $pass);

            $query_session_key = $this->db->query('UPDATE `sessions` SET `token` = "' . $session_key . '" WHERE `id`=' . $session_id);
            if ($query_session_key->error == 0) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['session_id'] = $session_id;
                $_SESSION['token'] = $session_key;
            } else {
                \System\Alerts::addError('DB query error, User.php createSession 1');
            }
        } else {
            \System\Alerts::addError('DB query error, User.php createSession 2');
        }
    }

    protected function calkSessionKey($session_id, $user_id, $email, $pass) {
        return md5($email . $session_id . $pass . $user_id);
    }

    public function checkSession() {
        $check_session = (isset($_SESSION['user_id']) && isset($_SESSION['session_id']) && isset($_SESSION['token']));
        if ($check_session) {
            $user_id = $_SESSION['user_id'];
            $session_id = $_SESSION['session_id'];
            $token = $_SESSION['token'];

            $query_user = $this->db->query('SELECT * FROM `users` WHERE `id` = ' . $user_id);
            if ($query_user->num_rows == 1) {
                $user = $query_user->rows[0];

                $query_session = $this->db->query('SELECT * FROM `sessions` WHERE `token`="' . $token . '" AND `expire`>NOW()');
                if ($query_session->num_rows == 1) {
                    $session = $query_session->rows[0];
                    if ($token !== $this->calkSessionKey($session['id'], $user['id'], $user['email'], $user['password'])) {
                        \System\Alerts::addError('Invalid session token');
                        $this->logOff();
                        return;
                    } else {
                        $this->logged = Array(
                            'id' => $user['id'],
                            'email' => $user['email'],
                            'screen_name' => $user['screen_name'],
                            'access' => $user['access']
                        );
                        if (isset($this->config->db['users_data'])) {
                            $query_data = $this->db->query('SELECT * FROM `' . $this->config->db['users_data'] . '` WHERE `' . $this->config->db['users_data_key'] . '` = ' . $user['id']);
                            if (($query_data->error == 0) && ($query_data->num_rows == 1)) {
                                $this->logged['data'] = $query_data->rows[0];
                            } else {
                                \System\Alerts::addError('Unable to read the user data table.');
                            }
                        }
                    }
                } else {
                    \System\Alerts::addError('Invalid session token, User.php checkSession 1');
                    $this->logOff();
                    return;
                }
            } else {
                $this->logOff();
                \System\Alerts::addError('Wrong user ID, User.php checkSession 1');
                return;
            }
        } else {
            return;
        }
    }

    public function exists($email) {
        $query = $this->db->query('SELECT COUNT(`id`) AS `count` FROM `users` WHERE `email`="' . $this->db->escape($email) . '"');
        return ($query->rows[0]['count'] != 0);
    }

    public function generatePassword($chars, $used = '1234567890abcdefghijklmnopqrstuvqxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $result = '';
        for ($i = 0; $i < $chars; $i++) {
            $random = rand(0, mb_strlen($used) - 1);
            $result .= $used[$random];
        }
        return $result;
    }

    public function setAccess($user_id, $access_key, $access_value = NULL) {
        $access = Array();
        $getAccess = $this->db->query('SELECT `access` FROM `users` WHERE `id`=' . $user_id)->rows[0]['access'];
        for ($i = 0; $i < strlen($getAccess); $i++) {
            $access[$i] = $getAccess[$i];
        }
        if ($access_value == NULL) {
            $access[$access_key] = (!$access[$access_key]);
        } else {
            $access[$access_key] = $access_value;
        }
        $newAccess = implode('', $access);
        $this->db->query('UPDATE `users` SET `access`="' . $newAccess . '" WHERE `id` = ' . $user_id);
    }

    public function getUserById($id) {
        $query_user = $this->db->query('SELECT * FROM `users` WHERE `id` = ' . $id);

        if ($query_user->num_rows == 1) {
            $user = $query_user->rows[0];

            if (isset($this->config->db['users_data'])) {
                $query_data = $this->db->query('SELECT * FROM `' . $this->config->db['users_data'] . '` WHERE `' . $this->config->db['users_data_key'] . '` = ' . $id);
                if (($query_data->error == 0) && ($query_data->num_rows == 1)) {
                    $user['data'] = $query_data->rows[0];
                }
            }

            return $user;
        } else {
            return NULL;
        }
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM `users` WHERE `id`=' . $id);
        $this->db->query('DELETE FROM `sessions` WHERE `user_id`=' . $id);
        if (isset($this->config->db['users_data'])) {
            $this->db->query('DELETE FROM `' . $this->config->db['users_data'] . '` WHERE `user_id`=' . $id);
        }
    }

}
