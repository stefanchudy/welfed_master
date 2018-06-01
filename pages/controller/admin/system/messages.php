<?php

/**
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {

        $this->pageData['messages'] = $this->model_common->getMessages();
        if (isset($this->input->get['search'])) {
            $this->pageData['search'] = $this->input->get['search'];
        }
        $this->html->setTitle($this->short_name . ' |Incoming messages');

        $this->html->render($this->pageData, 'admin/system/messages');
    }

}
