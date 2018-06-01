<?php

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

    public function init() {
        $legal_docs = $this->config->legal;
        $url = $this->input->url;

        if (isset($legal_docs[$url])) {
            $this->pageData['header'] = $legal_docs[$url];
            $this->pageData['field'] = $url;

            $this->html->setTitle($this->site_name . '  | '.$legal_docs[$url]);

            $this->renderPage('front/legal/legal');
        } else {
            $this->redirect('');
        }

    }

}
