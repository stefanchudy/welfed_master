<?php

class Controller extends System\MainController {

    public function init() {
        if ($this->user&&$this->user->logged) {                        
            $this->user->logOff();
            
            $this->redirect('');
        }        
    }

}
