<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_locations
     */
    protected $model_locations = Null;

    public function init() {
        $this->loadModel('locations');

        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];            
            if ($location = $this->model_locations->loadLocation($id)) {
                $this->model_locations->verify();
                $this->redirect('admin/locations/edit?id='.$id);
                
            } else {
                $this->redirect('admin/locations');
            }
        } else {
            $this->redirect('admin/locations');
        }

    }

}
