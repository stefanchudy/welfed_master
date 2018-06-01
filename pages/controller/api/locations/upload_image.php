<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_locations $model_locations 
     */
    protected $model_locations = null;
    public function init() {
        $this->loadModel('locations');
        $result = $this->_uploadImage();

        $this->model_api->sendResponse($result);
    }

    private function _uploadImage() {
        $params = $this->model_api->getParams();

        $this->_setFolders();
        $folder = $this->path->upload . 'locations';

        $location_id = $params['id'];
        $file_content = base64_decode($params['file_content']);
        $field = $params['field'];
        
        $file_info = new SplFileInfo($params['file_name']);

        $filename = $this->path->upload . 'locations' . DIRECTORY_SEPARATOR .$field. '_' . $location_id . '.' . $file_info->getExtension();

        if (file_exists($filename)) {
            unlink($filename);
        }

        $handle = fopen($filename, 'w');
        fwrite($handle, $file_content);
        fclose($handle);
        
        $db_record = 'upload/locations/'.$field.'_'.$location_id.'.'.$file_info->getExtension();

        $location = $this->model_locations->loadLocation($location_id);

        $this->model_locations->loadLocation($location_id);
        $this->model_locations->updateLocation(Array($field=>$db_record));
        
        $collection = $this->model_locations->getCollection();
        return array('file'=> $db_record);
        

    }

    private function _setFolders() {
        if (!file_exists($this->path->upload)) {
            mkdir($this->path->upload, 0775);
        }
        if (!file_exists($this->path->upload . 'locations')) {
            mkdir($this->path->upload . 'locations', 0775);
        }
    }

}
