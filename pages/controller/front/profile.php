<?php

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    /**
     *
     * @var model_foods $model_foods
     */
    protected $model_foods = Null;

    public function init() {
        if (!$this->user->logged) {
            $this->redirect('');
        }
        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');
        $this->pageData['tab'] = 0;
        if (isset($this->input->get['tab'])) {
            $this->pageData['tab'] = (int) $this->input->get['tab'];
        }

        $this->loadModel('foods');

        $this->pageData['food_types_selector'] = $this->model_foods->getSelector((isset($this->input->post['apply']['food_type_id']) ? (int) $this->input->post['apply']['food_type_id'] : 0), 'food_type_id', 'apply[food_type_id]');

        $upload = $this->upload_file('user_image', 'profile_images' . DIRECTORY_SEPARATOR . 'user_' . $this->user->logged['id']);
        if ($upload['success']) {
            $this->user->update($this->user->logged['id'], Array(), Array(
                'profile_image' => 'upload/profile_images/' . $upload['file']
            ));
        } else {
            if ($upload['messages'][0] != 'No upload') {
                foreach ($upload['messages'] as $message) {
                    \System\Alerts::addError($message);
                }
            }
        }

        if (count($this->input->post)) {
            if (isset($this->input->post['profile'])) {
                $this->_setProfileValidation();
                $data = Array(
                    'first_name' => $this->input->post['profile']['first_name'],
                    'last_name' => $this->input->post['profile']['last_name'],
                    'mobile_phone' => $this->input->post['profile']['mobile_phone'],
                    'preferences' => (int) $this->input->post['profile']['preferences'],
                    'alergies' => '@"' . implode('', $this->input->post['profile']['allergy']) . '"'
                );
                $errors_profile = $this->validator->validateAll($data);
                if (count($errors_profile)) {
                    $this->errors = $errors_profile;
                    $this->errors['general'] = ['There are errors in the form. The operation was aborted.'];
                    $this->pageData['tab'] = 0;
                } else {
                    $this->user->update($this->user->logged['id'], ['screen_name' => $data['first_name'] . ' ' . $data['last_name']], $data);
                }
            }

            if (isset($this->input->post['change'])) {
                $this->_setPassValidation();
                $errors_pass = $this->validator->validateAll($this->input->post['change']);

                if (count($errors_pass)) {
                    $this->pageData['tab'] = 1;
                    $this->errors = $errors_pass;
                    $this->errors['general'] = ['There are errors in the form. The operation was aborted.'];
                } else {
                    $this->user->update($this->user->logged['id'], ['password' => $this->input->post['change']['pass1']]);
                    $this->user->login($this->user->logged['email'], $this->input->post['change']['pass1']);
                    $this->pageData['success_message'] = 'The password has been changed.';
                }
            }

            if (isset($this->input->post['apply'])) {
                $this->_setApplyValidation();
                $errors_apply = $this->validator->validateAll($this->input->post['apply']);

                $this->pageData['accept_terms'] = (int) $this->input->post['apply']['accept_terms'];

                if (count($errors_apply)) {
                    $this->pageData['tab'] = 4;
                    $this->errors = $errors_apply;
                    $this->errors['general'] = ['There are errors in the form. The operation was aborted.'];
                } else {
                    $this->pageData['success_message'] = 'Your application has been received';
                    $this->user->applyUpgrade($this->user->logged['id']);
                    $this->user->logged['data']['upgrade_application'] = 1;
                    $this->pageData['tab'] = 4;

                    $this->_sendUpgradeNotification();
                    
                    Utility\Messaging::createMessage(
                            Array(
                                'type' => Utility\Messaging::MESSAGE_TYPE_UPGRADE_APPLICATION,
                                'name' => $this->user->logged['data']['first_name'] . ' ' . $this->user->logged['data']['last_name'],
                                'email' => $this->user->logged['email'],
                                'phone' => $this->user->logged['data']['mobile_phone'],
                                'message' => $this->_getUgradeMessageText()
                    ));
                }
            }
        }

        $user = $this->user->getUserById($this->user->logged['id']);

        $this->pageData['is_admin'] = $this->user->isAdmin();
        $this->pageData['profile_image'] = ($user['data']['profile_image'] != '' ? $user['data']['profile_image'] : 'http://placehold.it/250x250');
        $this->pageData['full_name'] = $user['data']['first_name'] . ' ' . $user['data']['last_name'];
        $this->pageData['allergy'] = str_split($user['data']['alergies']);
        $this->pageData['user_profile'] = $user;

        $this->html->setTitle($this->short_name . ' | My account');
        $this->renderPage('front/profile');
    }

    private function _setProfileValidation() {
        $this->validator->clear();
        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_MAX_LENGTH, 50);

        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_MAX_LENGTH, 50);

        $this->validator->addValidation('mobile_phone', Utility\Validator::PATTERN_MAX_LENGTH, 20);
        $this->validator->addValidation('mobile_phone', Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('mobile_phone', Utility\Validator::PATTERN_FORBIDDEN);

        return $this;
    }

    private function _setPassValidation() {
        $this->validator->clear();
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_MIN_LENGTH, 6, 'The password cannot be shorter than 6 characters.');
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_MAX_LENGTH, 20, 'The password cannot be longer than 20 characters.');
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_REQUIRED, NULL, 'You must provide password');
        $this->validator->addValidation('pass2', Utility\Validator::PATTERN_CUSTOM_FUNCTION, function() {
            return ($this->input->post['change']['pass1'] == $this->input->post['change']['pass2']);
        }, 'The two passwords does not match');
        return $this;
    }

    private function _setApplyValidation() {
        $this->validator->clear();

        $this->validator->addValidation('accept_terms', Utility\Validator::PATTERN_MIN_VALUE, 1, 'You must read and accept our terms.');
        return $this;
    }

    private function _getUgradeMessageText() {
        $message = '<h1>Account upgrade application</h1><hr>';
        $message .= '<a class="btn btn-success" style="margin-right:16px;" href="admin/users/upgrade?id=' . $this->user->logged['id'] . '">Approve</a>';
        $message .= '<a class="btn btn-danger" href="admin/users/reject?id=' . $this->user->logged['id'] . '">Reject</a><br><br>';    
        $message .= '<hr>';
        
        return $message;
    }

    private function _sendUpgradeNotification() {
        if ($this->mailer) {
            $message = $this->renderWidget('templates/mail_body', array('body' => $this->renderWidget('templates/notifications/upgrade_user', array('user_name' => $this->user->getUserNameById()))));

            $send_user = clone $this->mailer;
            $send_user->Subject = 'Well Fed Foundation : Account upgrade request';
            $send_user->msgHTML($message);
            $send_user->clearAllRecipients();
            $send_user->addAddress($this->user->logged['email']);
            $send_user->send();
        }
        return $this;
    }

}
