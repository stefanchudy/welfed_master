<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    protected $model_remotesites = null;

    public function init() {
        $this->loadModel('common');
        $this->loadModel('remotesites');
        $result = $this->_createSession();

        $this->model_api->sendResponse($result ? $result : array('error' => 'invalid session data'));
    }

    private function _createSession() {
        $this->user->setSite($this->model_api->getSiteId());
        $request_data = $this->model_api->getParams();
        if (isset($request_data['user_id'], $request_data['email'], $request_data['pass'])) {
            $user_id = $request_data['user_id'];
            $email = $request_data['email'];
            $pass = $request_data['pass'];

            $query = $this->db->query('INSERT INTO `sessions` (`expire`,`user_id`) VALUES (DATE_ADD(NOW(),INTERVAL +7 DAY),' . $user_id . ')');

            if ($query->error == 0) {
                $session_id = $query->insert_id;

                $session_key = md5($email . $session_id . $pass . $user_id);
                $query_session_key = $this->db->query('UPDATE `sessions` SET `token` = "' . $session_key . '" WHERE `id`=' . $session_id);
                if ($query_session_key->error == 0) {
                    return array(
                        'session_id' => $session_id,
                        'token' => $session_key
                    );
                }
            }
        }
        return FALSE;
    }

}
