<?php

class Controller extends System\MainController {

    public function init() {

        $this->pageData['users'] = $this->user->getUserList();
        $this->pageData['user_type'] = 0;

        $this->html->setTitle($this->short_name . ' admin | Users management');
        $this->renderPage('admin/users/users');
    }

}
