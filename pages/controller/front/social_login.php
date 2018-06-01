<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_sociallogin $model_sociallogin
     */
    protected $model_sociallogin;

    public function init() {
        $this->loadModel('sociallogin');
        if (isset($this->input->get['provider'])) {
            $this->model_sociallogin->loadProviderSetup($this->input->get['provider']);
            $this->_processUser($this->model_sociallogin->connectProvider());
        }

        if (isset($this->input->get['hauth_start']) || isset($this->input->get['hauth_done'])) {
            $this->model_sociallogin->processEndpoint();
        }
    }

    private function _processUser($_user) {
//        $this->debug($this->user);
        if ($user = $this->user->getUserByEmail($_user->email)) {
            $this->user->socialLogin($user);
            $this->redirect('');
        } else {
            $new_pass = $this->user->generatePassword(8);
            $new_id = $this->user->register($_user->email, $new_pass, $_user->displayName);
            $new_image = $this->_copyImage($new_id, $_user->photoURL);
            if ($new_id) {
                $this->user->set_data($new_id, Array(
                    'first_name' => $_user->firstName,
                    'last_name' => $_user->lastName,
                    'mobile_phone' => $_user->phone,
                    'profile_image' => $new_image
                ));                
                $this->user->socialLogin($this->user->getUserByEmail($_user->email));
                
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
                
                $this->redirect('');
            } else {
                die('unable to register the user');
            }
        }
    }

    private function _copyImage($id, $url) {
        if (!file_exists(Utility\Paths::$upload)) {
            mkdir(Utility\Paths::$upload, '0777');
        }
        $images_path = Utility\Paths::$upload . 'profile_images';
        if (!file_exists($images_path)) {
            mkdir($images_path, '0777');
        }
        $file_name = $images_path .DIRECTORY_SEPARATOR. 'user_' . $id . '.' . pathinfo($url, PATHINFO_EXTENSION);
        if(strpos($file_name, '?')){
            $file_name = explode('?',$file_name);
            $file_name = $file_name[0];
        }
        if (copy($url, $file_name)) {
            return str_replace('\\', '/', str_replace(Utility\Paths::$www, '', $file_name));
        } else {
            return '';
        }
    }

}
