<?php

class Controller extends System\MainController {
    /**
     *
     * @var model_arearestrictions
     */
    protected $model_arearestrictions = Null;
    
    public function init() {        
        if (isset($this->input->get['id'])) {
            $this->loadModel('arearestrictions')->initAdmin();
            
            $id = (int)$this->input->get['id'];
            
            $this->model_arearestrictions->delete($key);
        }

        $this->redirect('admin/working-areas');
    }

}
