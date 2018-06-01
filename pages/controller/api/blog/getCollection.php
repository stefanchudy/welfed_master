<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_blog $model_blog
     */
    protected $model_blog = Null;
    private $_userList = null;

    public function init() {
        $this->loadModel('common');
        $this->loadModel('blog');

        $this->_userList = $this->user->getFullList();

        $this->model_blog
                ->setSiteId((int) $this->model_api->getSiteId());

        if ($this->model_api->getParams('call_mode') != 'admin') {
            $response = $this->_getFrontCollection();
        } else {
            $response = $this->_getAdminCollection();
        }

        $this->model_api->sendResponse($response);
    }

    private function _getFrontCollection() {
        $this->model_blog
                ->init_front($this->model_api->getParams('filter'));

        $data = array(
            'collection' => array(),
            'five' => array(),
            'datelist' => $this->model_blog->getDateList(),
        );        

        foreach ($this->model_blog->getCollection() as $key => $value) {


            $data['collection'][$key] = array(
                'image' => $value['image'],
                'url' => $value['url'],
                'title' => $value['title'],
                'author' => array(
                    'id' => $value['created_by'],
                    'name' => $this->_getUserName($value['created_by'])
                ),
                'date' => $value['date'],
                'content' => $value['content'],
            );
        }

        foreach ($this->model_blog->getFive() as $key => $value) {
            $data['five'][$key] = array(
                'image' => $value['image'],
                'url' => $value['url'],
                'title' => $value['title'],
                'date' => $value['date'],
                'author' => array(
                    'id' => $value['created_by'],
                    'name' => $this->_getUserName($value['created_by'])
                )
            );
        }

        return $data;   
    }

    private function _getAdminCollection() {
        return $this->model_blog->init_admin()->getCollection();
    }

    private function _getUserName($id) {
        $user_name = 'Administrator';

        if (isset($this->_userList[$id])) {
            $user = $this->_userList[$id];
            $user_name = (trim($user['screen_name']) ? $user['screen_name'] : 'Administrator');            
        }
        return $user_name;
    }

}
