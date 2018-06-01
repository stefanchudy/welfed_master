<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_arearestrictions
     */
    protected $model_arearestrictions = Null;

    public function init() {

        $this->loadModel('arearestrictions');
        $this->model_arearestrictions->initAdmin();
        
        $insert_id = $this->model_arearestrictions->add();
        $this->redirect('admin/working-areas/edit?id='.$insert_id);
    }

}
