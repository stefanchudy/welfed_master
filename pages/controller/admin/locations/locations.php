<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_location_types
     */
    protected $model_location_types = Null;

    /**
     *
     * @var model_locations
     */
    protected $model_locations = Null;

    /**
     *
     * @var model_users 
     */
    protected $model_users = Null;

    public function init() {
        $this->loadModel('location_types');
        $this->loadModel('locations');
//        $this->loadModel('users');

        $this->pageData['types'] = $this->model_location_types->get();
        $this->pageData['locations'] = $this->model_locations->getCollection();
        $this->pageData['users'] = $this->user->getFullList();
        
        $this->html->setTitle($this->short_name . ' Administration');

        $this->html->render($this->pageData, 'admin/locations/locations');
    }

}
