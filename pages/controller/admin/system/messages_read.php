<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];

            $messages = $this->model_common->getMessages();
            //$this->debug($messages);
            if (isset($messages['msg'][$id])) {
                $this->pageData['message'] = $messages['msg'][$id];
                $this->pageData['heading'] = 'Read message';
                $this->pageData['origin'] = \Utility\Messaging::getMessageType($messages['msg'][$id]['type']);
                if ($this->pageData['message']['read'] == 0) {
                    $this->db->query('INSERT INTO `contact_to_user` (`user_id`,`message_id`) VALUES (' . $this->user->logged['id'] . ',' . $id . ')');
                }
                $this->pageData['dashboard'] = $this->model_common->getDashboardData();
            } else {
                $this->redirect('admin/messages');
            }
        } else {
            $this->redirect('admin/messages');
        }

        $this->html->setTitle($this->site_name . 'ZEM Administration|Messages');

        $this->html->render($this->pageData, 'admin/system/message');
    }

}
