<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_remotesites $model_remotesites 
     */
    protected $model_remotesites = null;

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {

        $this->html->setTitle($this->short_name . ' | Connections log');

        $this->loadModel('api');

        $this->pageData['mode'] = 1;
        if (!isset($this->input->get['filter'])) {
            $this->pageData = array_merge($this->pageData, $this->model_api->getLogList());
        } else {
            $filter = json_decode(base64_decode($this->input->get['filter']), TRUE);
            $this->pageData['mode']+= (int)isset($filter['ip'],$filter['token']);
            $this->pageData['mode']+= (int)isset($filter['origin']);
            $this->pageData['mode']+= (int)isset($filter['call']);
            
            switch ($this->pageData['mode']) {
                case 2 : {
                        $this->pageData = array_merge($this->pageData, $this->model_api->getLogOrigins($filter));
                        break;
                    }
                case 3 : {
                        $this->pageData = array_merge($this->pageData, $this->model_api->getLogSummary($filter));
                        break;
                    }
                case 4 : {
                        $this->pageData = array_merge($this->pageData, $this->model_api->getLogEntry($filter));
                        break;
                    }
                default : {
                        $this->pageData = array_merge($this->pageData, $this->model_api->getLogList());
                        break;
                    }
            }
            
        }
        if (($this->pageData['mode'] != 1) && (count($this->pageData['table']) == 0)) {
//            $this->debug($return_link);
            $this->redirect($this->pageData['return_link']);
        }
        
        $this->renderPage('admin/remote/log');
    }

}
