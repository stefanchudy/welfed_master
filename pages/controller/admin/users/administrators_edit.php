<?php

/**
 * Description of Controller
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {

        date_default_timezone_set('UTC');

        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');

        $action = 'edit';
        $user_type = 1;

        $this->setValidation();

        if (isset($this->input->get['id'])) {
            $id = $this->input->get['id'];
            $upload = $this->upload_file('user-image', 'profile_images' . DIRECTORY_SEPARATOR . 'user_' . $id);
            if ($upload['success']) {
                $this->user->update($id, Array(), Array(
                    'profile_image' => 'upload/profile_images/' . $upload['file']
                ));
            } else {
                if ($upload['messages'][0] != 'No upload') {
                    foreach ($upload['messages'] as $message) {
                        \System\Alerts::addError($message);
                    }
                }
            }

            $user = $this->user->getUserById($id);

            $this->pageData['user_type'] = $user_type;
            $this->pageData['action'] = $action;

            $this->pageData['email'] = $user['email'];
            $this->pageData['first_name'] = $user['data']['first_name'];
            $this->pageData['last_name'] = $user['data']['last_name'];
            $this->pageData['mobile_phone'] = $user['data']['mobile_phone'];
            $this->pageData['profile_image'] = ($user['data']['profile_image'] != '') ? $user['data']['profile_image'] : 'http://placehold.it/250x350';
            $this->pageData['allergy'] = str_split($user['data']['alergies']);


            $this->pageData['locations'] = $user['locations'];
            $this->pageData['donations_issued'] = $user['donations_issued'];
            $this->pageData['donations_used'] = $user['donations_used'];
            $this->pageData['preferences'] = $user['data']['preferences'];


            if (isset($this->input->post['email'])) {
                if ($this->input->post['pass1'] != '') {
                    $this->setPassValidation();
                }
                $this->errors = $this->validator->validateAll($this->input->post);

                $this->pageData['email'] = $this->input->post['email'];
                $this->pageData['pass1'] = $this->input->post['pass1'];
                $this->pageData['pass2'] = $this->input->post['pass2'];
                $this->pageData['first_name'] = $this->input->post['first_name'];
                $this->pageData['last_name'] = $this->input->post['last_name'];
                $this->pageData['mobile_phone'] = $this->input->post['mobile_phone'];
                $this->pageData['allergy'] = $this->input->post['allergy'];
                $this->pageData['preferences'] = (int)$this->input->post['preferences'];
                
                
                
                if (count($this->errors) == 0) {
                    $main_data = Array(
                        'screen_name' => $this->pageData['first_name'] . ' ' . $this->pageData['last_name'],
                        'access' => '@"' . $user_type . (string) str_repeat('0', 49) . '"'
                    );
                    if (trim($this->pageData['pass1']) != '') {
                        $main_data['password'] = $this->pageData['pass1'];
                    }

                    $alergies = implode('', $this->pageData['allergy']);

                    $user_data = Array(
                        'first_name' => $this->db->escape($this->pageData['first_name']),
                        'last_name' => $this->db->escape($this->pageData['last_name']),
                        'mobile_phone' => $this->db->escape($this->pageData['mobile_phone']),
                        'alergies' => '@"' . $alergies . '"',
                        'preferences' => $this->pageData['preferences']
                    
                        
                    );
                    $this->user->update($id, $main_data, $user_data);
                    $this->redirect('admin/' . (($user_type == 1) ? 'administrators' : 'users'));
                }
            }
        } else {
            $this->redirect('admin/' . (($user_type == 1) ? 'administrators' : 'users'));
        }

        $this->html->setTitle($this->short_name . ' administration | Add new user');

        $this->renderPage('admin/users/user_details');
    }

    private function setValidation() {

        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('first_name', Utility\Validator::PATTERN_MAX_LENGTH, 50);

        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('last_name', Utility\Validator::PATTERN_MAX_LENGTH, 50);

        $this->validator->addValidation('mobile_phone', Utility\Validator::PATTERN_MAX_LENGTH, 20);
        $this->validator->addValidation('mobile_phone', Utility\Validator::PATTERN_FORBIDDEN);
    }

    private function setPassValidation() {
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_MIN_LENGTH, 6, 'The password cannot be shorter than 6 characters.');
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_MAX_LENGTH, 20, 'The password cannot be longer than 20 characters.');
        $this->validator->addValidation('pass1', Utility\Validator::PATTERN_REQUIRED, NULL, 'You must provide password');
        $this->validator->addValidation('pass2', Utility\Validator::PATTERN_CUSTOM_FUNCTION, function() {
            return ($this->input->post['pass1'] == $this->input->post['pass2']);
        }, 'The two passwords does not match');
    }

}
