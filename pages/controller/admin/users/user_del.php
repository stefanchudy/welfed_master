<?php

class Controller extends System\MainController {

    public function init() {

        $error = 0;
        if (!isset($this->input->get['id'])) {
            $this->redirect('admin/dashboard');
        }
        $id = $this->input->get['id'];
        $user = $this->user->getUserById($id);
        if ($user === NULL) {
            $this->redirect('admin/dashboard');
        }
        $this->user->deleteUser($id);
        $access = $user['access'][0];
        $this->redirect('admin/' . ($access == 0 ? 'users' : 'administrators'));
    }

}
