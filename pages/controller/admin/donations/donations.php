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
    
    /**
     *
     * @var model_users 
     */
    protected $model_users = Null;

    public function init() {
        date_default_timezone_set('UTC');

        $this->loadModel('donations');
        $this->loadModel('users');

        $this->html->addHeaderTag('<script type="text/javascript" src="js/Countdown.js"></script>');
        
        $this->pageData['donations'] = $this->model_donations->getCollection();
        $this->pageData['users'] = $this->user->getFullList();
                
        $this->html->setTitle($this->short_name . ' Administration | Donations');

        $this->html->render($this->pageData, 'admin/donations/donations');
    }

}
