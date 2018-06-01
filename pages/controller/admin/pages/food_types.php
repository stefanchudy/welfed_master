<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_foods 
     */
    protected $model_foods = Null;

    public function init() {
        $this->setValidation();
        $this->loadModel('foods');

        if (isset($this->input->post['action'])) {
            if ($this->input->post['action'] == 'del') {
                $this->model_foods->delete($this->input->post['id']);
            } else {
                $this->errors = $this->validator->validateAll($this->input->post);

                $this->pageData['title'] = $this->input->post['title'];
                $this->pageData['description'] = $this->input->post['description'];

                if (count($this->errors) == 0) {
                    if ($this->input->post['action'] == 'add') {
                        $this->model_foods->save($this->input->post['parent_id'], $this->input->post['title'], $this->input->post['description']);
                    }
                    if ($this->input->post['action'] == 'edit') {
                        $this->model_foods->update($this->input->post['id'], Array(
                            'title' => $this->input->post['title'],
                            'description' => $this->input->post['description'],
                        ));
                    }
                }
            }
        }

        $this->pageData['foods_tree'] = $this->model_foods->tree();
        
        $this->pageData['html_tree'] = $this->model_foods->build_html_tree();

        $this->html->setTitle($this->short_name . ' | Food types');

        $this->renderPage('admin/pages/food_types');
    }

    private function setValidation() {
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MIN_LENGTH, 3);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MAX_LENGTH, 30);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_CUSTOM_FUNCTION, function($title) {
            return ($this->model_foods->exists($title) === NULL);
        }, 'This entry duplicates another food type in the database.');

        $this->validator->addValidation('description', \Utility\Validator::PATTERN_FORBIDDEN);
    }

}
