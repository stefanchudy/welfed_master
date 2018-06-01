<?php

class Controller extends System\MainController {

    private $_id = null;

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;

    public function init() {
        if (isset($this->input->get['id'])) {
            $id = (int) $this->input->get['id'];
            $this->loadModel('blog')
                    ->init_admin();
            
            if ($this->model_blog->publicationExists($id)) {
                $record = $this->model_blog->getRecord($id);
                $image = str_replace('/', DIRECTORY_SEPARATOR, $this->path->www.$record['image']);
                unlink($image);
                $this->model_blog->deleteRecord($id);
            }
        }
        $this->redirect('admin/blog');
    }

}
