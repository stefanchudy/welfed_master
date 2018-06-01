<?php

class Controller extends System\MainController {

    public function init() {
        $this->setValidation();

        if ((count($this->input->post) != 0)) {

            if ($this->validate()) {
                $this->db_settings->set($this->input->post);
            }
        }

        $this->html->setTitle($this->short_name . ' | Site settings');   

        $this->renderPage('admin/system/general');
    }

      private function validate() {
        $this->errors = $this->validator->validateAll($this->input->post);
        return(count($this->errors) === 0);
    }

    private function setValidation() {
        $this->validator->addValidation('contact_facebook', Utility\Validator::PATTERN_URL);
        $this->validator->addValidation('contact_twitter', Utility\Validator::PATTERN_URL);
        $this->validator->addValidation('contact_instagram', Utility\Validator::PATTERN_URL);

        $this->validator->addValidation('distribution_list', Utility\Validator::PATTERN_CUSTOM_FUNCTION, function() {
            $result = TRUE;
            if (mb_strlen(trim($this->input->post['distribution_list'])) != 0) {
                $split = explode(',', $this->input->post['distribution_list']);
                foreach ($split as $value) {
                    $result = $result && (trim($value) == '') || (filter_var($value, FILTER_VALIDATE_EMAIL) !== false);
                }
            }
            return $result;
        }, 'The distribution list contains invalid email(s)');
        
        $this->validator->addValidation('foods_max_level', \Utility\Validator::PATTERN_NUMBER_ONLY);
        $this->validator->addValidation('foods_max_level', \Utility\Validator::PATTERN_MIN_VALUE,2);
        $this->validator->addValidation('foods_max_level', \Utility\Validator::PATTERN_MAX_VALUE,10);
        
        $this->validator->addValidation('booking_time', \Utility\Validator::PATTERN_NUMBER_ONLY);
        $this->validator->addValidation('booking_time', \Utility\Validator::PATTERN_MIN_VALUE,1);
        $this->validator->addValidation('booking_time', \Utility\Validator::PATTERN_MAX_VALUE,12);
    }

}
