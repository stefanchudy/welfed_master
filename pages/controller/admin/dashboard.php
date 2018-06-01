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
    /**
     *
     * @var model_donations
     */
    protected $model_donations = Null;

    public function init() {        

        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');
        
        $this->loadModel('locations');
        $this->loadModel('donations');
        $this->pageData['unverified_locations'] = $this->model_locations->getUnverified();
        $this->pageData['active_donations'] = $this->model_donations->getDashboardTable();        

        $this->html->setTitle($this->short_name . ' Administration');

        $this->renderPage('admin/dashboard');
                
    }

}
