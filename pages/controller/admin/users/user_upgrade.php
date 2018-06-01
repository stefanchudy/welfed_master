<?php

class Controller extends System\MainController {

    public function init() {

        $error = 0;
        if (!isset($this->input->get['id'])) {
            $this->redirect('admin/dashboard');
        }
        $id = $this->input->get['id'];
        $user = $this->user->getUserById($id);
        if ($user === NULL) {
            $this->redirect('admin/dashboard');
        }
        
        $this->user->upgradeUser($id);
        $this->_sendNotification($user);
        
        $access = $user['access'][0];
        $this->redirect('admin/' . ($access == 0 ? 'users' : 'administrators') . '/edit?id=' . $id);
    }

    private function _sendNotification($user){
        $user_name = $this->user->getUserNameById($user['id']);
        $message = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/upgrade_user_granted', array('user_name'=>$user_name))));
        
        $send_user = clone $this->mailer;
        $send_user->Subject = 'Well Fed Foundation : Account upgrade granted';
        $send_user->msgHTML($message);
        $send_user->clearAllRecipients();
        $send_user->addAddress($user['email']);
        $send_user->send();
                
    }
}
