<?php

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {
        $this->html->setTitle('Well Fed Foundation | About us');
        
        $this->renderPage('front/about');
    }

}
