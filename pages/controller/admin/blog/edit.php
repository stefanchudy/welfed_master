<?php

class Controller extends System\MainController {

    private $_id = null;

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
        if (isset($this->input->get['id'])) {
            $this->_id = (int) $this->input->get['id'];
            $this->loadModel('blog')
                    ->init_admin();
            
            $this->_setValidation();
            $this->html->addHeaderTag('<link href="style/jquery-te-1.4.0.css" rel="stylesheet">');
            $this->html->addHeaderTag('<script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>');

            if ($this->model_blog->publicationExists($this->_id)) {

                $this->_uploadImage();

                $this->pageData['id'] = $this->_id;

                if (count($this->input->post)) {
                    $this->errors = $this->validator->validateAll($this->input->post);
                    if (empty($this->errors)) {
                        $this->model_blog->updateRecord($this->_id, $this->input->post);
                    }
                }

                $this->pageData['postData'] = $this->model_blog->getRecord($this->_id);
            } else {
                $this->redirect('admin/blog');
            }
        } else {            
            $this->redirect('admin/blog');
        }

        $this->html->setTitle($this->short_name . ' Administration | Edit Blog Post');
        $this->renderPage('admin/blog/details');
    }

    private function _setValidation() {
        $this->validator->clear();
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_FORBIDDEN);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MIN_LENGTH, 5);
        $this->validator->addValidation('title', \Utility\Validator::PATTERN_MUST_NOT_START_WITH_NUMBER);

        $this->validator->addValidation('content', \Utility\Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('content', \Utility\Validator::PATTERN_MIN_LENGTH, 30);
    }

    private function _uploadImage() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload = $this->upload_file('image', 'blog' . DIRECTORY_SEPARATOR . 'post_' . $this->_id);

            if ($upload['success']) {
                $this->model_blog->setImage($this->_id, 'upload/blog/' . $upload['file']);
            } else {
                $this->errors = array_merge($this->errors, $upload['messages']);
            }
        }
    }

}
