<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;

    public function init() {

        $this->pageData['id'] = 'new';

        $this->loadModel('blog')
                ->init_admin();
        $this->_setValidation();

        if (count($this->input->post)) {
            $this->errors = $this->validator->validateAll($this->input->post);
            if (empty($this->errors)) {
                if ($new_id = $this->model_blog->addBlogPost($this->db->escape($this->input->post['title']))) {
                    $this->redirect('admin/blog/edit?id=' . $new_id);
                } else {
                    die('Error : Unable to add record to the blog!');
                }
                
            }
        }



        $this->html->setTitle($this->short_name . ' Administration | Add Blog Post');
        $this->renderPage('admin/blog/details');
    }

    private function _setValidation() {
        $this->validator->clear();
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MIN_LENGTH, 5);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);
    }

}
