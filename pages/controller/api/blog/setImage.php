<?php

class Controller extends System\MainController {

     /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;

    public function init() {

        $this->loadModel('blog');
        $this->model_blog
                ->setSiteId($this->model_api->getSiteId())
                ->init_admin();

        $this->model_api->sendResponse($this->_uploadImage());
    }
    
    private function _uploadImage() {
        $params = $this->model_api->getParams();

        $this->_setFolders();
        $folder = $this->path->upload . 'blog';

        $post_id = $params['id'];
        $file_content = base64_decode($params['file_content']);
        $field = 'image';
        
        $file_info = new SplFileInfo($params['file_name']);

        $filename = $this->path->upload . 'blog' . DIRECTORY_SEPARATOR . 'post_' . $post_id . '.' . $file_info->getExtension();

        if (file_exists($filename)) {
            unlink($filename);
        }

        $handle = fopen($filename, 'w');
        fwrite($handle, $file_content);
        fclose($handle);
        
        $db_record = 'upload/blog/post_'.$post_id.'.'.$file_info->getExtension();

        $this->model_blog->setImage($post_id, $db_record);
        
        return $this->model_blog->getRecord($post_id);
    }

    private function _setFolders() {
        if (!file_exists($this->path->upload)) {
            mkdir($this->path->upload, 0775);
        }
        if (!file_exists($this->path->upload . 'blog')) {
            mkdir($this->path->upload . 'blog', 0775);
        }
    }

}
