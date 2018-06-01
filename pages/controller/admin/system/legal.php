<?php

class Controller extends System\MainController {

    public function init() {
        $this->html->addHeaderTag('<link href="style/jquery-te-1.4.0.css" rel="stylesheet">');
        $this->html->addHeaderTag('<script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>');
        
        if ((count($this->input->post) != 0)) {
            $this->db_settings->set($this->input->post);
        }

        $this->html->setTitle($this->short_name . ' | Terms and conditions');

        $this->renderPage('admin/system/legal');
    }

}
