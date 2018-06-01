<?php

class Controller extends System\MainController {

    public function init() {        
        $this->_setValidation();
        
        if (isset($this->input->post['email'])) {
            
            $this->pageData['email'] = $this->input->post['email'];

            $this->errors = $this->validator->validateAll($this->input->post);
                        
            if (count($this->errors) == 0) {
                
                $new_pass = $this->user->generatePassword(8);
                $user = $this->user->getUserByEmail($this->input->post['email']);
                
                
                $this->mailer->Subject = 'Forgotten password retrieval.';
                $this->mailer->msgHTML('Your new password for the MMC administration is <strong>' . $new_pass . '</strong>');
                $this->mailer->addAddress($user['email'], $user['screen_name']);

                if ($this->mailer->send()) {
                    $this->user->update($user['id'], Array(                        
                        'password' => $new_pass
                            )
                    );
                    $this->pageData['success_message'] = 1;
                }
            }

        } else {
            $this->pageData['email'] = '';
        }

        if ($this->user && $this->user->logged) {
            $this->redirect('index');
        }

        $this->html->setTitle($this->short_name.' | Password restore');
        $this->renderPage('front/forgotten_password');        
    }

    private function _setValidation(){
        $this->validator->clear();
        
        $this->validator->addValidation('email', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('email', \Utility\Validator::PATTERN_EMAIL);       
        $this->validator->addValidation('email', \Utility\Validator::PATTERN_CUSTOM_FUNCTION, function($param) {
            return $this->user->exists($param);
        }, 'The entered e-mail does not match to any user in the database!');
        
    }
}
