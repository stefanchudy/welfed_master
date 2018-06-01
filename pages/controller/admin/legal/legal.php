<?php

class Controller extends System\MainController {

    public function init() {
        $legal_docs = $this->config->legal;
        $url = str_replace('admin/legal/', '', $this->input->url);
        if (isset($legal_docs[$url])) {
            $this->pageData['header'] = $legal_docs[$url];
            $this->pageData['field'] = $url;
            
            $this->html->addHeaderTag('<link href="style/jquery-te-1.4.0.css" rel="stylesheet">');
            $this->html->addHeaderTag('<script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>');

            if ((count($this->input->post) != 0)) {
                $this->db_settings->set($this->input->post);
            }

            $this->html->setTitle($this->short_name . ' admin | '.$legal_docs[$url]);

            $this->renderPage('admin/legal/legal');
        } else {
            $this->redirect('');
        }
    }

}
