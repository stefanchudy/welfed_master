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

        $this->pageData['slides'] = $this->model_arearestrictions->getCollection();

        $this->html->setTitle($this->short_name . ' | Working areas');
        
        $this->renderPage('admin/slider/slider');
        
    }

}
