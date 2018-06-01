<?php
/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {
        if ($this->user && $this->user->logged) {
            $this->html->setUser($this->user->logged);
        } else {
            $this->redirect('index');
        }
        $error = 0;
        if (isset($this->input->get['id'])) {            
            $this->db->query('DELETE FROM `contact` WHERE `id`=' . (int)$this->input->get['id']);            
            $this->db->query('DELETE FROM `contact_to_user` WHERE `message_id`=' . (int)$this->input->get['id']);            
            $this->db->query('DELETE FROM `contact_to_offer` WHERE `message_id`=' . (int)$this->input->get['id']);            
        }
        $this->redirect('admin/messages');
    }

}
