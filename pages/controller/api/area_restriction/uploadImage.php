<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_arearestrictions $model_arearestrictions
     */
    protected $model_arearestrictions = null;

    public function init(){
        $this->loadModel('arearestrictions')->setSiteId($this->model_api->getSiteId());
        
        $this->model_arearestrictions->initAdmin();
               
        $this->model_api->sendResponse($this->_uploadImage());
        
    }
    
     private function _uploadImage() {
        $params = $this->model_api->getParams();

        $this->_setFolders();
        $folder = $this->path->upload . 'slides';

        $slide_id = $params['id'];
        $file_content = base64_decode($params['file_content']);
        $field = 'image';
        
        $file_info = new SplFileInfo($params['file_name']);

        $filename = $this->path->upload . 'slides' . DIRECTORY_SEPARATOR . 'slide_' . $slide_id . '.' . $file_info->getExtension();

        if (file_exists($filename)) {
            unlink($filename);
        }

        $handle = fopen($filename, 'w');
        fwrite($handle, $file_content);
        fclose($handle);
        
        $db_record = 'upload/slides/slide_'.$slide_id.'.'.$file_info->getExtension();

        $this->model_arearestrictions->setImage($slide_id, $db_record);                
        
        return $this->model_arearestrictions->getRecord($slide_id);
    }

    private function _setFolders() {
        if (!file_exists($this->path->upload)) {
            mkdir($this->path->upload, 0775);
        }
        if (!file_exists($this->path->upload . 'slides')) {
            mkdir($this->path->upload . 'slides', 0775);
        }
    }

}
