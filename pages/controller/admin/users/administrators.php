<?php

class Controller extends System\MainController {

    public function init() {

        $this->pageData['users'] = $this->user->getAdminList();
        $this->pageData['heading'] = 'Administrator management';
        $this->pageData['user_type'] = 1;

        $this->html->setTitle($this->short_name . ' admin | Users management');

        $this->renderPage('admin/users/users');
    }

}
