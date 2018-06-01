<?php

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {
        
        $this->html->loadHeader = False;
        $this->html->loadFooter = False;

        if ($this->db->query('SELECT `id` FROM `users` WHERE `access` LIKE "1%"')->num_rows == 0) {
            $this->user->register('admin@wellfedfoundation.org', '123456', '1' . str_repeat('0', 49));
            $this->user->alerts->notify[] = 'No registered administrators. Use username "admin@wellfedfoundation.org" and password "123456"';
        }

        if (isset($this->input->post['email']) && isset($this->input->post['password'])) {
            //$this->debug($this->input->post);
            if (!$this->user->login($this->input->post['email'], $this->input->post['password'])) {
                $this->html->alerts->errors[] = '<strong>Access denied!</strong> Wrong login details.';
            } else {
                if ($this->user->isAdmin()) {
                    $this->html->setUser($this->user->logged);
                    $this->redirect('admin/dashboard');
                } else {
                    $this->user->logOff();                    
                }
            }
        }

        $this->html->setTitle($this->config->main['short_name'].' Administration');
        $this->html->render($this->pageData, 'admin/login');
    }

}
