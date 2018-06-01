<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_donations $model_donations 
     */
    protected $model_donations = null;

    public function init() {

        $this->loadModel('donations');

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];
            $this->model_donations->delete($id);
        }
        $this->redirect('admin/donations');
    }

}
