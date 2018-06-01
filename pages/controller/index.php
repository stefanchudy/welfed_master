<?php

class Controller extends System\MainController {

     /**
     *
     * @var model_arearestrictions $model_arearestrictions
     */
    protected $model_arearestrictions = null;
    
    public function init() {
        $this->html->setTitle($this->getSiteName());

        $this->loadModel('arearestrictions')->initFront();

        $this->pageData['slider'] = $this->model_arearestrictions->getSlides();

        $this->renderPage('front/index');
    }

}
