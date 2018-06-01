<?php

class Controller extends System\MainController {

    /**
     *
     * @var \Utility\Messaging $messenger
     */
    private $messenger = null;

    public function init() {
        $this->html->setTitle($this->config->main['site_name'] . ' | Contact us');
        $this->html->addHeaderTag('<script type="text/javascript" src="theme/js/google-map.js"></script>');
        $this->html->addHeaderTag('<script src="https://maps.googleapis.com/maps/api/js?key=' . $this->db_settings->get('google_maps_api', '') . '" type="text/javascript"></script>');

//        $this->messenger = new Utility\Messaging();

        $this->_setValidation();


        if (isset($this->input->post['name'], $this->input->post['email'], $this->input->post['message'])) {

            $this->errors = $this->validator->validateAll($this->input->post);

            if (count($this->errors) == 0) {

                if (isset($this->input->post['_full_name']) && $this->input->post['_full_name'] == '') {
                    $send_id = Utility\Messaging::createMessage(
                                    Array(
                                        'name' => $this->input->post['name'],
                                        'email' => $this->input->post['email'],
                                        'message' => $this->input->post['message'],
                                        'type' => \Utility\Messaging::MESSAGE_TYPE_CONTACT_FORM
                    ));
                    $this->_sendNotification($this->input->post['name'],$this->input->post['email']);
                    $this->pageData['message_sent'] = $send_id;
                } else {
                    // Bot!                    
                    $this->pageData['message_sent'] = NULL;
                }
            }
        }

        $this->renderPage('front/contact');
    }

    private function _setValidation() {
        $this->validator->addValidation('name', Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('name', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('name', Utility\Validator::PATTERN_MIN_LENGTH, 3);
        $this->validator->addValidation('name', Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->validator->addValidation('name', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);

        $this->validator->addValidation('email', Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('email', Utility\Validator::PATTERN_EMAIL);
        $this->validator->addValidation('email', Utility\Validator::PATTERN_MIN_LENGTH, 3);
        $this->validator->addValidation('email', Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->validator->addValidation('email', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);

        $this->validator->addValidation('message', Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('message', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('message', Utility\Validator::PATTERN_MIN_LENGTH, 3);
        $this->validator->addValidation('message', Utility\Validator::PATTERN_MAX_LENGTH, 50);
        $this->validator->addValidation('message', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
    }

    private function _sendNotification($user_name, $email){
        $message = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/contact_form', array('user_name'=>$user_name))));
        
        $send_user = clone $this->mailer;
        $send_user->Subject = 'Well Fed Foundation : Your message has been received';
        $send_user->msgHTML($message);
        $send_user->clearAllRecipients();
        $send_user->addAddress($email);
        $send_user->send();
                
    }
}
