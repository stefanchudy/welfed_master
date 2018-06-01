<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = Null;

    public function init() {
        
        if(isset($this->input->get['id'])){
            $this->loadModel('donations');
            
            if($redirect = $this->model_donations->deleteBooking($this->input->get['id'])){
                $this->redirect('admin/donations/edit?id='.$redirect.'&tab=1');
            } else {
                $this->redirect('admin/donations');
            }
            
        } else {
            $this->redirect('admin/donations');
        }
        

        
    }

}
