<?php

class Controller extends System\MainController {

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    public function init() {

        $result = $this->_uploadImage();

        $this->model_api->sendResponse($result);
    }

    private function _uploadImage() {
        $params = $this->model_api->getParams();
//        return array();
        $this->_setFolders();
        $folder = $this->path->upload . 'profile_images';



        $user_id = $params['id'];
        $file_content = base64_decode($params['file_content']);

        $file_info = new SplFileInfo($params['file_name']);

        $filename = $this->path->upload . 'profile_images' . DIRECTORY_SEPARATOR . 'user_' . $user_id . '.' . $file_info->getExtension();

        if (file_exists($filename)) {
            unlink($filename);
        }
        
        

        $handle = fopen($filename, 'w');
        fwrite($handle, $file_content);
        fclose($handle);

        $this->user->update($user_id, array(), array(
            'profile_image' => 'upload/profile_images/user_' . $user_id . '.' . $file_info->getExtension()
        ));

        $query = $this->user->getUserById($user_id);
        
        
        return $this->user->api_getUser($query, $this->model_api->getSiteId());
        

    }

    private function _setFolders() {
        if (!file_exists($this->path->upload)) {
            mkdir($this->path->upload, 0775);
        }
        if (!file_exists($this->path->upload . 'profile_images')) {
            mkdir($this->path->upload . 'profile_images', 0775);
        }
    }

}
