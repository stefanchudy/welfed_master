<?php

use Utility\Validator;

Class Controller extends System\MainController {

    public function init() {
        $return_link = (isset($this->input->get['return'])) ? '?filter=' . $this->input->get['return'] : '';

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];
            $this->db->query('DELETE FROM `api_log` WHERE `id`=' . $id);
        } else {
            if (isset($this->input->get['filter'])) {
                $filter = json_decode(base64_decode($this->input->get['filter']), TRUE);

                $query = 'DELETE FROM `api_log`
                           WHERE `remote_addr` = "' . $filter['ip'] . '"
                             AND  `token` = "' . $filter['token'] . '"';
                if (isset($filter['origin'])) {
                    $query .= ' AND `origin` = "' . $filter['origin'] . '"';
                }
                if (isset($filter['call'])) {
                    $query .= ' AND `method` = "' . $filter['call'] . '"';
                }

                $this->db->query($query);
            }
        }

        $this->redirect('admin/remote-log' . $return_link);
    }

}
