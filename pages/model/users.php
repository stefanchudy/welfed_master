<?php

class model_users extends \System\Model {

    /**
     *
     * @var array $users 
     */
    private $users = Array();

    /**
     *
     * @var \Utility\OrmDataset $users_table
     */
    private $users_table = null;

    /**
     * 
     * @var \Utility\OrmDataset $users
     */
    private $users_data = NULL;

    public function init() {
        $this->users_table = new \Utility\OrmDataset('users');
        $this->users_table->_set_Order_by('email');
        $this->users_table->_init();

        foreach ($this->users_table->_getCollection() as $value) {
            $this->users[$value['id']] = $value;
            $this->users[$value['id']]['admin_link'] = $this->_getAdminLink($value);
        }

        if (isset($this->config->db['users_data'])) {
            $this->users_data = new \Utility\OrmDataset($this->config->db['users_data']);
            $this->users_data->_set_Order_by('id');
            $this->users_data->_init();

            foreach ($this->users_data->_getCollection() as $value) {
                $this->users[$value['user_id']]['data'] = $value;
            }
        }
    }

    public function getUserSellector($id, $selected = NULL) {
        $result = '';
        $users = $this->users;
        if ($selected === NULL) {
            $selected = $this->user->logged['id'];
        }
        $result.='<select name="' . $id . '" id="' . $id . '" class="form-control">';

        foreach ($users as $user) {
            $user_access = $user['access'][0];
            if ($user['data']['ban'] || (($user_access == 0) && ($user['data']['advanced'] == 0)))
                continue;
            $selection = ($user['id'] == $selected ? ' selected="selected"' : '');
            $result.='<option value="' . $user['id'] . '"' . $selection . '>' . $user['email'] . (($user['id'] == $this->user->logged['id']) ? ' (you)' : '') . '</option>';
        }
        $result.='</select>';
        return $result;
    }

    public function getUsers() {
        return $this->users;
    }
    private function _getAdminLink($user){
        $id = $user['id'];
        $access = (int)($user['access'][0]);
        
        $link = ['users','administrators'];
        return 'admin/'.$link[$access].'/edit?id='.$id;
    }

}
