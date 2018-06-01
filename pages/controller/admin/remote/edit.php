<?php

use Utility\Validator;

Class Controller extends System\MainController {

    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    protected $model_remotesites = null;

    public function init() {
        $this->_setValidation();
        $this->loadModel('remotesites');

        if (isset($this->input->get['id'])) {
            $id = $this->input->get['id'];
            if ($site = $this->model_remotesites->load($id)) {

                if (!empty($this->input->post['remotelist'])) {
                    $post = $this->input->post['remotelist'];
                    $this->errors = $this->validator->validateAll($post);
                    $this->pageData['ip'] = $post['ip'];
                    $this->pageData['name'] = $post['name'];
                    $this->pageData['admin_mail'] = $post['admin_mail'];
                    $this->pageData['token'] = $site['token'];

                    if (empty($this->errors)) {
                        $this->model_remotesites->update($id, $post);                                               
                        $site = $this->model_remotesites->load($id);
                        
                    }
                }

                $this->pageData['id'] = $id;
                $this->pageData['ip'] = $site['ip'];
                $this->pageData['name'] = $site['name'];
                $this->pageData['admin_mail'] = $site['admin_mail'];
                $this->pageData['token'] = $site['token'];
                
            } else {
                $this->redirect('admin/remotelist');
            }
        } else {
            $this->redirect('admin/remotelist');
        }

        $this->renderPage('admin/remote/remote_details');
    }

    private function _setValidation() {
        $this->validator->clear();     

        $this->validator->addValidation('name', Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('name', Validator::PATTERN_FORBIDDEN);
        
        $this->validator->addValidation('admin_mail', Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('admin_mail', Validator::PATTERN_EMAIL);


        return $this;
    }

}
