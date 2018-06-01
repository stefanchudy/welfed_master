<?php

use Utility\Validator;

Class Controller extends System\MainController {

    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    protected $model_remotesites = null;

    public function init() {
        $this->loadModel('remotesites');

        if (isset($this->input->get['id'])) {
            $id = $this->input->get['id'];
            $this->model_remotesites->delete($id);
        }
        $this->redirect('admin/remotelist');
    }

}
