<?php

if (($this->input->is_secure==0) && ($this->input->is_local==0)) {
    $https_redirect = $this->input->https_url . '/' . $this->input->url;
    
    if (count($this->input->get)) {
        $https_redirect .= '?' . http_build_query($this->input->get);
    }
    header('Location: ' . $https_redirect);
}

$url = explode('/', $this->input->url);
date_default_timezone_set('UTC');
if ($url[0] == 'admin') {
    $this->html->setCommonPath('admin/common');
    if (count($url) > 1) {
        if (!$this->user->isAdmin()) {
            $this->user->logOff();
        }
        $this->loadModel('common');
        $this->pageData['dashboard'] = $this->model_common->getDashboardData();
        $this->html->setHeaderTags($this->config->header_admin);
    } else {
        if ($this->user->isAdmin()) {
            $this->html->setUser($this->user->logged);
            $this->redirect('admin/dashboard');
        } else {
            if ($this->user->logged) {
                $this->user->logOff(false);
            }
        }
    }
} elseif($url[0]== 'api'){
    $this->loadModel('api');
    $this->model_api->initLog();
} else {
    if ($this->user->logged) {
        //logged
        if ($this->user->logged['data']['ban']) {
            $this->user->logOff(false);
        }
        if (isset($this->input->post['logout'])) {
            $this->user->logOff();
        }
        $this->html->setUser($this->user->getUserById($this->user->logged['id']));
    } else {
        //not logged  
        if (isset($this->input->post['login_form'])) {
            $form_data = $this->input->post['login_form'];
            if (!$this->user->login($this->db->escape($form_data['username']), $this->db->escape($form_data['password']))) {
                $this->errors['login_form'] = ['Invalid username or password.'];
            } else {
                $this->redirect('index');
            }
        }
        if (isset($this->input->post['register'])) {
            $errors = $this->user->add($this->input->post['register']);
            if (count($errors)) {
                $this->errors = $errors;
                $this->errors['register'] = 1;
            } else {
                if ($this->user->login($this->input->post['register']['email'], $this->input->post['register']['password'])) {  
                    
                    Utility\Messaging::sendWelcomeMessage(Array(
                            'email'=>$this->user->logged['email'],
                            'message'=>$this->renderWidget(
                                    'templates/mail_body', 
                                    array('body' => 
                                        $this->renderWidget(
                                                'templates/notifications/welcome', 
                                                array('user_name'=>$this->user->getUserNameById($this->user->logged['id'])))))
                            ));
                    $this->redirect('index');
                }
            }
        }
    }
    
}