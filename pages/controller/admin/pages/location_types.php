<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_location_types
     */
    protected $model_location_types = Null;

    public function init() {
        $this->setValidation();
        $this->loadModel('location_types');

        if (isset($this->input->post['action'])) {
            if ($this->input->post['action'] == 'del') {
                $this->model_location_types->delete($this->input->post['id']);
            } else {
                $this->errors = $this->validator->validateAll($this->input->post);

                $this->pageData['title'] = $this->input->post['title'];
                $this->pageData['description'] = $this->input->post['description'];

                if (count($this->errors) == 0) {
                    if ($this->input->post['action'] == 'add') {
                        $this->model_location_types->add( $this->input->post['title'], $this->input->post['description']);
                    }
                    if ($this->input->post['action'] == 'edit') {
                        $this->model_location_types->update($this->input->post['id'], $this->input->post['title'], $this->input->post['description']);
                    }
                }
            }
        }

        $this->pageData['location_types'] = $this->model_location_types->getAdminHtml();

        $this->html->setTitle($this->short_name . ' | Location types');

        $this->renderPage('admin/pages/location_types');
    }

    private function setValidation() {
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MIN_LENGTH, 3);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MAX_LENGTH, 30);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_CUSTOM_FUNCTION, function($title) {
            $exists = $this->model_location_types->exists($title);            
            return (($exists === NULL)||($exists==$this->input->post['id']));
        }, 'This entry duplicates another location type in the database.');

        $this->validator->addValidation('description', \Utility\Validator::PATTERN_FORBIDDEN);
    }

}
