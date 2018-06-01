<?php

class Controller extends System\MainController {
    
    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    
    protected $model_remotesites = null;

    public function init() {        

        $this->html->setTitle($this->short_name . ' | Remote sites list');

        $this->loadModel('remotesites');
        $this->pageData['remotelist'] = $this->model_remotesites->getCollection();
        
        $this->renderPage('admin/remote/remotelist');
    }

}