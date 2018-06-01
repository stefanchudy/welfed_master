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

        $this->pageData['id'] = null;
        $this->pageData['ip'] = '';
        $this->pageData['name'] = '';
        $this->pageData['admin_mail'] = '';
        
        if(!empty($this->input->post['remotelist'])){
            $post = $this->input->post['remotelist'];
            $this->errors = $this->validator->validateAll($post);
            $this->pageData['ip'] = $post['ip'];
            $this->pageData['name'] = $post['name'];
            $this->pageData['admin_mail'] = $post['admin_mail'];
            
            if(empty($this->errors)){
                $save_id = $this->model_remotesites->add($post);
                if($save_id){
                    $this->redirect('admin/remotelist/edit?id='.$save_id);
                } else {
                    \System\Alerts::addError('The site cannot be saved. Try to refresh and save it again.');
                }
            }
            
        }


        $this->renderPage('admin/remote/remote_details');
    }

    private function _setValidation() {
        $this->validator->clear();

        $this->validator->addValidation('ip', Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('ip', Validator::PATTERN_IP);

        $this->validator->addValidation('name', Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('name', Validator::PATTERN_FORBIDDEN);

        $this->validator->addValidation('admin_mail', Validator::PATTERN_REQUIRED);
        $this->validator->addValidation('admin_mail', Validator::PATTERN_EMAIL);

        return $this;
    }

}
